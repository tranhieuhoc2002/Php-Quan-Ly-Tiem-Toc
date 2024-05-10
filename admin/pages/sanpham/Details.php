<?php
include("../../header_admin.php");
require("../../db_connect.php");

$maSP = $_GET['maSP'];
$sql_sanpham = "SELECT TENSP, DONGIA, SALE, SOLUONG, MOTA, ANH, TENLOAISP, TENTHUONGHIEU
FROM ((sanpham join loaisanpham on sanpham.MALOAISP = loaisanpham.MALOAISP) join thuonghieu on
sanpham.MATH = thuonghieu.MATH)
WHERE sanpham.MASP = '$maSP'";
$result = mysqlI_query($conn,$sql_sanpham);
$row = mysqli_fetch_assoc($result);
?>
<h2 style="text-align:center">Thông tin chi tiết sản phẩm</h2>

<div class="container">
    <hr />
    <dl class="dl-horizontal">
        <dt>
            Tên sản phẩm
        </dt>

        <dd>
            <?php
            echo $row['TENSP'];
            ?>
        </dd>

        <dt>
            Đơn giá
        </dt>

        <dd>
        <?php echo number_format($row['DONGIA']); ?>
        </dd>

        <dt>
            Giá sale
        </dt>

        <dd>
        <?php echo number_format($row['SALE']); ?>
        </dd>

        <dt>
            Số lượng
        </dt>

        <dd>
        <?php
            echo $row['SOLUONG'];
            ?>
        </dd>

        <dt>
            Mô tả
        </dt>

        <dd>
        <?php
            echo $row['MOTA'];
            ?>
        </dd>

        <dt>
            Ảnh
        </dt>

        <dd>
            <img class="" width="30%" src="<?php $anh =$row['ANH']; echo "../../images/sanpham/".$anh ?>  ">
        </dd>

        <dt>
            Loại sản phẩm
        </dt>

        <dd>
        <?php
            echo $row['TENLOAISP'];
            ?>
        </dd>

        <dt>
            Thương hiệu
        </dt>

        <dd>
        <?php
            echo $row['TENTHUONGHIEU'];
            ?>
        </dd>

    </dl>
    <p>
    <a href="./Edit.php?maSP=<?php echo $maSP ?>" class="btn btn-success">Chỉnh sửa</a> 
    <a href="./Index.php" class="btn btn-primary">Trở về trang danh sách</a>
</p>
</div>

<?php
include("../../footer_admin.php");
?>