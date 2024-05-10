<?php
include("../../header_admin.php");
include("../../db_connect.php");

function isServiceExists($conn, $tenDV) {
    $tenDV = mysqli_real_escape_string($conn, $tenDV);
    $sql = "SELECT COUNT(*) as count FROM dichvu WHERE TENDV = '$tenDV'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$sql = "SELECT MADV from dichvu ORDER BY MADV DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maDV = (int) substr($row['MADV'], 3);
$maDV = $maDV + 1;
$maDV = "DV" . str_pad($maDV, 3, "0", STR_PAD_LEFT);
if (isset($_POST['tenDV'])) $tenDV = $_POST["tenDV"]; else $tenDV = "";
if (isset($_POST["create"])) {
    $tenDV  = mysqli_real_escape_string($conn, $tenDV);
    if (!isServiceExists($conn, $tenDV)) {    
    $sql = "INSERT INTO dichvu (MADV, TENDV) VALUES ('$maDV', '$tenDV')";
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
            Loại sản phẩm đã tồn tại
        </div>';
}
}
?>
<div class="container">
    <h2>Thêm loại dịch vụ</h2>
    <form action="" method="POST" id="form-3">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã dịch vụ</label>
                <input type="text" name="maDV" class="form-control textfile"  value="<?php echo $maDV ?>" disabled  style="width:52%">
            </div>
            <div class="form-group">
                <label>Tên dịch vụ</label>
                <input type="text" id="tenDV" class="form-control textfile" name="tenDV" style="width:52%">
                <span class="error_message"></span>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Thêm" class="btn btn-success" name="create" />
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </div>
    </form>
</div>

<?php
include("../../footer_admin.php");
?>