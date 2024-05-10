<?php
include("../../header_admin.php");
require("../../db_connect.php");

$maSP = $_GET['maSP'];
$sql = "SELECT TENSP, DONGIA, SOLUONG, MOTA, ANH, TENLOAISP, TENTHUONGHIEU
FROM ((sanpham join loaisanpham on sanpham.MALOAISP = loaisanpham.MALOAISP) join thuonghieu on
sanpham.MATH = thuonghieu.MATH)
WHERE sanpham.MASP = '$maSP'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["xoa"])) {
    try{
        $sql = "DELETE FROM sanpham WHERE MASP = '$maSP'";
        $result = mysqli_query($conn, $sql);
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
    }
    catch (Exception $e) {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
            Đang có các hóa đơn liên kết với sản phẩm này
        </div>';
    }
        
    }
?>

<div class="container">
    <h2>BẠN CÓ MUỐN XÓA SẢN PHẨM NÀY?</h2>
    <form action="" method="POST">
        <div class="form-horizontal">
            
            <div class="form-group">
                <label>Mã sản phẩm</label>
                <input type="text" class="form-control textfile"  value="<?php echo $maSP ?>" disabled name="maSP" style="width:52%">
            </div>
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" class="form-control textfile"name="tenSP" disabled value="<?php echo $row['TENSP']?>" style="width:52%">
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10"> 
                    <input type="submit" value="Xóa" class="btn btn-danger" name="xoa" />
                    <a href="javascript:history.go(-1);"><input type="button" value="Quay lại" class="btn btn-success" name="Quay lại" /></a>
                </div>
            </div>
    </form>
</div>




<?php
include("../../footer_admin.php");
?>