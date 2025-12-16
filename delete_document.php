<?php
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_school"; // change if needed

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Validate input
if (empty($_POST['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing record ID.'
    ]);
    exit;
}

$id = intval($_POST['id']); // sanitize

// ✅ Check if table exists before running delete
$check = $conn->query("SHOW TABLES LIKE 'student_documents'");
if ($check->num_rows === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Table `student_documents` does not exist in database `' . $db . '`.'
    ]);
    exit;
}

// ✅ Prepare delete statement with error check
$stmt = $conn->prepare("DELETE FROM student_documents WHERE id = ?");
if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'SQL prepare failed: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Record deleted successfully.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete record: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
