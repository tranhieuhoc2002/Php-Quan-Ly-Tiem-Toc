<title>Đặt lịch</title>
<?php
include ("../LOGIN_REQUIRED/Login_Required.php"); 

if (!isset($_SESSION['MAND'])) {
    header("Location: ../AUTHENTICATION/DangNhap.php");

    exit();

}
 include ("../Shared_Layout/header.php");

?>
<!-- Bảng thông báo thành công -->
<?php
 $sql = "SELECT MADL from datlich ORDER BY MADL DESC LIMIT 1";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_assoc($result);
 $maDL = (int) substr($row['MADL'], 2);
 $maDL = $maDL + 1;
 $maDL = "DL" . str_pad($maDL, 4, "0", STR_PAD_LEFT);

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ biểu mẫu
    $mand = $_SESSION['MAND'];
    $madv = $_POST["loaidv"];
    $ngayden = $_POST["ngayden"];
    $thoigian = $_POST["loaitg"];
    $tinhtrangdat = "Đang xử lý";

    // Kiểm tra xem người dùng đã nhập đủ thông tin hay chưa
    if (empty($mand) || empty($madv) || empty($ngayden) || empty($thoigian)) {
        $error_message = "Cần nhập đủ thông tin!";
    } else {
        // Thêm hoặc cập nhật vào bảng ngay
        $query_check_ngay = "SELECT * FROM ngay WHERE NGAYDAT = '$ngayden' AND MATG = '$thoigian'";
        $result_check_ngay = mysqli_query($conn, $query_check_ngay);

        if (mysqli_num_rows($result_check_ngay) > 0) {
            // Nếu có bản ghi trùng, kiểm tra và cập nhật giá trị LIMITTG
            $row = mysqli_fetch_assoc($result_check_ngay);
            $limit_tg = $row['LIMITTG'];

            if ($limit_tg < 5) {
                $query_update_ngay = "UPDATE ngay SET LIMITTG = LIMITTG + 1 WHERE NGAYDAT = '$ngayden' AND MATG = '$thoigian'";
                mysqli_query($conn, $query_update_ngay);
            } else {
                $error_message = "Không thể đặt lịch vì đã hết số lượng giới hạn!";
            }
        } else {
            // Nếu không có bản ghi trùng, thêm bản ghi mới
            $query_insert_ngay = "INSERT INTO ngay (NGAYDAT, MATG, LIMITTG) VALUES ('$ngayden', '$thoigian', 1)";
            mysqli_query($conn, $query_insert_ngay);
        }

        if (!isset($error_message)) {
            // Thêm thông tin lịch đặt vào bảng datlich
            $sql_insert = "INSERT INTO datlich (MADL, MAND, MADV, NGAYDEN, TINHTRANGDAT, MATG) 
                           VALUES ('$maDL', '$mand', '$madv', '$ngayden', '$tinhtrangdat', '$thoigian')";

            if (mysqli_query($conn, $sql_insert)) {
                $success_message = "Đặt lịch thành công!";
            } else {
                $error_message = "Đã xảy ra lỗi khi chèn dữ liệu vào bảng datlich: " . mysqli_error($conn);
            }
        }
    }
}





if (!empty($error_message)) {
    echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-exclamation-triangle'></i> $error_message</h4>
          </div>";
        } else if (!empty($success_message)) {
         echo   "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-check'></i>  $success_message</h4>
                </div>";
        }
?>


<style>
    /* CSS để trang trí */
    .container-fluid {
        width: 50%; /* Điều chỉnh độ rộng của bảng */
        margin: 0 auto; /* Đặt để căn giữa */
        border: 1px solid #ccc; /* Viền đường kẻ */
        padding: 20px; /* Khoảng cách bên trong */
        border-radius: 10px; /* Bo tròn góc */
    }
    h1 {
        text-align: center; /* Căn giữa tiêu đề */
    }
</style>

