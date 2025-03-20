<?php
include 'config.php'; // Include database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize ID input

    // Check which table the record exists in and fetch file path
    $tables = ['file_management'];
    $file_path = null;

    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT file_path FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_path = $row['file_path'];

            // Delete the file from the server if it exists
            if ($file_path && file_exists($file_path)) {
                if (unlink($file_path)) {
                    echo "File successfully deleted from server.<br>";
                } else {
                    echo "Error deleting the file from server.<br>";
                }
            } else {
                echo "File not found on server.<br>";
            }

            // Delete the record from the current table
            $delete_stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
            $delete_stmt->bind_param("i", $id);
            if ($delete_stmt->execute()) {
                echo "Record successfully deleted from database.";
            } else {
                echo "Error deleting record from database.";
            }
            $delete_stmt->close();

            // Redirect with a success message
            header("Location: file.php?success=1");
            exit;
        }
        $stmt->close();
    }

    // If no matching record was found
    echo "File not found in any table.";
} else {
    echo "Invalid request.";
}

$conn->close();
?>
