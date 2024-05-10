<?php
include("../LOGIN_REQUIRED/Login_Required.php"); 
include ("../Shared_Layout/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cancel_dathang"]) && isset($_POST["dathang_id"])) {
        $dathang_id = $_POST["dathang_id"];
        // Kiểm tra tình trạng đặt hàng, chỉ cho phép hủy nếu tình trạng là "đang xử lý"
        $dathang_status = mysqli_query($conn, "SELECT TINHTRANGDONHANG FROM hoadon WHERE MAHOADON = '{$dathang_id}'");
        if ($dathang_status) {
            $row = mysqli_fetch_assoc($dathang_status);
            if ($row["TINHTRANGDONHANG"] === "Đang xử lý") {
                // Xóa tất cả các bản ghi liên quan trong bảng chitiethoadon
                $delete_chitiet_query = mysqli_query($conn, "DELETE FROM chitiethoadon WHERE MAHOADON = '{$dathang_id}'");
                if ($delete_chitiet_query) {

                    // Khôi phục số lượng sản phẩm đã đặt vào số lượng tồn kho của mỗi sản phẩm tương ứng
                    $restore_quantity_query = mysqli_query($conn, "SELECT MASP, SOLUONG FROM chitiethoadon WHERE MAHOADON = '{$dathang_id}'");
                    if ($restore_quantity_query) {
                        while ($chitiet_row = mysqli_fetch_assoc($restore_quantity_query)) {
                            $masp = $chitiet_row['MASP'];
                            $soluong = $chitiet_row['SOLUONG'];
                            // Cập nhật lại số lượng tồn kho của sản phẩm
                            mysqli_query($conn, "UPDATE sanpham SET SOLUONG = SOLUONG + '{$soluong}' WHERE MASP = '{$masp}'");
                        }
                    }
                    
                    // Sau đó, xóa bản ghi đặt hàng trong bảng hoadon
                    $delete_query = mysqli_query($conn, "DELETE FROM hoadon WHERE MAHOADON = '{$dathang_id}'");
                    if ($delete_query) {
                        // Nếu xóa thành công, chuyển hướng lại để cập nhật danh sách
                        echo "<div class='alert alert-danger alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h4><i class='icon fa fa-exclamation-triangle'></i> Xóa Thành Công đơn hàng của bạn</h4>
                                </div>";
                    } else {
                        // Xử lý lỗi khi không thể xóa bản ghi
                        echo "Có lỗi xảy ra khi xóa đơn hàng.";
                    }
                } else {
                    // Xử lý lỗi khi không thể xóa bản ghi chi tiết đơn hàng
                    echo "Có lỗi xảy ra khi xóa chi tiết đơn hàng.";
                }
            }
        }
    }
}

?>