<div id="page-content" class="single-page" style="margin-top:50px;">
    <div class="container-fluid" >
        <h1 class="text-center mb-4">ĐẶT LỊCH HẸN</h1>
        <form method="post">
            <div class="row">
                <!-- Thông tin ng đặt -->
                <div class="col-md-12">
                    <?php
                    $sql_tennd = "SELECT TENND from nguoidung ";
                    $result_tennd = mysqli_query($conn, $sql_tennd);
                    ?>
                    <div class="form-group">
                        <label for="appointment_date">Họ và tên:</label>
                        <input type="text" class="form-control textfile" readonly value="<?php echo $_SESSION["TENND"]  ?>"
                                name="MASP">
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    $sql_tennd = "SELECT TENND from nguoidung ";
                    $result_tennd = mysqli_query($conn, $sql_tennd);
                    ?>
                    <div class="form-group">
                        <label for="appointment_date">Giới tính:</label>
                        <input type="text" class="form-control textfile" readonly value="<?php echo $_SESSION["GIOITINH"]  ?>"
                                name="MASP">
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    $sql_sdt = "SELECT SDT from nguoidung ";
                    $result_sdt = mysqli_query($conn, $sql_sdt);
                    ?>
                    <div class="form-group">
                        <label for="appointment_date">Số điện thoại:</label>
                        <input type="text" class="form-control textfile" readonly value="<?php echo $_SESSION["SDT"]  ?>"
                                name="MASP">
                    </div>
                </div>
                <div class="col-md-6">
                <!-- Ngày tháng đặt -->
                    <?php
                    $sql_ngayden = "SELECT NGAYDEN from datlich ";
                    $result_ngayden = mysqli_query($conn, $sql_ngayden);
                    $row_ngayden = mysqli_fetch_row($result_ngayden);
                    $ngayden = $row_ngayden[0];
                    ?>
                    <div class="form-group">
                        <label for="appointment_date">Ngày đặt lịch:</label>
                        <input type="date" class="form-control" name="ngayden" value="<?php echo $ngayden; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                <!-- Thời gian đặt -->
                    <?php
                    $sql_loaitg = "SELECT TENTG, MATG from thoigian ";
                    $result_loaitg = mysqli_query($conn, $sql_loaitg);
                    ?>
                    <div class="form-group">
                        <label class="control-label">Thời gian đặt:</label>
                        <select name="loaitg" id="" class="form-control textfile">
                        <option value="">-Chọn thời gian-</option>
                            <?php while ($rows = mysqli_fetch_row($result_loaitg)) {
                                if ($row["TENTG"] == $rows[0]) {
                                    echo "<option selected value='$rows[1]'>$rows[0]</option>";
                                } else
                                    echo "<option value='$rows[1]'>$rows[0]</option>";
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- dịch vụ -->
            <?php
            $sql_loaidv = "SELECT TENDV, MADV from dichvu ";
            $result_loaidv = mysqli_query($conn, $sql_loaidv);
            ?>
            <div class="form-group">
                <label class="control-label">Dịch vụ:</label>
                <select name="loaidv" id="" class="form-control textfile">
                <option value="">-Chọn dịch vụ-</option>
                    <?php while ($rows = mysqli_fetch_row($result_loaidv)) {
                        if ($row["TENDV"] == $rows[0]) {
                            echo "<option selected value='$rows[1]'>$rows[0]</option>";
                        } else
                            echo "<option value='$rows[1]'>$rows[0]</option>";
                    } ?>
                </select>
            </div>
            <p style="margin-top:30px;font-style: italic">HAIR GUY SALON xin cảm ơn quý khách đã đặt dịch vụ Chúc quý khách một ngày vui vẻ</p>
            <p style="margin:20px 0px;font-style: italic">Thank you for your booking.</br>Have a nice day!</p>
            <div class="text-center">
                <button type="submit" style="padding: 10px 40px;" class="btn btn-primary">Đặt lịch</button>
            </div>
        </form>
    </div>
</div>



<!-- Dịch vụ -->
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-3">
        <div class="card" style="width: 18rem;">
            <img src="../../admin/images/logo/dv1.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body text-center">
                <h5 class="card-title">Cắt thiết kế tóc</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                
            </div>
        </div>
      </div>

        <div class="col-md-3">
        <div class="card text-center" style="width: 18rem;">
            <img src="../../admin/images/logo/dv2.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body">
                <h5 class="card-title">Tẩy & Nhuộm tóc</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                
            </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center" style="width: 18rem;">
            <img src="../../admin/images/logo/dv3.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body">
                <h5 class="card-title ">Uốn tóc</h5>
                <p class="card-text ">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                
            </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center" style="width: 18rem;">
            <img src="../../admin/images/logo/dv4.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body">
                <h5 class="card-title">Duỗi tóc</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
      </div>
    </div>
    
  </div>


<?php
include ("../Shared_Layout/footer.php");
?>