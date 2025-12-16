<?php
session_start();
include "connection.php";
require_once(__DIR__ . '/includes/sms_functions.php');

// Initialize Semaphore client
$client = getSemaphoreClient();

header('Content-Type: application/json');

// ✅ Verify student session
$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    echo json_encode(["status" => "error", "message" => "Student ID not found in session."]);
    exit;
}

// ✅ Get student full name and phone number
$studentQuery = $conn->prepare("SELECT full_name, phone FROM students WHERE student_id = ?");
$studentQuery->bind_param("s", $student_id);
$studentQuery->execute();
$studentResult = $studentQuery->get_result();

if ($studentResult->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Student not found."]);
    exit;
}
$student = $studentResult->fetch_assoc();
$full_name = $student['full_name'];
$userPhone = $student['phone']; // ✅ Student phone number

// ✅ Check if record ID is provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(["status" => "error", "message" => "Missing record ID."]);
    exit;
}
$id = intval($_POST['id']);

// ✅ Upload settings
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
$maxSize = 100 * 1024 * 1024; // 100MB

// === Get existing valid_documents from database ===
$getExisting = $conn->prepare("SELECT valid_documents FROM student_documents WHERE id = ?");
$getExisting->bind_param("i", $id);
$getExisting->execute();
$existingResult = $getExisting->get_result();
$existingRow = $existingResult->fetch_assoc();
$getExisting->close();

// Parse existing documents (could be associative array or numeric array)
$existingDocs = [];
if (!empty($existingRow['valid_documents'])) {
    $existingDocs = json_decode($existingRow['valid_documents'], true);
    if (!is_array($existingDocs)) {
        $existingDocs = [];
    }
}

// === Determine which fields to update ===
$updateFields = [];
$updateParams = [];
$paramTypes = "";

// === Valid Documents - Process individual document fields ===
$docTypeMapping = [
    'doc_f138hs' => 'F138 HS',
    'doc_f137' => 'F137',
    'doc_birthcert' => 'Birth Certificate',
    'doc_goodmoral' => 'Good Moral',
    'doc_shsdiploma' => 'SHS Diploma',
    'doc_2x2picture' => '2x2 Picture'
];

$updatedDocs = $existingDocs; // Start with existing documents

foreach ($docTypeMapping as $fieldName => $docType) {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === 0) {
        // Check file size
        if ($_FILES[$fieldName]['size'] > $maxSize) {
            echo json_encode([
                "status" => "error", 
                "message" => $docType . " exceeds 100MB limit."
            ]);
            exit;
        }

        // Create filename with document type identifier
        $originalName = basename($_FILES[$fieldName]['name']);
        $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
        $fileName = time() . "_update_" . strtolower(str_replace(' ', '_', $docType)) . "_" . uniqid() . "." . $fileExt;
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
            // Update or add the document (preserve associative array format)
            $updatedDocs[$docType] = $filePath;
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => "Error uploading " . $docType . "."
            ]);
            exit;
        }
    }
}

// Only update if documents were changed
if ($updatedDocs !== $existingDocs) {
    $validDocsJson = json_encode($updatedDocs);
    $updateFields[] = "valid_documents = ?";
    $updateParams[] = $validDocsJson;
    $paramTypes .= "s";
}

// ✅ If nothing to update, return
if (empty($updateFields)) {
    echo json_encode(["status" => "warning", "message" => "No files selected. Nothing to update."]);
    exit;
}

// ✅ Always update status to "Under Review" and uploaded_at
$updateFields[] = "status = 'Under Review'";
$updateFields[] = "uploaded_at = NOW()";

// ✅ Build query
$sql = "UPDATE student_documents SET " . implode(", ", $updateFields) . " WHERE id = ?";
$updateParams[] = $id;
$paramTypes .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($paramTypes, ...$updateParams);

if ($stmt->execute()) {
    // ✅ Log the activity
    $action = "Updated application documents.";
    $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
    $log->bind_param("ss", $student_id, $action);
    $log->execute();

    // ✅ Send SMS Notification to admin
    $adminPhone = "09652514905";
    $adminMessage = $full_name . " updated their graduation documents.";
    $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage, $client);

    // ✅ Send SMS Notification to student
    $studentMessage = "Your documents have been successfully updated and are now under review.";
    $smsResponseStudent = sendSemaphoreSMS($userPhone, $studentMessage, $client);

    // ✅ Log student SMS
    logStudentSMS($conn, $student_id, $studentMessage);

    if (isSMSError($smsResponseAdmin) || isSMSError($smsResponseStudent)) {
        echo json_encode(["status" => "warning", "message" => "Documents updated but SMS failed."]);
    } else {
        echo json_encode(["status" => "success", "message" => "Documents updated successfully and notifications sent."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $stmt->error]);
}
?>
