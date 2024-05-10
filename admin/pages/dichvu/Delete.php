<?php
include("../../header_admin.php");
include("../../db_connect.php");

$maDV = $_GET['id'];
$sql = "SELECT TENDV FROM dichvu WHERE MADV = '{$maDV}'";
$kq = mysqli_query($conn, $sql);
$tenDV = mysqli_fetch_assoc($kq);
$tenDV = $tenDV['TENDV'];

if (isset($_POST['delete'])) {
    try {
        $sql = "DELETE FROM dichvu WHERE MADV = '$maDV'";
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
            Đang có các sản phẩm liên kết với dịch vụ này
        </div>';
    }
} 
?>

<div class="container">
    <h2>BẠN CÓ MUỐN XÓA LOẠI DỊCH VỤ NÀY?</h2>
    <form action="" method="POST">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã dịch vụ</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maDV ?>" disabled name="maDV" style="width:52%">
            </div>
            <div class="form-group">
                <label>Tên dịch vụ</label>
                <input type="text" class="form-control textfile"name="tenDV" disabled value="<?php echo $tenDV?>" style="width:52%">
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