<?php
include ("../Shared_Layout/header.php");
?>
<title>Trang đăng nhập</title>

<div class="row justify-content-md-center mt-5 mb-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Đăng nhập</h4>
            </div>
            <div class="card-body">
                <form action="DangNhap_Check.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger">
                            <?php echo $_GET['error']; ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="EMAIL">Tài khoản (EMAIL)</label>
                        <input type="text" name="EMAIL" id="EMAIL" class="form-control"
                            placeholder="Email"
                            value="<?php echo isset($_GET['EMAIL']) ? $_GET['EMAIL'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="MATKHAU">Mật khẩu</label>
                        <input type="password" name="MATKHAU" id="MATKHAU" class="form-control" placeholder="Mật khẩu">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary btn-block" value="Đăng nhập" />
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mt-4" style="font-size:20px">Bạn mới biết đến Hair Guy Salon ? <a href="DangKy.php">Đăng ký</a></p>
        <br><br>
    </div>

</div>
<?php
 include ("../Shared_Layout/footer.php"); 
?>