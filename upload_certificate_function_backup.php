<?php
session_start();
include "connection.php";
require_once('vendor/autoload.php'); // ✅ Point to vendor directory

use Semaphore\SemaphoreClient;

// ✅ Semaphore API
$semaphoreApiKey = 'cbe45a044966d9bffdd436fcf66f1a8b';
$client = new SemaphoreClient($semaphoreApiKey);

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

// ✅ Upload dir
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

// ==== Valid Documents ====
$validDocsPaths = [];
if (isset($_FILES['validDocs'])) {
    foreach ($_FILES['validDocs']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['validDocs']['error'][$index] === 0) {
            if ($_FILES['validDocs']['size'][$index] > $maxSize) {
                echo json_encode(["status" => "error", "message" => $_FILES['validDocs']['name'][$index] . " exceeds 100MB limit."]);
                exit;
            }

            $fileName = time() . "_doc_" . basename($_FILES['validDocs']['name'][$index]);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($tmpName, $filePath)) {
                $validDocsPaths[] = $filePath;
            }
        }
    }
}
$validDocsJson = json_encode($validDocsPaths);

// ==== Insert into DB ====
$sql = "INSERT INTO student_documents (student_id, application_form, valid_documents, status, uploaded_at) 
        VALUES (?, ?, ?, 'Under Review', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $student_id, $appFilePath, $validDocsJson);

if ($stmt->execute()) {
    // ✅ Log the activity
    $action = "New application has been submitted with valid documents.";
    $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
    $log->bind_param("ss", $student_id, $action);
    $log->execute();
    
    // ✅ Send SMS Notification to admin
    $adminPhone = "09652514905"; 
    $adminMessage = $full_name . " submitted a graduation application.";
    $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage, $client);

    // ✅ Send SMS Notification to student
    $studentMessage = "Documents submitted successfully. Your documents are under review.";
    $smsResponseStudent = sendSemaphoreSMS($userPhone, $studentMessage, $client);

    // ✅ Log student SMS (save adminMessage instead of studentMessage)
    $smsLog = $conn->prepare("INSERT INTO student_sms_logs (student_id, message) VALUES (?, ?)");
    $smsLog->bind_param("ss", $student_id, $adminMessage);
    $smsLog->execute();

    if (strpos($smsResponseAdmin, 'Curl error') !== false || strpos($smsResponseStudent, 'Curl error') !== false) {
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

// ✅ SMS Function
function sendSemaphoreSMS($phoneNumber, $message, $client) {
    $ch = curl_init();
    $parameters = array(
        'apikey' => $client->apiKey,
        'number' => $phoneNumber,
        'message' => $message,
        'sendername' => 'LEMCOLLEGES'
    );

    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    if ($output === false) {
        $error = 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        return $error;
    }

    curl_close($ch);
    return $output;
}
?>
