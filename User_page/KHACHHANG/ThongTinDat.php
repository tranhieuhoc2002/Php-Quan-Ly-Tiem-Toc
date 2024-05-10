<?php
    // Lưu ý: Bạn cần phải có kết nối CSDL trước khi sử dụng
    include("../LOGIN_REQUIRED/Login_Required.php"); 
    include("../Shared_Layout/header.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["cancel_booking"]) && isset($_POST["booking_id"])) {
            $booking_id = $_POST["booking_id"];
            // Kiểm tra tình trạng đặt lịch, chỉ cho phép hủy nếu tình trạng là "đang xử lý"
            $booking_status = mysqli_query($conn, "SELECT TINHTRANGDAT, NGAYDEN, MATG FROM datlich WHERE MADL = '{$booking_id}'");
            if ($booking_status) {
                $row = mysqli_fetch_assoc($booking_status);
                if ($row["TINHTRANGDAT"] === "Đang xử lý") {
                    // Lấy ngày đặt lịch và mã thời gian
                    $ngayden = $row["NGAYDEN"];
                    $matg = $row["MATG"];
                    
                    // Thực hiện xóa bản ghi đặt lịch khỏi cơ sở dữ liệu
                    $delete_query = mysqli_query($conn, "DELETE FROM datlich WHERE MADL = '{$booking_id}'");
                    if ($delete_query) {
                        // Nếu xóa thành công, kiểm tra và giảm LIMITTG trong bảng ngay
                        $update_limit_query = mysqli_query($conn, "UPDATE ngay SET LIMITTG = LIMITTG - 1 WHERE NGAYDAT = '{$ngayden}' AND MATG = '{$matg}'");
                        if ($update_limit_query) {
                            // Nếu cập nhật thành công, chuyển hướng lại để cập nhật danh sách
                            echo "<div class='alert alert-danger alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h4><i class='icon fa fa-exclamation-triangle'></i> Xóa Thành Công lịch hẹn của bạn</h4>
                                </div>";
                        } else {
                            // Xử lý lỗi khi không thể cập nhật LIMITTG
                            echo "Có lỗi xảy ra khi cập nhật giới hạn trong bảng ngay.";
                        }
                    } else {
                        // Xử lý lỗi khi không thể xóa bản ghi
                        echo "Có lỗi xảy ra khi xóa bản ghi đặt lịch.";
                    }
                }
            }
        }
    }
    
?>

<title>Thông tin đặt lịch</title>

<section class="section-pagetop bg-gray">
    <div class="container">
        <h2 class="title-page">Tài khoản của tôi</h2>
    </div> <!-- container //  -->
</section>

<!-- ========================= SECTION PAGETOP END// ========================= -->
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <nav class="list-group">
                    <a class="list-group-item" href="Detail.php"> Thông tin chung </a>
                    <a class="list-group-item active" href="ThongTinDat.php"> Thông tin đặt lịch </a>
                    <a class="list-group-item" href="DonDatHang.php"> Lịch sử đơn hàng </a>
                    <a class="list-group-item" href="CaiDatThongTin.php">Cài đặt thông tin</a>
                </nav>
            </aside> <!-- col.// -->
            <main class="col-md-9">
            <?php
                $tt_dl = mysqli_query($conn, "SELECT datlich.*, nguoidung.*, thoigian.TENTG, dichvu.TENDV
                FROM datlich
                    JOIN nguoidung ON datlich.MAND = nguoidung.MAND
                    JOIN thoigian ON datlich.MATG = thoigian.MATG
                    JOIN dichvu ON datlich.MADV = dichvu.MADV
                WHERE datlich.MAND = '{$_SESSION['MAND']}'
                ORDER BY datlich.MADL DESC");
            ?>
                <?php if (mysqli_num_rows($tt_dl) <> 0): ?>
                <?php while ($row = mysqli_fetch_assoc($tt_dl)): ?>
                    <article class="card mb-4">
                        <header class="card-header">
                            <a href="#" class="float-right"> <i class="fa fa-print"></i></a>
                            <strong class="d-inline-block mr-3">ID đặt lịch:
                                <?php echo $row['MADL'] ?>
                            </strong>
                        </header>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="text-muted">Thông tin người đặt lịch</h5>
                                    <p>
                                        <?php echo $row['TENND'] ?> <br>
                                        SĐT: <?php echo $row['SDT'] ?><br> 
                                        Email: <?php echo $row['EMAIL'] ?> <br>
                                        Địa chỉ: <?php echo $row['DIACHI']; ?>
                                        <br>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-muted">Thông tin đặt</h5>
                                    <span class="text-success">
                                        <i class="fab fa fa-check-circle"></i>
                                        <?php echo $row['TINHTRANGDAT'] ?>
                                    </span>
                                    <p>
                                        Ngày đặt:
                                        <?php echo date("d/m/Y", strtotime($row['NGAYDEN'])); ?>
                                        <br>
                                        Thời gian:
                                        <?php echo $row['TENTG'] ?>
                                        <br>
                                        <span class="b">Dịch vụ làm tóc:
                                        <?php echo $row['TENDV'] ?>
                                        </span>
                                    </p>
                                    <?php if ($row['TINHTRANGDAT'] === "Đang xử lý"): ?>
                                        <form method="post">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['MADL']; ?>">
                                            <button type="submit" name="cancel_booking" class="btn btn-danger">Hủy</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div> <!-- row.// -->
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php endif; ?>
            </main>
        </div>
    </div>
</section>

<?php
include("../Shared_Layout/footer.php");
?>
