<?php
include("../../header_admin.php");
include("../../db_connect.php");

$loaidv = mysqli_query($conn, "SELECT * FROM dichvu");

?>
<div class="container">
        <h2 style="text-align:center">Danh sách loại dịch vụ</h2>
        
        <div class="d-flex justify-content-between">
                <a href="Create.php" class="btn btn-primary m-2">Thêm dịch vụ</a>
        </div>
        <table class="table">
                <tr align="center">
                        <th>Mã dịch vụ</th>
                        <th>
                                Tên dịch vụ
                        </th>
                        <th>
                                Chức năng
                        </th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($loaidv)) {
                        ?>
                        <tr align="center">
                                <td>
                                        <?php echo $row['MADV'] ?>
                                </td>
                                <td>
                                        <?php echo $row['TENDV'] ?>
                                </td>
                                <td>
                                <a href="./Edit.php?id=<?php echo $row['MADV'] ?>"><button class='btn btn-success btn-sm edit btn-flat'><i class='fa fa-edit'></i> Sửa</button></a>
                                <a href="./Delete.php?id=<?php echo $row['MADV'] ?>"><button class='btn btn-danger btn-sm delete btn-flat'><i class='fa fa-trash'></i> Xoá</button></a>
                              
                            </td>
                        </tr>
                        <?php
                }
                ?>
        </table>
</div>

<?php
include("../../footer_admin.php");
?>