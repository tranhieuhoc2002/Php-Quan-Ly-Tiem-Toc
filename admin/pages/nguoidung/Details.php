<?php
include("../../header_admin.php");
require("../../db_connect.php");

$maND = $_GET['maND'];
$sql_nguoidung = "SELECT * FROM nguoidung where MAND= '$maND'";
$result = mysqlI_query($conn,$sql_nguoidung);
$row = mysqli_fetch_assoc($result);
?>
<h2 style="text-align:center">Thông tin người dùng</h2>

<div class="container">
    <hr />
    <dl class="dl-horizontal">
        <dt>
            Mã người dùng

        </dt>

        <dd>
            <?php
            echo  $row['MAND'];
            ?>
        </dd>

        <dt>
            Tên người dùng

        </dt>

        <dd>
            <?php
            echo $row['TENND'];
            ?>
        </dd>

        <dt>
            Email
        </dt>
        <dd>
        <?php echo $row['EMAIL']; ?>
        </dd>

        <dt>
            Mật khẩu
        </dt>

        <dd>
        <?php echo $row['MATKHAU']; ?>
        </dd>

        <dt>
            Giới tính
        </dt>

        <dd>
        <?php
            echo $row['GIOITINH'];
            ?>
        </dd>

        <dt>
            Số điện thoại
        </dt>

        <dd>
        <?php
            echo $row['SDT'];
            ?>
        </dd>

        <dt>
            Địa chỉ
        </dt>

        <dd>
        <?php
            echo $row['DIACHI'];
            ?>
        </dd>

        <dt>
            Phân quyền
        </dt>

        <dd>
        <?php 
            if($row['ISADMIN'] == 1) {
                echo "Admin";
            } else {
                echo "Khách hàng";
            }
        ?>
        </dd>


    </dl>
    <p>
    <a href="./Edit.php?maND=<?php echo $maND ?>" class="btn btn-success">Chỉnh sửa</a> 
    <a href="./Index.php" class="btn btn-primary">Trở về trang danh sách</a>
</p>
</div>

<?php
include("../../footer_admin.php");
?>