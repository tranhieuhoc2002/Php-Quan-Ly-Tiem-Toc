<?php
include ("../Shared_Layout/header.php");
include("../../db_connect.php");
?>
<title>Đăng ký</title>
<div class="row justify-content-md-center mt-5 mb-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Đăng ký</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="DangKy_Check.php">
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger">
                            <?php echo $_GET['error']; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success'])) { ?>
                        <p class="alert alert-success">
                            <?php echo $_GET['success']; ?>
                        </p>
                    <?php } ?>

                    <div class="form-group">
                        <label for="TENND">Tên người dùng</label>
                        <input type="text" class="form-control" name="TENND" id="TENND" value="<?php if (isset($_GET['TENND']))
                            echo $_GET['TENND'] ?>">
                            <small class="form-text text-muted">Chúng tôi sẽ không chia sẻ tài khoản của bạn cho bất kỳ ai khác.</small>

                        </div>
                        
                        <div class="form-group">
                            <label for="EMAIL">EMAIL</label>
                            <input type="email" class="form-control" name="EMAIL" id="EMAIL" value="<?php if (isset($_GET['EMAIL']))
                            echo $_GET['EMAIL'] ?>">
                            <!-- Validation message here -->
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="MATKHAU">Mật khẩu</label>
                                <input type="password" class="form-control" name="MATKHAU" id="MATKHAU">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="CONFIRM-MATKHAU">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" id="CONFIRM-MATKHAU" name="CONFIRM-MATKHAU">
                                <div id="password-error" class="text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="GIOITINH">Giới Tính</label>
                            <select class="form-control" name="GIOITINH" id="GIOITINH">
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Nam" <?php if (isset($_GET['GIOITINH']) && $_GET['GIOITINH'] === 'Nam') echo 'selected'; ?>>Nam</option>
                                <option value="Nữ" <?php if (isset($_GET['GIOITINH']) && $_GET['GIOITINH'] === 'Nữ') echo 'selected'; ?>>Nữ</option>
                            </select>
                            <!-- Validation message here -->
                        </div>

                        <div class="form-group">
                            <label for="SDT">Số điện thoại</label>
                            <input type="text" class="form-control" name="SDT" id="SDT" value="<?php if (isset($_GET['SDT']))
                            echo $_GET['SDT'] ?>">
                            <!-- Validation message here -->
                        </div>
                        <div class="form-group">
                            <label for="DIACHI">Địa chỉ</label>
                            <input type="text" class="form-control" name="DIACHI" id="DIACHI" value="<?php if (isset($_GET['DIACHI']))
                            echo $_GET['DIACHI'] ?>">
                            <!-- Validation message here -->
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Đăng ký" class="btn btn-primary btn-block" id="register-button">
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-4" style="font-size:20px">Đã có tài khoản? <a href="DangNhap.php">Đăng nhập</a></p>
        </div>
    </div>


<?php
 include ("../Shared_Layout/footer.php"); 
?>