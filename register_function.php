<?php
session_start();
include "connection.php"; // Make sure this connects to your database
include "includes/sms_functions.php"; // Include SMS functions

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $full_name     = trim($_POST['full_name']);
    $course        = $_POST['course'];
    $section       = $_POST['section'];
    $year          = $_POST['year']; // ✅ added year
    $email         = trim($_POST['email']);
    $student_id    = trim($_POST['student_id']);
    $phone         = trim($_POST['phone']);
    $password      = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        // Save form data to session to preserve user input
        $_SESSION['register_form_data'] = [
            'full_name' => $full_name,
            'course' => $course,
            'section' => $section,
            'year' => $year,
            'email' => $email,
            'student_id' => $student_id,
            'phone' => $phone
        ];
        header("Location: student_register.php?status=password_mismatch");
        exit;
    }

    // Check if student ID or email already exists
    $checkSql = "SELECT * FROM students WHERE student_id=? OR email=?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("ss", $student_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Save form data to session to preserve user input
        $_SESSION['register_form_data'] = [
            'full_name' => $full_name,
            'course' => $course,
            'section' => $section,
            'year' => $year,
            'email' => $email,
            'student_id' => $student_id,
            'phone' => $phone
        ];
        header("Location: student_register.php?status=exists");
        exit;
    }

    // Handle profile image upload
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $profile_image = $file_name;
        } else {
            header("Location: student_register.php?status=sql_error");
            exit;
        }
    }

    // Handle COR file upload
    $cor_file = null;
    if (isset($_FILES['cor_file']) && $_FILES['cor_file']['error'] === 0) {
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['cor_file']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_name = time() . '_cor_' . basename($_FILES['cor_file']['name']);
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($_FILES['cor_file']['tmp_name'], $target_file)) {
                $cor_file = $file_name;
            } else {
                header("Location: student_register.php?status=sql_error");
                exit;
            }
        } else {
            header("Location: student_register.php?status=sql_error");
            exit;
        }
    } else {
        // COR file is required
        header("Location: student_register.php?status=sql_error");
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert into database with year and COR file included
    $insertSql = "INSERT INTO students (full_name, course, section, year, email, student_id, phone, password, profile_image, cor_file) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssssssssss", $full_name, $course, $section, $year, $email, $student_id, $phone, $hashed_password, $profile_image, $cor_file);

    if ($stmt->execute()) {
        // Send SMS to admin
        $adminPhone = "09652514905";
        $adminMessage = $full_name . " (" . $student_id . ") has successfully registered for graduation application.";
        $smsResponseAdmin = sendSemaphoreSMS($adminPhone, $adminMessage);
        
        // Send SMS to student
        $studentMessage = "Welcome " . $full_name . "! Your account is pending approval. You will be able to log in once it is approved.";
        $smsResponseStudent = sendSemaphoreSMS($phone, $studentMessage);
        
        // Log student SMS
        logStudentSMS($conn, $student_id, $studentMessage);
        
        // Redirect to success page (SMS errors won't block registration)
        header("Location: student_register.php?status=success");
        exit;
    } else {
        header("Location: student_register.php?status=sql_error");
        exit;
    }

} else {
    // If accessed directly, redirect to register page
    header("Location: student_register.php");
    exit;
}
?>
