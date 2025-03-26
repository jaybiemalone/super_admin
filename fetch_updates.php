<?php
// fetch_updates.php
include 'config.php';
header('Content-Type: application/json');

$sql = "SELECT name, `update` FROM maintenance ORDER BY id DESC";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode($data);
?>
