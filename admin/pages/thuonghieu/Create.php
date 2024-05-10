<?php
include("../../db_connect.php");
include("../../header_admin.php");

function isBrandExists($conn, $tenTH) {
    $tenTH = mysqli_real_escape_string($conn, $tenTH);
    $sql = "SELECT COUNT(*) as count FROM thuonghieu WHERE TENTHUONGHIEU = '$tenTH'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$sql = "SELECT MATH from thuonghieu ORDER BY MATH DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maTH = (int) substr($row['MATH'], 2);
$maTH = $maTH + 1;
$maTH = "TH" . str_pad($maTH, 3, "0", STR_PAD_LEFT);

if (isset($_POST['tenTH'])) $tenTH = $_POST["tenTH"]; else $tenTH = "";
if (isset($_POST['quocGia'])) $quocGia = $_POST["quocGia"]; else $quocGia = "";
if (isset($_POST["create"])) {
    $tenTH = mysqli_real_escape_string($conn, $tenTH);
    if (!isBrandExists($conn, $tenTH)) {    
        $sql = "INSERT INTO thuonghieu (MATH, TENTHUONGHIEU, QUOCGIA) VALUES ('$maTH','$tenTH', '$quocGia')";
        mysqli_query($conn, $sql);
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
        echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                Thương hiệu đã tồn tại
            </div>';
    }
}

?>

<div class="container">
    <h2>Thêm thương hiệu</h2>
    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-horizontal">
        <div class="form-group">
                <label class="control-label col-md-2">Mã thương hiệu </label>
                <div class="col-md-10">
                <input type="text" class="form-control textfile" readonly value="<?php echo $maTH ?>"
                        name="maTH">
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Tên thương hiệu </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="tenTH" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Quốc gia </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="quocGia" required>
                </div>
        </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Tạo mới" class="btn btn-success" name="create" />
                    <a class="btn btn-success" href="Index.php">Trở về trang danh sách</a>
                </div>
            </div>
    </form>
</div>

<?php
include("../../footer_admin.php");
?>