<title>Đơn đặt hàng đã đặt</title>

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
                    <a class="list-group-item" href="ThongTinDat.php"> Thông tin đặt lịch </a>
                    <a class="list-group-item active" href="DonDatHang.php"> Lịch sử đơn hàng </a>
                    <a class="list-group-item" href="CaiDatThongTin.php">Cài đặt thông tin</a>
                </nav>
            </aside> <!-- col.// -->
            <main class="col-md-9">
                <?php
                    $tt_hd = mysqli_query($conn, "SELECT hoadon.*, nguoidung.*
                    FROM hoadon
                    JOIN nguoidung ON hoadon.MAND = nguoidung.MAND
                    WHERE hoadon.MAND = '{$_SESSION['MAND']}'
                    ORDER BY hoadon.MAHOADON DESC");
                ?>
                <?php if (mysqli_num_rows($tt_hd) <> 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($tt_hd)): ?>
                        <?php
                        $tongtien_querry = mysqli_query($conn, "select sum(chitiethoadon.SOLUONG*chitiethoadon.DONGIAXUAT) as tongtien
                        from chitiethoadon join hoadon on chitiethoadon.MAHOADON = hoadon.MAHOADON
                        WHERE hoadon.MAHOADON = '{$row['MAHOADON']}'");
                        $tongtien_row = mysqli_fetch_assoc($tongtien_querry);
                        $tongtien = $tongtien_row['tongtien'];
                        ?>
                        <article class="card mb-4">
                            <header class="card-header">
                                <a href="#" class="float-right"> <i class="fa fa-print"></i></a>
                                <strong class="d-inline-block mr-3">ID đơn đặt hàng:
                                    <?php echo $row['MAHOADON'] ?>
                                </strong>
                                <span>Ngày đặt:
                                    <?php echo $row['NGAYTAO'] ?>
                                </span>
                            </header>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="text-muted">Giao hàng đến</h6>
                                        <p>
                                            <?php echo $row['TENND'] ?> <br>
                                            SĐT: <?php echo $row['SDT'] ?><br> 
                                            Email: <?php echo $row['EMAIL'] ?> <br>
                                            Địa chỉ: <?php echo $row['DIACHI']; ?>
                                            <br>

                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="text-muted">Thanh toán</h6>
                                        <span class="text-success">
                                            <i class="fab fa fa-money-bill"></i>
                                            <?php echo $row['TINHTRANGDONHANG'] ?>
                                        </span>
                                         
                                        <p>
                                            Tổng tiền:
                                            <?php echo formatCurrencyVND($tongtien); ?>
                                            <br>
                                            Tiền ship:
                                            <?php echo formatCurrencyVND(0); ?>
                                            <br>
                                            <span class="b">Thanh toán:
                                                <?php echo formatCurrencyVND($tongtien); ?>
                                            </span>
                                        </p>
                                        <?php if ($row['TINHTRANGDONHANG'] === "Đang xử lý"): ?>
                                        <form method="post">
                                            <input type="hidden" name="dathang_id" value="<?php echo $row['MAHOADON']; ?>">
                                            <button type="submit" name="cancel_dathang" class="btn btn-danger">Hủy</button>
                                        </form>
                                    <?php endif; ?>
                                    </div>
                                </div> <!-- row.// -->
                            </div> <!-- card-body .// -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <?php 
                                        $tt_cthd = mysqli_query($conn, "SELECT chitiethoadon.*, hoadon.*, sanpham.*, chitiethoadon.SOLUONG as SLCTHD, chitiethoadon.DONGIAXUAT as DGX, sanpham.DONGIA as DGSP, sanpham.SALE as SALE
                                        FROM chitiethoadon
                                        JOIN hoadon ON chitiethoadon.MAHOADON = hoadon.MAHOADON
                                        JOIN sanpham ON sanpham.MASP = chitiethoadon.MASP
                                        WHERE hoadon.MAHOADON = '{$row['MAHOADON']}'");
                                        
                                        ?>
                                        <?php if (mysqli_num_rows($tt_cthd) <> 0): ?>
                                            <?php while ($row = mysqli_fetch_assoc($tt_cthd)): ?>
                                                <tr>
                                                    <td width="65">
                                                        <img src="../../admin/images/sanpham/<?php echo $row["ANH"]?>" class="img-xs border">
                                                    </td>
                                                    <td>
                                                        <a href="../SANPHAM/Detail.php?id=<?php echo $row['MASP']?>">
                                                        <p class="title mb-0"><?php echo $row["TENSP"]?> </p>
                                                        <?php if ($row['SALE'] > 0) { ?>
                                                            <var class="price h6" ><?php echo formatCurrencyVND($row['DONGIAXUAT']); ?></var>
                                                            <span class="h6 original-price"><del style="color: gray;"><?php echo formatCurrencyVND($row['DONGIA']); ?></del></span>
                                                            <?php
                                                            
                                                        } else { ?>
                                                            <var class="price h6"><?php echo formatCurrencyVND($row['DONGIA']); ?></var>
                                                        <?php } ?>
                                                    </td>
                                                    <td> Số lượng <br> <?php echo $row['SLCTHD']; ?> </td>
                                                    <td width="250">
                                                        Thành tiền <br> Thanh toán:
                                                        <?php 
                                                            $thanh_tien = $row['DONGIAXUAT'] * $row['SLCTHD'];
                                                            echo formatCurrencyVND($thanh_tien);
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div> <!-- table-responsive .end// -->
                        </article>

                    <?php endwhile; ?>
                <?php endif; ?>

            </main> <!-- col.// -->
        </div>

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->


<?php
include ("../Shared_Layout/footer.php");
?>