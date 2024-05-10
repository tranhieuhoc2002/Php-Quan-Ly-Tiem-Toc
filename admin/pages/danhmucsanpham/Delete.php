<?php
include("../../header_admin.php");
include("../../db_connect.php");

$maLoaiSP = $_GET['id'];
$sql = "SELECT TENLOAISP FROM loaisanpham WHERE MALOAISP = '{$maLoaiSP}'";
$kq = mysqli_query($conn, $sql);
$tenLoaiSP = mysqli_fetch_assoc($kq);
$tenLoaiSP = $tenLoaiSP['TENLOAISP'];

if (isset($_POST['delete'])) {
    try {
        $sql = "DELETE FROM loaisanpham WHERE MALOAISP = '$maLoaiSP'";
        mysqli_query($conn, $sql);
        
        echo "
        <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-check'></i> Thành công!</h4>
            Xoá thành công
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'Index.php';
            }, 2000); // Chuyển hướng sau 2 giây
        </script>
        ";
    } catch (Exception $e) {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
            Đang có các sản phẩm liên kết với loại sản phẩm này
        </div>';
    }
} 
?>

<div class="container">
    <h2>BẠN CÓ MUỐN XÓA LOẠI SẢN PHẨM NÀY?</h2>
    <form action="" method="POST">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã loại sản phẩm</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maLoaiSP ?>" disabled name="maLoaiSP" style="width:52%">
            </div>
            <div class="form-group">
                <label>Tên loại</label>
                <input type="text" class="form-control textfile"name="tenLoaiSP" disabled value="<?php echo $tenLoaiSP?>" style="width:52%">
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10"> 
                    <input type="submit" value="Xóa" class="btn btn-danger" name="delete" />
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </div>
    </form>
</div>

<?php
include("../../footer_admin.php");
?>