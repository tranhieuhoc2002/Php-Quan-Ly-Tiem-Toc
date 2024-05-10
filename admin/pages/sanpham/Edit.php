<?php
include("../../header_admin.php");
require("../../db_connect.php");

function isProductsExists($conn, $TENSP, $maSP) {
    $TENSP = mysqli_real_escape_string($conn, $TENSP);
    $sql = "SELECT COUNT(*) as count FROM sanpham WHERE TENSP = '$TENSP' AND MASP != '$maSP'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$maSP = $_GET['maSP'];
$sql_sanpham = "SELECT TENSP, DONGIA, SALE, SOLUONG, MOTA, ANH, TENLOAISP, TENTHUONGHIEU
FROM ((sanpham join loaisanpham on sanpham.MALOAISP = loaisanpham.MALOAISP) join thuonghieu on
sanpham.MATH = thuonghieu.MATH) 
WHERE sanpham.MASP = '$maSP'";
$result = mysqli_query($conn, $sql_sanpham);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["luu"])) {
    $target_dir = "../../images/sanpham/";

    // Kiểm tra xem người dùng đã chọn ảnh mới hay chưa
    if (!empty($_FILES["Avatar"]["name"])) {
        $target_file = $target_dir . basename($_FILES["Avatar"]["name"]);
        $check = getimagesize($_FILES["Avatar"]["tmp_name"]);

        if ($check !== false) {
            move_uploaded_file($_FILES["Avatar"]["tmp_name"], $target_file);
            $anh_moi = $_FILES["Avatar"]["name"];
        } else {
            ?>
            <script>
                window.alert("Tệp ảnh không hợp lệ");
            </script>
            <?php
        }
    } else {
        // Nếu không có ảnh mới, sử dụng ảnh cũ
        $anh_moi = $row['ANH'];
    }

    if (!isProductsExists($conn, $_POST['TENSP'], $maSP)) {
        $sql = "UPDATE sanpham SET TENSP = '" . $_POST['TENSP'] . "', DONGIA = '" . $_POST['DONGIA'] . "',SALE = '" . $_POST['SALE'] . "',
        SOLUONG = '" . $_POST['SOLUONG'] . "', MOTA = '" . $_POST['MOTA'] . "', ANH = '$anh_moi',
            MALOAISP = '" . $_POST['loaisp'] . "', MATH = '" . $_POST['thuonghieu'] . "'
            WHERE MASP = '" . $maSP . "'";
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
            Sản phẩm đã tồn tại
        </div>';
    }
}
?>

<h2 style="text-align:center">Chỉnh sửa sản phẩm</h2>

<div class="container ">

        <form action="" class="d-flex justify-content-center" method="post" enctype="multipart/form-data">
                <div>
                        <div class="form-group">

                                <label class="control-label ">Mã sản phẩm </label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" readonly
                                                value="<?php echo $maSP ?>" name="MASP">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label ">Tên sản phẩm </label>
                                <div class="col-md-10">
                                        <input required type="text" class="form-control textfile" name="TENSP"
                                                value="<?php echo $row['TENSP'] ?>">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label">Đơn giá</label>
                                <div class="col-md-10">
                                        <input required type="text" class="form-control textfile" name="DONGIA"
                                                value="<?php echo number_format($row['DONGIA']); ?>">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label">Sale</label>
                                <div class="col-md-10">
                                        <input required type="text" class="form-control textfile" name="SALE"
                                                value="<?php echo number_format($row['SALE']); ?>">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Số lượng</label>
                                <div class="col-md-10">
                                        <input required type="number" class="form-control textfile" name="SOLUONG"
                                                value="<?php echo $row['SOLUONG'] ?>">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Mô tả</label>
                                <div class="col-md-10">
                                        <textarea class="form-control textfile" name="MOTA" id="" cols="60" rows="10"><?php echo $row['MOTA'] ?>
                                        </textarea>
                                </div>
                        </div>

                </div>


                <div>
                    
                        <div class="form-group">
                                <label class="control-label">Ảnh</label>
                                <div class="col-md-10">
                                        <input  type="file" class="textfile" value="Chọn File" name="Avatar"
                                                accept="image/*" />
                                </div>
                        </div>

                        <?php
                        $sql_loaisp = "SELECT TENLOAISP, MALOAISP from loaisanpham ";
                        $result_loaisp = mysqli_query($conn, $sql_loaisp);
                        ?>
                        <div class="form-group">
                                <label class="control-label">Loại sản phẩm</label>
                                <div class="col-md-10">
                                        <select name="loaisp" id="" class="form-control textfile">
                                                <?php while ($rows = mysqli_fetch_row($result_loaisp)) {
                                                        if ($row["TENLOAISP"] == $rows[0]) {
                                                                echo "<option selected value='$rows[1]'>$rows[0]</option>";
                                                        } else
                                                                echo "<option value='$rows[1]'>$rows[0]</option>";
                                                } ?>
                                        </select>
                                </div>
                        </div>

                        <?php
                        $sql_thuonghieu = "SELECT TENTHUONGHIEU, MATH from thuonghieu ";
                        $result_thuonghieu = mysqli_query($conn, $sql_thuonghieu);
                        ?>
                        <div class="form-group">
                                <label class="control-label">Thương hiệu</label>
                                <div class="col-md-10">
                                        <select name="thuonghieu" id="" class="form-control textfile">
                                                <?php while ($rows = mysqli_fetch_row($result_thuonghieu)) {
                                                        if ($row["TENTHUONGHIEU"] == $rows[0]) {
                                                                echo "<option selected value='$rows[1]'>$rows[0]</option>";
                                                        } else
                                                                echo "<option value='$rows[1]'>$rows[0]</option>";
                                                } ?>
                                        </select>
                                </div>
                        </div>
                        
                        <div class="form-group mt">
                                <div>
                                        <input type="submit" value="Lưu" class="btn btn-success" name="luu" />
                                        <a href="./Index.php" class="btn btn-primary">Trở về trang danh sách</a>
                                </div>
                        </div>
                </div>

        </form>


</div>

<?php
include("../../footer_admin.php");
?>