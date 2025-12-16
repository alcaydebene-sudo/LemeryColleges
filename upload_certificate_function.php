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
$userPhone = $student['phone']; // ✅ User's phone

// ==================================================
// 🔥 ADDED REQUIRED VALIDATION (Correct Placement)
// ==================================================

// REQUIRED: Application Form
if (empty($_FILES['appPdf']['name'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Application Form (PDF) is required."
    ]);
    exit;
}

// REQUIRED: Check all 5 individual document fields
$requiredDocs = ['doc_f138hs', 'doc_f137', 'doc_birthcert', 'doc_goodmoral', 'doc_shsdiploma'];
$missingDocs = [];

foreach ($requiredDocs as $docField) {
    if (empty($_FILES[$docField]['name']) || $_FILES[$docField]['error'] !== 0) {
        $docName = str_replace(['doc_', '_'], ['', ' '], $docField);
        $docName = ucwords($docName);
        if ($docField === 'doc_f138hs') $docName = 'F138 HS';
        if ($docField === 'doc_f137') $docName = 'F137';
        if ($docField === 'doc_birthcert') $docName = 'Birth Certificate';
        if ($docField === 'doc_goodmoral') $docName = 'Good Moral';
        if ($docField === 'doc_shsdiploma') $docName = 'SHS Diploma';
        $missingDocs[] = $docName;
    }
}

if (!empty($missingDocs)) {
    echo json_encode([
        "status" => "error",
        "message" => "Please upload all required documents. Missing: " . implode(', ', $missingDocs)
    ]);
    exit;
}

// ==================================================

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// ==== File size limit (100MB) ====
$maxSize = 100 * 1024 * 1024;

// ==== Application Form ====
$appFilePath = "";
if (isset($_FILES['appPdf']) && $_FILES['appPdf']['error'] === 0) {
    if ($_FILES['appPdf']['size'] > $maxSize) {
        echo json_encode(["status" => "error", "message" => "Application Form exceeds 100MB limit."]);
        exit;
    }

    $appFileName = time() . "_app_" . basename($_FILES['appPdf']['name']);
    $appFilePath = $uploadDir . $appFileName;

    if (!move_uploaded_file($_FILES['appPdf']['tmp_name'], $appFilePath)) {
        echo json_encode(["status" => "error", "message" => "Error uploading Application Form."]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Please upload Application Form (PDF)."]);
    exit;
}

// ==== Valid Documents - Process individual document fields ====
$validDocsPaths = [];
$docTypeMapping = [
    'doc_f138hs' => 'F138 HS',
    'doc_f137' => 'F137',
    'doc_birthcert' => 'Birth Certificate',
    'doc_goodmoral' => 'Good Moral',
    'doc_shsdiploma' => 'SHS Diploma'
];

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
        $fileName = time() . "_" . strtolower(str_replace(' ', '_', $docType)) . "_" . uniqid() . "." . $fileExt;
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
            // Store with document type as key for easy identification
            $validDocsPaths[$docType] = $filePath;
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => "Error uploading " . $docType . "."
            ]);
            exit;
        }
    }
}

// Convert to JSON - store as associative array to preserve document types
$validDocsJson = json_encode($validDocsPaths);

// ✅ PREVENT DUPLICATE SUBMISSION
$check = $conn->prepare("SELECT id FROM student_documents WHERE student_id = ?");
$check->bind_param("s", $student_id);
$check->execute();
$checkResult = $check->get_result();
if ($checkResult->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "You have already submitted your documents."
    ]);
    exit;
}
$check->close();

// ==== Insert into DB ====
$sql = "INSERT INTO student_documents (student_id, application_form, valid_documents, status, uploaded_at) 
        VALUES (?, ?, ?, 'Under Review', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $student_id, $appFilePath, $validDocsJson);

if ($stmt->execute()) {
    // Log activity
    $action = "New application has been submitted with valid documents.";
    $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
    $log->bind_param("ss", $student_id, $action);
    $log->execute();

    // SMS to admin
    $adminPhone = "09652514905";
    $adminMessage = $full_name . " submitted a graduation application.";
    $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage, $client);

    // SMS to student
    $studentMessage = "Documents submitted successfully. Your documents are under review.";
    $smsResponseStudent = sendSemaphoreSMS($userPhone, $studentMessage, $client);

    // Log student SMS
    logStudentSMS($conn, $student_id, $studentMessage);

    if (isSMSError($smsResponseAdmin) || isSMSError($smsResponseStudent)) {
        echo json_encode(["status" => "warning", "message" => "Application submitted but SMS failed."]);
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "Documents submitted successfully. Your documents are under review."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database Error: " . $stmt->error
    ]);
}
?>
