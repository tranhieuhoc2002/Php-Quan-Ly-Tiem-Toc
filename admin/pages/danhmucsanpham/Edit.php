<?php
include("../../db_connect.php");
include("../../header_admin.php");

$maLoaiSP = $_GET['id'];
$sql = "SELECT TENLOAISP FROM loaisanpham WHERE MALOAISP = '{$maLoaiSP}'";
$kq = mysqli_query($conn, $sql);
$tenLSP = mysqli_fetch_assoc($kq);
$tenLSP = $tenLSP['TENLOAISP'];

function isCategoryExists($conn, $tenLSP) {
    $tenLSP = mysqli_real_escape_string($conn, $tenLSP);
    $sql = "SELECT COUNT(*) as count FROM loaisanpham WHERE TENLOAISP = '$tenLSP'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}
if (isset($_POST['tenLSP'])) $tenLSP = $_POST["tenLSP"]; 
if (isset($_POST["edit"])) {
    if (!isCategoryExists($conn, $tenLSP)) {
        $sql = "UPDATE loaisanpham SET TENLOAISP = '{$_POST['tenLSP']}' WHERE MALOAISP = '$maLoaiSP'";

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
            Loại sản phẩm đang tồn tại không thể chỉnh sửa
        </div>';
}
}
?>
<div class="container">
    <h2>Chỉnh sửa loại sản phẩm</h2>
    <form action="" method="POST" id="form-3">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã loại sản phẩm</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maLoaiSP ?>" disabled name="maLoaiSP" >
            </div>
            <div class="form-group">
                <label>Tên loại</label>
                <input required type="text" class="form-control textfile"name="tenLSP" id="tenLSP" value="<?php echo $tenLSP?>" >
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