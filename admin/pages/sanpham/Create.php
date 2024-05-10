<?php
require("../../db_connect.php");
include("../../header_admin.php");

function isProductsExists($conn, $TENSP) {
    $TENSP = mysqli_real_escape_string($conn, $TENSP);
    $sql = "SELECT COUNT(*) as count FROM sanpham WHERE TENSP = '$TENSP'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$sql = "SELECT MASP from sanpham ORDER BY MASP DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maSP = (int) substr($row['MASP'], 2);
$maSP = $maSP + 1;
$maSP = "SP" . str_pad($maSP, 4, "0", STR_PAD_LEFT);

if (isset($_POST['TENSP'])) $TENSP = $_POST["TENSP"]; 
else $TENSP = "";

if (isset($_POST["taomoi"])) {
    $TENSP  = mysqli_real_escape_string($conn, $TENSP);
    if (!isProductsExists($conn, $TENSP)) {
$target_dir = "../../images/sanpham/";
$target_file = $target_dir . basename($_FILES["Avatar"]["name"]);
$check = getimagesize($_FILES["Avatar"]["tmp_name"]);
$ngayTao = date("Y-m-d H:i:s");
if ($check !== false) {
    $sale = isset($_POST['SALE']) ? $_POST['SALE'] : 0;

    move_uploaded_file($_FILES["Avatar"]["tmp_name"], $target_file);

    $sql = "INSERT INTO sanpham (NGAYTAO, MASP, TENSP, DONGIA, SALE, SOLUONG, MOTA, ANH, MALOAISP, MATH)
    VALUES ('$ngayTao', '$maSP', '" . $_POST['TENSP'] . "', '" . $_POST['DONGIA'] . "', '$sale', 
    '" . $_POST['SOLUONG'] . "', '" . $_POST['MOTA'] . "', '" . $_FILES["Avatar"]["name"] . "',
    '" . $_POST['loaisp'] . "', '" . $_POST['thuonghieu'] . "')";   
    $result = mysqli_query($conn, $sql);
}
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
    }
    else {
            echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Lỗi !</h4>
                    Sản phẩm đã tồn tại
                </div>';
        }
}

?>

<h2 style="text-align:center">Thêm sản phẩm mới</h2>

<div class="container">

<form action="" class="d-flex justify-content-center" method="post" enctype="multipart/form-data">
        <div>
                <div class="form-group">
                        <label class="control-label ">Mã sản phẩm </label>
                        <input type="text" class="form-control textfile" readonly value="<?php echo $maSP ?>"
                                name="MASP">
                </div>

                <div class="form-group">
                        <label class="control-label ">Tên sản phẩm </label>
                        <div class="col-md-10">
                                <input type="text" class="form-control textfile" name="TENSP" required>
                        </div>
                </div>

                <div class="form-group">
                        <label class="control-label ">Đơn giá </label>
                        <div class="col-md-10">
                                <input type="text" class="form-control textfile" name="DONGIA" required>
                        </div>
                </div>

                <div class="form-group">
                        <label class="control-label ">Sale</label>
                        <div class="col-md-10">
                                <input type="text" class="form-control textfile" name="SALE" required>
                        </div>
                </div>
                
                <div class="form-group">
                        <label class="control-label ">Số lượng </label>
                        <div class="col-md-10">
                                <input type="number" class="form-control textfile" name="SOLUONG" required>
                        </div>
                </div>

                <div class="form-group">
                        <label class="control-label ">Mô tả</label>
                        <div class="col-md-10">
                                <textarea class="form-control textfile" name="MOTA" id="" cols="60" rows="10">
                                </textarea>
                        </div>
                </div>

        </div>
        <div>
                <div class="form-group">
                        <label class="control-label ">Ảnh</label>
                        <div class="col-md-10">
                                <input type="file" value="Chọn File" name="Avatar" accept="image/*" required />
                        </div>
                </div>

                <?php
                $sql_loaisp = "SELECT TENLOAISP, MALOAISP from loaisanpham ";
                $result_loaisp = mysqli_query($conn, $sql_loaisp);
                ?>
                <div class="form-group">
                        <label class="control-label ">Loại sản phẩm</label>
                        <div class="col-md-10">
                                <select name="loaisp" id="" class="form-control textfile">
                                        <?php while ($row = mysqli_fetch_row($result_loaisp)) {
                                                echo "<option selected value='$row[1]'>$row[0]</option>";
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
                                <input type="submit" value="Thêm sản phẩm" class="btn btn-success"
                                        name="taomoi" />
                                <a href="./Index.php" class="btn btn-success">Trở về trang danh sách</a>
                        </div>
                </div>
            </div>
    </form>

</div>

<?php
include("../../footer_admin.php");
?>