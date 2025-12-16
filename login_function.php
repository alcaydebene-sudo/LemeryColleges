<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginId  = trim($_POST['loginId']);  // student_id or email
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ? OR email = ?");
    $stmt->bind_param("ss", $loginId, $loginId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Check if account status is 'for approval'
        if ($row['status'] === 'for approval') {
            header("Location: student_login.php?status=for_approval");
            exit;
        }

        // Check password
        if (password_verify($password, $row['password'])) {
            // Save session
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['full_name']  = $row['full_name'];
            header("Location: student_dashboard.php");
            exit;
        } else {
            header("Location: student_login.php?status=invalid");
            exit;
        }
    } else {
        header("Location: student_login.php?status=no_account");
        exit;
    }
}
?>
