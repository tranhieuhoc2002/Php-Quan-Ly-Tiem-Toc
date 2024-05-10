<?php
include("../../header_admin.php");
require("../../db_connect.php");

function isUserExists($conn, $TENND) {
    $TENND = mysqli_real_escape_string($conn, $TENND);
    $sql = "SELECT COUNT(*) as count FROM nguoidung WHERE TENND = '$TENND'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$sql = "SELECT MAND from nguoidung ORDER BY MAND DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maND = (int) substr($row['MAND'], 2);
$maND = $maND + 1;
$maND = "ND" . str_pad($maND, 3, "0", STR_PAD_LEFT);

if (isset($_POST['TENND'])) $TENND = $_POST["TENND"]; 
else $TENND = "";

if (isset($_POST["taomoi"])) {
    $TENND  = mysqli_real_escape_string($conn, $TENND);
    if (!isUserExists($conn, $TENND)) {
        $target_dir = "../../images/nguoidung/";
        $target_file = $target_dir . basename($_FILES["Avatar"]["name"]);
        $check = getimagesize($_FILES["Avatar"]["tmp_name"]);
        if ($check !== false) {
            move_uploaded_file($_FILES["Avatar"]["tmp_name"], $target_file);
            $sql = "INSERT INTO nguoidung (MAND, TENND, EMAIL, MATKHAU, GIOITINH, SDT, DIACHI, ANHDAIDIEN, ISADMIN)
                    VALUES ('$maND', '$TENND', '" . $_POST['EMAIL'] . "','" . $_POST['MATKHAU'] . "',
                    '" . $_POST['GIOITINH'] . "','" . $_POST['SDT'] . "','" . $_POST['DIACHI'] . "', '" . $_FILES["Avatar"]["name"] . "',
                    0)"; // Thay đổi giá trị '0' thành 0
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
                Người dùng đã tồn tại
            </div>';
    }
}
?>

<div class="container">
    <h2>Thêm người dùng mới</h2>
    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-horizontal">
        <div class="form-group">
                <label class="control-label col-md-2">Mã người dùng </label>
                <div class="col-md-10">
                <input type="text" class="form-control textfile" readonly value="<?php echo $maND ?>"
                        name="MAND">
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Tên người dùng </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="TENND" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">EMAIL </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="EMAIL" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Mật khẩu </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="MATKHAU" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Giới tính </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="GIOITINH" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Số điện thoại </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="SDT" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-2">Địa chỉ </label>
                <div class="col-md-10">
                        <input type="text" class="form-control textfile" name="DIACHI" required>
                </div>
        </div>

        <div class="form-group">
                <label class="control-label ">Ảnh</label>
                <div class="col-md-10">
                    <input type="file" value="Chọn File" name="Avatar" accept="image/*" required />
                </div>
        </div>

      

                <div class="form-group mt">
                        <div>
                                <input type="submit" value="Thêm người dùng" class="btn btn-success"
                                        name="taomoi" />
                                <a href="./Index.php" class="btn btn-success">Trở về trang danh sách</a>
                        </div>
                </div>
    </form>
</div>

<?php
include("../../footer_admin.php");
?>