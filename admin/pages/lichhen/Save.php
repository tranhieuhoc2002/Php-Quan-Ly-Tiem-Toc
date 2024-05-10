<?php
require("../../db_connect.php");

$id = $_POST['id'];
$tinhtrang = $_POST['tinhtrang'];


$sql = "UPDATE DATLICH SET TINHTRANGDAT = ? WHERE MADL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $tinhtrang, $id);

if ($stmt->execute()) {
    $output['success'] = true;
} else {
    $output['error'] = $stmt->error;
}

$stmt->close();
mysqli_close($conn);

echo json_encode($output);
?>