<?php
require("../../db_connect.php");

$id = $_POST['id'];

$sql = "SELECT
            NGAYDEN,
            MADL,
            TINHTRANGDAT
        FROM
            DATLICH
        WHERE MADL = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $output['maDL'] = $row['MADL'];
    $output['ngayDEN'] = date('d \t\h\á\n\g m \n\ă\m Y', strtotime($row['NGAYDEN']));
    $output['tinhtrang'] = $row['TINHTRANGDAT'];
}

$stmt->close();
mysqli_close($conn);

echo json_encode($output);
?>