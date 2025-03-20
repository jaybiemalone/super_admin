<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['new_status'])) {
    $user_id = intval($_POST['user_id']); // Convert ID to integer for security
    $new_status = $_POST['new_status'] === 'active' ? 'active' : 'disabled'; // Ensure valid status

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE user_form SET account_status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $user_id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: user.php?status=success"); // Redirect back with success message
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid request!";
}

?>
