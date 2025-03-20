<?php
session_start();
include 'config.php';

if (!isset($_GET['id']) || !isset($_GET['password'])) {
    echo "<script>alert('Invalid request.'); window.location.href='file.php';</script>";
    exit();
}

$fileId = intval($_GET['id']);
$password = $_GET['password'];

$stmt = $conn->prepare("SELECT file_path, file_password FROM file_management WHERE id = ?");
$stmt->bind_param("i", $fileId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('File not found.'); window.location.href='file.php';</script>";
    exit();
}

$row = $result->fetch_assoc();

if (password_verify($password, $row['file_password'])) {
    // Allow download
    $filePath = $row['file_path'];
    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    } else {
        echo "<script>alert('File not found on server.'); window.location.href='file.php';</script>";
    }
} else {
    echo "<script>alert('Invalid password.'); window.location.href='file.php';</script>";
}

$stmt->close();
$conn->close();
?>