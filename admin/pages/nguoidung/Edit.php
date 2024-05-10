<?php
require("../../db_connect.php");
include("../../header_admin.php");

$maND = $_GET['maND'];
$sql = "SELECT * FROM nguoidung WHERE nguoidung.MAND = '$maND'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

function isUserExists($conn, $tenND, $maND) {
    $tenND = mysqli_real_escape_string($conn, $tenND);
    $maND = mysqli_real_escape_string($conn, $maND);
    $sql = "SELECT COUNT(*) as count FROM nguoidung WHERE TENND = '$tenND' AND MAND != '$maND'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$isadmin = isset($_POST['ISADMIN']);

if (isset($_POST['tenND'])) $tenND = $_POST["tenND"];
if (isset($_POST["luu"])) {
    if (!isUserExists($conn, $tenND, $maND)) {
        $sql = "UPDATE nguoidung SET TENND = '" . $_POST['tenND'] . "', EMAIL = '" . $_POST['EMAIL'] . "', SDT = '" . $_POST['sdt'] ."', 
        DIACHI = '" . $_POST['diachi']. "', MATKHAU = '" . $_POST['matkhau'] ."', ISADMIN = '$isadmin' 
        WHERE MAND = '".$maND."'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> Thành công!</h4>
                Thêm dữ liệu thành công
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = 'Index.php';
                }, 2000); // Chuyển hướng sau 2 giây
            </script>
            ";
        } else {
            echo "
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-warning'></i> Lỗi !</h4>
                Có lỗi xảy ra khi cập nhật thông tin thương hiệu
            </div>";
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
            Thương hiệu đã tồn tại
        </div>';
    }
}

?>
<div class="container">
    <h2>Chỉnh sửa người dùng</h2>
    <form action="" method="POST" id="form-3">
        <div class="form-horizontal">
            <div class="form-group">
                <label>Mã người dùng</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maND ?>" disabled name="maND">
            </div>

            <div class="form-group">
                <label>Tên người dùng</label>
                <input type="text" class="form-control textfile" name="tenND" id="tenND" value="<?php echo $row['TENND']?>">
                <span class="error_message"></span>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" class="form-control textfile" name="sdt" id="sdt" value="<?php echo $row['SDT']?>">
                <span class="error_message"></span>
            </div>

            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" class="form-control textfile" name="diachi" id="diachi" value="<?php echo $row['DIACHI']?>">
                <span class="error_message"></span>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control textfile" name="EMAIL" id="EMAIL" value="<?php echo $row['EMAIL'] ?>">
                <span class="error_message"></span>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="text" class="form-control textfile" name="matkhau" id="matkhau" value="<?php echo $row['MATKHAU']?>">
                <span class="error_message"></span>
            </div>

            <div class="form-group">
                <label>Phân quyền tài khoản</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="ISADMIN" id="ISADMIN" value="<?php echo isset($row['ISADMIN']) ? $row['ISADMIN'] : 0; ?>" <?php if (isset($row['ISADMIN']) && $row['ISADMIN'] == 1) echo 'checked'; ?> onclick="toggleCheckbox()">
                    <label class="form-check-label" for="ISADMIN">Admin</label>
                </div>
                <span class="error_message"></span>
            </div>

            
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10"> 
                    <input type="submit" value="Chỉnh sửa" class="btn btn-success" name="luu" />
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </div>
        </form>
    </div>
   
<?php
include("../../footer_admin.php");
?>
