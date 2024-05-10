<?php
require("../../db_connect.php");

$id = $_POST['id'];
$output = array('list' => '');
$total = 0;

$sql = "SELECT
             h.NGAYTAO AS NGAYTAO,
             c.MAHOADON AS MAHD,               
             p.TENSP AS TENSP,
             c.DONGIAXUAT AS DONGIA,
             c.SOLUONG as SOLUONG,
             (c.DONGIAXUAT * c.SOLUONG) AS 'TONGCONG'
            
         FROM
             chitiethoadon c
             JOIN
             hoadon h ON c.MAHOADON = h.MAHOADON
             JOIN
             sanpham p ON c.MASP = p.MASP
         WHERE c.MAHOADON = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();

$result = $stmt->get_result();
$total = 0;

while ($row = $result->fetch_assoc()) {
    $output['maHD'] = $row['MAHD'];
    $output['ngaytao'] = date('d \t\h\á\n\g m \n\ă\m Y', strtotime($row['NGAYTAO']));
    $subtotal = $row['TONGCONG'];
    $total += $subtotal;
    $output['list'] .= "
        <tr class='prepend_items'>
            <td>" . $row['TENSP'] . "</td>
            <td> " . number_format($row['DONGIA']) . "</td>
            <td>" . $row['SOLUONG'] . "</td>
            <td> " . number_format($subtotal) . "</td>
        </tr>
    ";
}

$output['total'] = '<b> ' . number_format($total, 0) . '<b>';

$stmt->close();
mysqli_close($conn);

echo json_encode($output);
?>
