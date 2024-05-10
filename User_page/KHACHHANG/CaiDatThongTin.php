<?php
include("../LOGIN_REQUIRED/Login_Required.php"); 
include ("../Shared_Layout/header.php");


$result = mysqli_query($conn, "SELECT * FROM nguoidung WHERE MAND = '{$_SESSION['MAND']}'");

?>


<title>Cài đặt thông tin</title>

<section class="section-pagetop bg-gray">
    <div class="container">
        <h2 class="title-page">Tài khoản của tôi</h2>
    </div> <!-- container //  -->
</section>


<section class="section-content padding-y">
    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <nav class="list-group">
                    <a class="list-group-item " href="Detail.php"> Thông tin chung </a>
                    <a class="list-group-item" href="ThongTinDat.php"> Thông tin đặt lịch </a>
                    <a class="list-group-item" href="DonDatHang.php"> Lịch sử đơn hàng </a>
                    <a class="list-group-item active" href="CaiDatThongTin.php">Cài đặt thông tin</a>
                </nav>
            </aside> <!-- col.// -->
            <?php if (mysqli_num_rows($result) != 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <main class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="CapNhatThongTin.php" class="row">
                                    <div class="col-md-9">
                                        <div class="from-group">
                                            <div class=" form-group">
                                                <label>Email đăng nhập</label>
                                                <div>
                                                    <input disabled type="text" class="form-control" name="EMAIL"
                                                        id="EMAIL" value="<?php if (isset($row['EMAIL']))
                                                        echo $row['EMAIL'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col form-group display-flex">
                                                <div class="d-flex justify-content-between">
                                                    <label>Họ và tên</label>
                                                    <small class="text-danger">
                                                        <?php if (isset($_GET['tennd_error']))
                                                            echo $_GET['tennd_error'] ?>
                                                        </small>
                                                </div>
                                                    <div>
                                                        <input type="text" class="form-control" name="TENND" id="TENND" value="<?php if (isset($row['TENND']))
                                                            echo $row['TENND'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col form-group">
                                                    <div class="d-flex justify-content-between">
                                                        <label>Giới tính</label>
                                                        <small class="text-danger">
                                                            <?php if (isset($_GET['gioitinh_error'])) echo $_GET['gioitinh_error'] ?>
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <select class="form-control" name="GIOITINH" id="GIOITINH">
                                                            <option value="">-- Chọn giới tính --</option>
                                                            <option value="Nam" <?php if (isset($row['GIOITINH']) && $row['GIOITINH'] == 'Nam') echo 'selected' ?>>Nam</option>
                                                            <option value="Nữ" <?php if (isset($row['GIOITINH']) && $row['GIOITINH'] == 'Nữ') echo 'selected' ?>>Nữ</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col form-group">
                                                    <div class="d-flex justify-content-between">
                                                        <label>Số điện thoại</label></label>
                                                        <small class="text-danger">
                                                            <?php if (isset($_GET['sdt_error']))
                                                            echo $_GET['sdt_error'] ?>
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <input type="text" class="form-control" name="SDT" id="SDT" value="<?php if (isset($row['SDT']))
                                                            echo $row['SDT'] ?>">

                                                    </div>
                                                </div>
                                                <div class="col form-group">
                                                    <div class="d-flex justify-content-between">
                                                        <label>Địa chỉ</label>
                                                        <small class="text-danger">
                                                        <?php if (isset($_GET['diachi_error']))
                                                            echo $_GET['diachi_error'] ?>
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <input type="text" class="form-control" name="DIACHI" id="DIACHI" value="<?php if (isset($row['DIACHI']))
                                                            echo $row['DIACHI'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-md-10">
                                                    <input type="submit" value="Lưu" name="saveChanges"
                                                        class="btn btn-primary mr-2" id="save_info" />
                                                        <a href="DoiMatKhau.php" class="btn btn-light">Đổi mật khẩu</a>
                                                </div>
                                            </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </main> <!-- col.// --> <!-- col.// -->
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php
include ("../Shared_Layout/footer.php");
?>

