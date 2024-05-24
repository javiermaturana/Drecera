<?php
include 'core/db.php';

$stmt = $conn->prepare("SELECT short_code FROM urls");
$stmt->execute();
$result = $stmt->get_result();

$aliases = [];
while ($row = $result->fetch_assoc()) {
    $aliases[] = $row['short_code'];
}

echo json_encode($aliases);
?>
