<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // 🔎 Fetch record first to know which files to delete
    $sql = "SELECT application_form, valid_documents FROM student_documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $appForm = $row['application_form'];
        $validDocs = json_decode($row['valid_documents'], true);

        // 🗑 Delete application form file
        if ($appForm && file_exists($appForm)) {
            unlink($appForm);
        }

        // 🗑 Delete valid documents
        if ($validDocs && is_array($validDocs)) {
            foreach ($validDocs as $doc) {
                if ($doc && file_exists($doc)) {
                    unlink($doc);
                }
            }
        }

        // ❌ Delete record from DB
        $deleteSql = "DELETE FROM student_documents WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            $_SESSION['delete_success'] = "Application deleted successfully.";

            // ✅ Log the activity
            if (isset($_SESSION['student_id'])) {
                $student_id = $_SESSION['student_id'];
                $action = "An application has been deleted along with its documents.";
                $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
                $log->bind_param("ss", $student_id, $action);
                $log->execute();
            }

        } else {
            $_SESSION['delete_error'] = "Failed to delete application from database.";
        }
    } else {
        $_SESSION['delete_error'] = "Record not found.";
    }
} else {
    $_SESSION['delete_error'] = "Invalid request.";
}

// 🔙 Redirect back
header("Location: student_application_status.php"); // change to your table page filename
exit;
