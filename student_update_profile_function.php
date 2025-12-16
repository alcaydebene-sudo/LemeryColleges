<?php
session_start();
include 'connection.php';

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name  = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $password   = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch old data first (to compare changes)
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();

    // Track what changed
    $changes = [];

    // --- Handle profile image upload ---
    $profileImage = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                $profileImage = $fileName;
                $changes[] = "Profile picture updated";
            }
        }
    }

    // --- Handle password update ---
    $hashedPassword = null;
    if (!empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            header("Location: student_user_profile.php?status=password_mismatch");
            exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $changes[] = "Password changed";
    }

    // Compare old data with new
    if ($email !== $old['email']) $changes[] = "Email updated";
    if ($phone !== $old['phone']) $changes[] = "Phone number updated";
    if ($full_name !== $old['full_name']) $changes[] = "Full name updated";

    // --- Build SQL dynamically ---
    $query = "UPDATE students SET full_name = ?, email = ?, phone = ?";
    $params = [$full_name, $email, $phone];
    $types = "sss";

    if ($hashedPassword) {
        $query .= ", password = ?";
        $params[] = $hashedPassword;
        $types .= "s";
    }

    if ($profileImage) {
        $query .= ", profile_image = ?";
        $params[] = $profileImage;
        $types .= "s";
    }

    $query .= " WHERE student_id = ?";
    $params[] = $student_id;
    $types .= "s";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // update session name
        $_SESSION['full_name'] = $full_name;

        // --- Log each change ---
        foreach ($changes as $action) {
            $log = $conn->prepare("INSERT INTO activity_logs (student_id, action) VALUES (?, ?)");
            $log->bind_param("ss", $student_id, $action);
            $log->execute();
        }

        header("Location: student_user_profile.php?status=success");
        exit;
    } else {
        header("Location: student_user_profile.php?status=error");
        exit;
    }
}
?>
