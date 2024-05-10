<?php
require("../../db_connect.php");
include("../../header_admin.php");

$maTH = $_GET['maTH'];
$sql = "SELECT * FROM thuonghieu WHERE thuonghieu.MATH = '$maTH'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

function isBrandExists($conn, $tenTH, $maTH) {
    $tenTH = mysqli_real_escape_string($conn, $tenTH);
    $maTH = mysqli_real_escape_string($conn, $maTH);
    $sql = "SELECT COUNT(*) as count FROM thuonghieu WHERE TENTHUONGHIEU = '$tenTH' AND MATH != '$maTH'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

if (isset($_POST['tenTH'])) $tenTH = $_POST["tenTH"];
if (isset($_POST["luu"])) {
    if (!isBrandExists($conn, $tenTH, $maTH)) {
        $sql = "UPDATE thuonghieu SET TENTHUONGHIEU = '" . $_POST['tenTH'] . "', QUOCGIA = '" . $_POST['quocGia'] . "' WHERE MATH = '".$maTH."'";
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
    <h2>Chỉnh sửa thương hiệu</h2>
    <form action="" method="POST" id="form-3">
        <div class="form-horizontal">
            <div class="form-group">
                <label>Mã thương hiệu</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maTH ?>" disabled name="maTH">
            </div>
            <div class="form-group">
                <label>Tên thương hiệu</label>
                <input type="text" class="form-control textfile" name="tenTH" id="tenTH" value="<?php echo $row['TENTHUONGHIEU']?>">
                <span class="error_message"></span>
            </div>
            <div class="form-group">
                <label>Quốc gia</label>
                <input type="text" class="form-control textfile" name="quocGia" id="quocGia" value="<?php echo $row['QUOCGIA']?>">
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
