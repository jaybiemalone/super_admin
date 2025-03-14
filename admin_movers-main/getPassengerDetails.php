<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to retrieve passenger details
    $sql = "SELECT user, id, email, ticket, dstatus, dtext, ddate FROM passenger WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // assuming id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $passenger = $result->fetch_assoc();
        echo json_encode($passenger);
    } else {
        echo json_encode(["error" => "No results found."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "No ID provided."]);
}
$conn->close();
?>