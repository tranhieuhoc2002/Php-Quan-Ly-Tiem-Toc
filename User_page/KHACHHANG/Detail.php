<?php
include("../LOGIN_REQUIRED/Login_Required.php"); 

if (!isset($_SESSION['MAND'])) {
    header("Location: ../AUTHENTICATION/DangNhap.php");

    exit();

}
include ("../Shared_Layout/header.php");

$result = mysqli_query($conn, "SELECT nguoidung.* FROM nguoidung WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
?>
<title>Thông tin cá nhân</title>
<section class="section-pagetop bg-gray">
    <div class="container">
        <h2 class="title-page">Tài khoản của tôi</h2>
    </div> <!-- container //  -->
</section>
<!-- ========================= SECTION PAGETOP END// ========================= -->
<!-- ========================= SECTION CONTENT ========================= -->
<?php if (mysqli_num_rows($result) <> 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <section class="section-content padding-y">
            <div class="container">

                <div class="row">
                    <aside class="col-md-3">
                        <nav class="list-group">
                            <a class="list-group-item active" href="Detail.php"> Thông tin chung </a>
                            <a class="list-group-item" href="ThongTinDat.php"> Thông tin đặt lịch </a>
                            <a class="list-group-item" href="DonDatHang.php"> Lịch sử đơn hàng </a>
                            <a class="list-group-item" href="CaiDatThongTin.php">Cài đặt thông tin</a>
                            
                        </nav>
                    </aside> <!-- col.// -->
                    <main class="col-md-9">

                        <article class="card mb-3">
                            <div class="card-body">
                            <?php
                            // Kiểm tra xem người dùng đã chọn ảnh đại diện mới hay chưa
                            if (isset($_FILES['avatar'])) {
                                $file = $_FILES['avatar'];
                                $uploadDir = '../../admin/images/nguoidung/'; // Đường dẫn tới thư mục lưu trữ ảnh đại diện

                                // Kiểm tra và di chuyển tệp tin tải lên vào thư mục lưu trữ
                                if ($file['error'] === UPLOAD_ERR_OK) {
                                    $fileName = 'avatar.png'; // Tên tệp tin cố định
                                    $filePath = $uploadDir . $fileName;
                                    move_uploaded_file($file['tmp_name'], $filePath);

                                    // Lưu đường dẫn ảnh đã chọn vào tệp tin
                                    file_put_contents('../../admin/images/nguoidung/file.txt', $filePath);
                                }
                            }
                            ?>

                            <figure class="icontext">
                                <div class="icon">
                                    <img class="rounded-circle img-sm border avatar-img" src="<?php echo $row['ANHDAIDIEN'] ? $row['ANHDAIDIEN'] : 'Content/images/avatars/avatar3.jpg'; ?>" data-id="<?php echo $row['MAND']; ?>">
                                </div>
                                <div class="text">
                                    <strong>
                                        <?php echo $row['TENND']; ?>
                                    </strong> <br>
                                    <p class="mb-2">
                                        <?php echo $row['EMAIL']; ?>
                                    </p>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="file" accept="image/*" class="d-none" name="avatar" id="avatar-input">
                                        <label for="avatar-input" class="btn btn-success btn-sm edit-avatar">Chỉnh sửa ảnh</label>
                                        <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                                    </form>
                                </div>
                            </figure>
                            <script>
                                $(document).ready(function() {
                                    var avatarImg = $('.icontext .avatar-img');
                                    var avatarInput = $('#avatar-input');
                                    var MAND = '<?php echo $row['MAND']; ?>';

                                    // Kiểm tra nếu đã có ảnh được chọn từ trước
                                    if (localStorage.getItem('selectedAvatar_' + MAND)) {
                                        avatarImg.attr('src', localStorage.getItem('selectedAvatar_' + MAND));
                                    }

                                    avatarInput.change(function() {
                                        var input = this;

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                var newAvatarUrl = e.target.result;
                                                avatarImg.attr('src', newAvatarUrl);
                                                localStorage.setItem('selectedAvatar_' + MAND, newAvatarUrl);

                                                // Gửi đường dẫn ảnh đã chọn lên máy chủ để lưu vào tệp tin
                                                $.ajax({
                                                    url: 'avatar.php', // Đường dẫn đến file PHP xử lý việc lưu ảnh
                                                    type: 'POST',
                                                    data: { avatarUrl: newAvatarUrl },
                                                    success: function(response) {
                                                        // Xử lý kết quả sau khi lưu ảnh thành công
                                                    }
                                                });
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    });
                                });
                            </script>
                                <hr>
                                <p>
                                    <i class="fa fa-id-card text-muted"></i> &nbsp; Địa chỉ của tôi:
                                    <br>
                                    <?php echo $row['DIACHI']; ?>
                                </p>

                                <!-- Thông tin đặt lịch -->
                                <header class="section-heading heading-line">
                                    <h4 class="title-section text-uppercase">Thông tin đặt lịch</h4>
                                </header>
                                <article class="card-group card-stat">
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM nguoidung 
                                                JOIN datlich ON nguoidung.MAND = datlich.MAND
                                                WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo $total;
                                                ?>
                                            </h4>
                                            <span>Lần đã đặt lịch</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(datlich.MADL) as total
                                                from datlich join nguoidung on datlich.MAND = nguoidung.MAND
                                                where datlich.MAND = '{$_SESSION['MAND']}'and datlich.TINHTRANGDAT = 'Đang xử lý'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Lần đang xử lý</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(datlich.MADL) as total
                                                from datlich join nguoidung on datlich.MAND = nguoidung.MAND
                                                where datlich.MAND = '{$_SESSION['MAND']}'and datlich.TINHTRANGDAT = 'Đồng ý lịch đặt'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Lần chưa hoàn thành</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(datlich.MADL) as total
                                                from datlich join nguoidung on datlich.MAND = nguoidung.MAND
                                                where datlich.MAND = '{$_SESSION['MAND']}'and datlich.TINHTRANGDAT = 'Hoàn thành lịch đặt'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Lần hoàn thành lịch đặt</span>
                                        </div>
                                    </figure>
                                </article>

                                <!-- thông tin đơn hàng -->
                                <header class="section-heading heading-line">
                                    <h4 class="title-section text-uppercase">Thông tin đơn hàng</h4>
                                </header>
                                <article class="card-group card-stat">
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM nguoidung 
                                                JOIN hoadon ON nguoidung.MAND = hoadon.MAND
                                                WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo $total;
                                                ?>
                                            </h4>
                                            <span>Đơn đặt hàng</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $query = "SELECT SUM(ct.SOLUONG) AS total
                                                FROM hoadon hd
                                                JOIN chitiethoadon ct ON hd.MAHOADON = ct.MAHOADON
                                                join nguoidung on hd.MAND = nguoidung.MAND
                                                WHERE hd.TINHTRANGDONHANG = 'Giao hàng thành công' and nguoidung.MAND = '{$_SESSION['MAND']}'";
                                                $result = mysqli_query($conn, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;

                                                ?>
                                            </h4>
                                            <span>Sản phẩm đã mua</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(hoadon.MAHOADON) as total
                                                from hoadon join nguoidung on hoadon.MAND = nguoidung.MAND
                                                where hoadon.MAND = '{$_SESSION['MAND']}'and hoadon.TINHTRANGDONHANG = 'Đang giao hàng'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Đơn hàng đang giao</span>
                                        </div>
                                    </figure>
                                    <figure class="card bg">
                                        <div class="p-3">
                                            <h4 class="title">
                                                <?php
                                                $result = mysqli_query($conn, "SELECT count(hoadon.MAHOADON) as total
                                                from hoadon join nguoidung on hoadon.MAND = nguoidung.MAND
                                                where hoadon.MAND = '{$_SESSION['MAND']}'and hoadon.TINHTRANGDONHANG = 'Giao hàng thành công'");
                                                $row = mysqli_fetch_assoc($result);
                                                $total = $row['total'];
                                                echo isset($total) ? $total : 0;
                                                ?>
                                            </h4>
                                            <span>Đơn hàng đã giao</span>
                                        </div>
                                    </figure>
                                </article>


                            </div> <!-- card-body .// -->
                        </article> <!-- card.// -->

                        <article class="card  mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Đơn hàng gần đây</h5>

                                <div class="row">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT* 
                                  FROM hoadon join chitiethoadon on hoadon.MAHOADON = chitiethoadon.MAHOADON join sanpham on chitiethoadon.MASP = sanpham.MASP
                                  where hoadon.MAND = '{$_SESSION['MAND']}'
                                  ORDER by hoadon.NGAYTAO DESC
                                  LIMIT 4
                                  ");

                                    ?>
                                    <?php if (mysqli_num_rows($result) <> 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <div class="col-md-6">
                                                <figure class="itemside  mb-3">
                                                    <div class="aside"><img src="../../admin/images/sanpham/<?php echo $row['ANH']; ?>"
                                                            class="border img-sm">
                                                    </div>
                                                    <figcaption class="info">
                                                        <time class="text-muted"><i class="fa fa-calendar-alt"></i>
                                                            <?php echo $row['NGAYTAO']; ?>
                                                        </time>
                                                        <p>
                                                        <a href="../SANPHAM/Detail.php?id=<?php echo $row['MASP']?>">
                                                            <?php echo $row['TENSP']; ?>
                                                        </p>
                                                        <span class="text-success">
                                                            <?php echo $row['TINHTRANGDONHANG']; ?>
                                                        </span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php endif; ?>


                                </div> <!-- row.// -->

                                <a href="DonDatHang.php" class="btn btn-outline-primary btn-block"> Xem tất cả
                                    <i class="fa fa-chevron-down"></i> </a>
                            </div> <!-- card-body .// -->
                        </article> <!-- card.// -->

                    </main> <!-- col.// -->
                </div>

            </div> <!-- container .//  -->
        </section>
    <?php endwhile; ?>
<?php endif; ?>
<!-- ========================= SECTION CONTENT END// ========================= -->

<?php 
include ("../Shared_Layout/footer.php"); 
?>