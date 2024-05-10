<?php
include("../../header_admin.php");
include("../../db_connect.php");

$loaisp = mysqli_query($conn, "SELECT * FROM loaisanpham");

?>
<div class="container">
        <h2 style="text-align:center">Danh sách danh mục sản phẩm</h2>
        
        <div class="d-flex justify-content-between">
                <a href="Create.php" class="btn btn-primary m-2">Thêm loại sản phẩm</a>
        </div>
        <table class="table">
                <tr align="center">
                        <th>Mã loại sản phẩm</th>
                        <th>
                                Tên loại sản phẩm
                        </th>
                        <th>
                                Chức năng
                        </th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($loaisp)) {
                        ?>
                        <tr align="center">
                                <td>
                                        <?php echo $row['MALOAISP'] ?>
                                </td>
                                <td>
                                        <?php echo $row['TENLOAISP'] ?>
                                </td>
                                <td>
                                <a href="./Edit.php?id=<?php echo $row['MALOAISP'] ?>"><button class='btn btn-success btn-sm edit btn-flat'><i class='fa fa-edit'></i> Sửa</button></a>
                                <a href="./Delete.php?id=<?php echo $row['MALOAISP'] ?>"><button class='btn btn-danger btn-sm delete btn-flat'><i class='fa fa-trash'></i> Xoá</button></a>
                              
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