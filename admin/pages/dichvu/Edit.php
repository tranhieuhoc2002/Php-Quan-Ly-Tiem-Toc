<?php
include("../../db_connect.php");
include("../../header_admin.php");

$maDV = $_GET['id'];
$sql = "SELECT TENDV FROM dichvu WHERE MADV = '{$maDV}'";
$kq = mysqli_query($conn, $sql);
$tenDV = mysqli_fetch_assoc($kq);
$tenDV = $tenDV['TENDV'];

function isServiceExists($conn, $tenDV) {
    $tenDV = mysqli_real_escape_string($conn, $tenDV);
    $sql = "SELECT COUNT(*) as count FROM dichvu WHERE TENDV = '$tenDV'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}
if (isset($_POST['tenDV'])) $tenDV = $_POST["tenDV"]; 
if (isset($_POST["edit"])) {
    if (!isServiceExists($conn, $tenDV)) {
        $sql = "UPDATE dichvu SET TENDV = '{$_POST['tenDV']}' WHERE MADV = '$maDV'";

    $result = mysqli_query($conn, $sql);
    echo "
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Thành công!</h4>
        Sửa dữ liệu thành công
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
            Loại dịch vụ đang tồn tại không thể chỉnh sửa
        </div>';
}
}
?>
<div class="container">
    <h2>Chỉnh sửa loại dịch vụ</h2>
    <form action="" method="POST" id="form-3">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã dịch vụ</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maDV ?>" disabled name="maDV" >
            </div>
            <div class="form-group">
                <label>Tên dịch vụ</label>
                <input required type="text" class="form-control textfile"name="tenDV" id="tenDV" value="<?php echo $tenDV?>" >
                <span class="error_message"></span>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10"> 
                    <input type="submit" value="Chỉnh sửa" class="btn btn-success" name="edit" />
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </div>
    </form>
</div>

<?php
include("../../footer_admin.php");
?>