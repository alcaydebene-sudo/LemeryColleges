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
$userPhone = $student['phone'];

// REQUIRED: Application Form
if (empty($_FILES['appPdf']['name'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Application Form (PDF) is required."
    ]);
    exit;
}

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

// Check if student_documents record exists
$check = $conn->prepare("SELECT id FROM student_documents WHERE student_id = ?");
$check->bind_param("s", $student_id);
$check->execute();
$checkResult = $check->get_result();

if ($checkResult->num_rows > 0) {
    // Update existing record
    $updateSql = "UPDATE student_documents SET application_form = ?, uploaded_at = NOW() WHERE student_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $appFilePath, $student_id);
    
    if ($updateStmt->execute()) {
        // Log activity
        $action = "Application form updated.";
        $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
        $log->bind_param("ss", $student_id, $action);
        $log->execute();

        // Send SMS to admin
        $adminPhone = "09652514905";
        $adminMessage = $full_name . " submitted/updated their graduation application form.";
        $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage, $client);

        // Send SMS to student
        $studentMessage = "Your application form has been submitted successfully. You will be notified if any documents are missing.";
        $smsResponseStudent = sendSemaphoreSMS($userPhone, $studentMessage, $client);

        // Log student SMS
        logStudentSMS($conn, $student_id, $studentMessage);

        if (isSMSError($smsResponseAdmin) || isSMSError($smsResponseStudent)) {
            echo json_encode(["status" => "warning", "message" => "Application form submitted but SMS failed."]);
        } else {
            echo json_encode([
                "status" => "success",
                "message" => "Application form submitted successfully. You will be notified if any documents are missing."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database Error: " . $updateStmt->error
        ]);
    }
} else {
    // Insert new record with empty valid_documents
    $validDocsJson = json_encode([]);
    $sql = "INSERT INTO student_documents (student_id, application_form, valid_documents, status, uploaded_at) 
            VALUES (?, ?, ?, 'Under Review', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $appFilePath, $validDocsJson);

    if ($stmt->execute()) {
        // Log activity
        $action = "New application form submitted.";
        $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
        $log->bind_param("ss", $student_id, $action);
        $log->execute();

        // Send SMS to admin
        $adminPhone = "09652514905";
        $adminMessage = $full_name . " submitted a graduation application form.";
        $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage, $client);

        // Send SMS to student
        $studentMessage = "Your application form has been submitted successfully. You will be notified if any documents are missing.";
        $smsResponseStudent = sendSemaphoreSMS($userPhone, $studentMessage, $client);

        // Log student SMS
        logStudentSMS($conn, $student_id, $studentMessage);

        if (isSMSError($smsResponseAdmin) || isSMSError($smsResponseStudent)) {
            echo json_encode(["status" => "warning", "message" => "Application form submitted but SMS failed."]);
        } else {
            echo json_encode([
                "status" => "success",
                "message" => "Application form submitted successfully. You will be notified if any documents are missing."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database Error: " . $stmt->error
        ]);
    }
}
?>

