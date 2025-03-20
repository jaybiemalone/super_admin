<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Get current status
    $query = $conn->prepare("SELECT status FROM complaints WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        $newStatus = ($row['status'] === 'pending') ? 'under investigation' : 
             (($row['status'] === 'under investigation') ? 'resolved' : 'pending');

        $statusColor = ($newStatus === 'resolved') 
            ? 'background-color: green; color: white; border-radius: 8px; padding: 8px 16px; border: none; cursor: pointer; font-size: 14px; text-align: center; display: inline-block;'
            : (($newStatus === 'under investigation')
        ? 'background-color: yellow; color: black; border-radius: 8px; padding: 8px 16px; border: none; cursor: pointer; font-size: 14px; text-align: center; display: inline-block;'
        : 'background-color: red; color: white; border-radius: 8px; padding: 8px 16px; border: none; cursor: pointer; font-size: 14px; text-align: center; display: inline-block;');

        $updateQuery = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
        $updateQuery->bind_param("si", $newStatus, $id);
        $updateQuery->execute();
        
        echo "Status updated to: " . $newStatus;
        header("Location: complaint.php");
        exit();

    } else {
        echo "Record not found.";
    }
    $query->close();
    $updateQuery->close();
}
$conn->close();
?>

