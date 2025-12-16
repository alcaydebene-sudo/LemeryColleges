<?php
session_start();
include "connection.php";
require_once(__DIR__ . '/includes/sms_functions.php');

// Initialize Semaphore client
$client = getSemaphoreClient();

header('Content-Type: application/json');

// ✅ Student ID must be a string
$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    echo json_encode(["status" => "error", "message" => "Student ID not found in session."]);
    exit;
}

// Get document ID
$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
if (!$id) {
    echo json_encode(["status" => "error", "message" => "Document ID is required."]);
    exit;
}

// Verify this document belongs to the logged-in student
$verifyStmt = $conn->prepare("SELECT sd.id, sd.valid_documents, sd.admin_checklist_status, s.full_name, s.phone 
                              FROM student_documents sd 
                              JOIN students s ON sd.student_id = s.student_id 
                              WHERE sd.id = ? AND sd.student_id = ?");
$verifyStmt->bind_param("is", $id, $student_id);
$verifyStmt->execute();
$verifyResult = $verifyStmt->get_result();

if ($verifyResult->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Document not found or access denied."]);
    exit;
}

$docRow = $verifyResult->fetch_assoc();
$full_name = $docRow['full_name'];
$userPhone = $docRow['phone'];

// Get existing documents
$existingDocs = [];
$existingDocsJson = $docRow['valid_documents'];
if (!empty($existingDocsJson)) {
    $existingDocsArray = json_decode($existingDocsJson, true);
    if (is_array($existingDocsArray)) {
        $existingDocs = $existingDocsArray;
    }
}

// Get admin checklist to determine which documents are missing
$adminChecklist = [];
$adminChecklistJson = isset($docRow['admin_checklist_status']) ? $docRow['admin_checklist_status'] : '{}';
if (!empty($adminChecklistJson) && $adminChecklistJson !== '{}') {
    $adminChecklistArray = json_decode($adminChecklistJson, true);
    if (is_array($adminChecklistArray)) {
        $adminChecklist = $adminChecklistArray;
    }
}

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$maxSize = 5 * 1024 * 1024; // 5MB per file

// Document field mapping
$docTypeMapping = [
    'doc_f138hs' => 'F138 HS',
    'doc_f137' => 'F137',
    'doc_birthcert' => 'Birth Certificate',
    'doc_goodmoral' => 'Good Moral',
    'doc_shsdiploma' => 'SHS Diploma',
    'doc_2x2picture' => '2x2 Picture'
];

$updatedDocs = $existingDocs;
$uploadedCount = 0;

// Process uploaded files
foreach ($docTypeMapping as $fieldName => $docType) {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === 0 && !empty($_FILES[$fieldName]['name'])) {
        $file = $_FILES[$fieldName];
        
        // Validate file type (2x2 Picture only accepts images)
        if ($fieldName === 'doc_2x2picture') {
            if (strpos($file['type'], "image/") !== 0) {
                echo json_encode([
                    "status" => "error",
                    "message" => "$docType must be an Image file."
                ]);
                exit;
            }
        } else {
            if (!($file['type'] === "application/pdf" || strpos($file['type'], "image/") === 0)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "$docType must be a PDF or Image file."
                ]);
                exit;
            }
        }
        
        // Validate file size
        if ($file['size'] > $maxSize) {
            echo json_encode([
                "status" => "error",
                "message" => "$docType exceeds 5MB limit. Please upload a smaller file."
            ]);
            exit;
        }
        
        // Upload file
        $fileName = time() . "_" . strtolower(str_replace(' ', '_', $docType)) . "_" . basename($file['name']);
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $updatedDocs[$docType] = $filePath;
            $uploadedCount++;
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error uploading $docType."
            ]);
            exit;
        }
    }
}

if ($uploadedCount === 0) {
    echo json_encode([
        "status" => "warning",
        "message" => "No files selected. Please select at least one document to upload."
    ]);
    exit;
}

// Update database
$validDocsJson = json_encode($updatedDocs);
$updateSql = "UPDATE student_documents SET valid_documents = ?, status = 'Under Review', uploaded_at = NOW() WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("si", $validDocsJson, $id);

if ($updateStmt->execute()) {
    // Log activity
    $action = "Updated missing documents.";
    $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
    $log->bind_param("ss", $student_id, $action);
    $log->execute();

    // Send SMS to admin
    $adminPhone = "09652514905";
    $adminMessage = $full_name . " uploaded missing documents.";
    $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage, $client);

    // Send SMS to student
    $studentMessage = "Your missing documents have been uploaded successfully and are now under review.";
    $smsResponseStudent = sendSemaphoreSMS($userPhone, $studentMessage, $client);

    // Log student SMS
    logStudentSMS($conn, $student_id, $studentMessage);

    if (isSMSError($smsResponseAdmin) || isSMSError($smsResponseStudent)) {
        echo json_encode([
            "status" => "warning",
            "message" => "Documents uploaded successfully but SMS notification failed."
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "Missing documents uploaded successfully. Your application is now under review."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database Error: " . $updateStmt->error
    ]);
}
?>

