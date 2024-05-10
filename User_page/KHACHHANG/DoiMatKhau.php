<?php
include("../LOGIN_REQUIRED/Login_Required.php"); 
include ("../Shared_Layout/header.php");

$result = mysqli_query($conn, "SELECT * FROM nguoidung WHERE nguoidung.MAND = '{$_SESSION['MAND']}'");

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

            <main class="col-md-9">

                <div class="card">
                    <div class="card-body">
                        <form method="post" action="DoiMatKhau_Check.php" class="row">
                            <div class="col-md-9">
                                <div class="form-row">
                                    <div class="col form-group col-md-9">
                                        <p class="text text-success"><?php if (isset($_GET['success'])) echo $_GET['success'] ?></p>
                                        <label>Nhập mật khẩu hiện tại</label>
                                        <div>
                                            <small class="text-danger"><?php if (isset($_GET['op_error'])) echo $_GET['op_error'] ?></small>
                                            <input type="password" class="form-control" name="MATKHAU" id="MATKHAU">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col form-group col-md-9">
                                        <label>Nhập mật khẩu mới</label>
                                        <div>
                                            <small class="text-danger" ><?php if (isset($_GET['np_error'])) echo $_GET['np_error'] ?></small>
                                            <input type="password" class="form-control" name="MATKHAUMOI" id="MATKHAUMOI">

                                        </div>
                                    </div>
                                 

                                </div>
                                <div class="form-row">
                                <div class="col form-group col-md-9">
                                       
                                       <label>Nhập lại mật khẩu</label>
                                       <div>
                                       <small class="text-danger"><?php if (isset($_GET['c_np_error'])) echo $_GET['c_np_error'] ?></small>
                                           <input type="password" class="form-control" name="CONFIRM_MATKHAU"
                                               id="CONFIRM_MATKHAU">
                                       </div>
                                   </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-10">
                                        <input type="submit" value="Lưu" name="saveChanges" class="btn btn-primary mr-2"
                                            id="save_info" />
                                        <a href="CaiDatThongTin.php" class="btn btn-light">Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main> <!-- col.// -->

        </div>
    </div>
</section>

<?php
include ("../Shared_Layout/footer.php");
?>