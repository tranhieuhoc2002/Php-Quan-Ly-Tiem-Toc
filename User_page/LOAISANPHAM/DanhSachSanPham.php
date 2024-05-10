<?php
include ("../Shared_Layout/header.php");
$id = "";
if (isset($_GET["id"])) {
    $id = trim(preg_replace('/\s+/', ' ', $_GET["id"]));
} //Lọc bớt khoảng trắng
$order = 'asc';

if (isset($_GET["order"])) {
    $order = $_GET["order"];
} 
// Kiểm tra thứ tự sắp xếp sản phẩm theo giá
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
$rowsPerPage = 7; //số mẩu tin trên mỗi trang, giả sử là 7

$offset = ($_GET['page'] - 1) * $rowsPerPage;
if(isset($_GET['querry'])) {
    $querry = $_GET['querry'];
} 

else {
    $querry = "SELECT * FROM sanpham join thuonghieu on sanpham.MATH = thuonghieu.MATH 
    join loaisanpham on sanpham.MALOAISP = loaisanpham.MALOAISP   
    WHERE LOWER(TENSP) LIKE '%" . strtolower($id) . "%' OR LOWER(MASP) LIKE '%" . strtolower($id) . "%' or sanpham.MALOAISP = '$id' OR LOWER(thuonghieu.TENTHUONGHIEU) LIKE '%" . strtolower($id) . "%'";
}

if (isset($_GET["filter"])) {
    
    $loaisanpham = $_GET["loaisanpham"];
    $thuonghieu = $_GET["thuonghieu"];
    $giamin = intval($_GET["giamin"]);
    $giamax = intval($_GET["giamax"]);
    
    // Lọc theo loại sản phẩm
    $querry = "SELECT * 
    FROM sanpham 
    JOIN thuonghieu ON sanpham.MATH = thuonghieu.MATH 
    JOIN loaisanpham ON sanpham.MALOAISP = loaisanpham.MALOAISP 
    WHERE 1=1";
   
        if (!empty($loaisanpham)) {
        $querry .= " AND '$loaisanpham' LIKE CONCAT('%', loaisanpham.TENLOAISP, '%')";
        }

        if (!empty($thuonghieu)) {
        $querry .= " AND '$thuonghieu' LIKE CONCAT('%', thuonghieu.TENTHUONGHIEU, '%')";
        }

        if (!empty($giamin) && !empty($giamax)) {
        $querry .= "  AND (IF(sanpham.SALE > 0, sanpham.SALE, sanpham.DONGIA) BETWEEN $giamin AND $giamax)";
        }

    
}

$listSanPham = mysqli_query($conn, $querry . " order by if(SALE > 0, SALE, DONGIA) $order LIMIT $offset , $rowsPerPage");
$re = mysqli_query($conn, $querry);
$numRows = mysqli_num_rows($re);
//tổng số trang
$maxPage = ceil($numRows / $rowsPerPage);
?>

<title>Danh sách sản phẩm</title>
<section class="section-content padding-y">
    <div class="container">
        <div class="row">
            <aside class="col-md-2">

                <article class="filter-group">
                    <h6 class="title">
                        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#collapse_1">
                            Loại sản phẩm
                        </a>
                    </h6>
                    <div class="filter-content collapse" id="collapse_1">
                        <div class="inner">
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM loaisanpham");
                            if (mysqli_num_rows($result) <> 0) {
                                while ($rows = mysqli_fetch_assoc($result)) {
                                    echo "
                                    <label class='custom-control custom-checkbox'>
                                        <input type='checkbox' class='custom-control-input' name='loaiSanPham'>
                                        <div class='custom-control-label'>
                                            {$rows['TENLOAISP']}
                                        </div>
                                    </label>
                                ";
                                }
                            }
                            ?>

                        </div> <!-- inner.// -->
                    </div>
                </article>
                <article class="filter-group">
                    <h6 class="title">
                        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#collapse_2">
                            Thương hiệu
                        </a>
                    </h6>
                    <div class="filter-content collapse" id="collapse_2">
                        <div class="inner">
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM thuonghieu");
                            if (mysqli_num_rows($result) <> 0) {
                                while ($rows = mysqli_fetch_assoc($result)) {
                                    echo "
                                    <label class='custom-control custom-checkbox'>
                                        <input type='checkbox' class='custom-control-input' name='thuongHieu'>
                                        <div class='custom-control-label'>
                                            {$rows['TENTHUONGHIEU']}
                                        </div>
                                    </label>
                                ";
                                }
                            }

                            ?>

                        </div> <!-- inner.// -->
                    </div>
                </article>
                
                <article class="filter-group">
                    <h6 class="title">
                        <a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#collapse_4">
                            Giá
                        </a>
                    </h6>
                    <div class="filter-content collapse show" id="collapse_4">
                        <div class="inner">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Min</label>
                                    <input class="form-control" placeholder="Min" type="number" name="giaMin">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Max</label>
                                    <input class="form-control" placeholder="Max" type="number" name="giaMax">
                                </div>
                            </div> <!-- form-row.// -->

                        </div> <!-- inner.// -->
                    </div>
                </article> <!-- filter-group .// -->
                
                
                <button id="btnApplyFilter" class="btn btn-block btn-primary">Áp dụng</button>

            </aside> <!-- col.// -->
            <main class="col-md-10">


                <header class="mb-3">
                    <div class="form-inline">
                        <strong class="mr-md-auto">
                            <?php echo mysqli_num_rows($re); ?> sản phẩm được tìm thấy
                        </strong>
                        <a href="../LOAISANPHAM/DanhSachSanPham.php?<?php echo 'id=' . $id . '&order=desc'  . '&querry=' . $querry ?>"
                            class="btn btn-outline-primary mr-2">
                            Giá giảm dần <i class="fas fa-arrow-down"></i>
                        </a>

                        <a href="../LOAISANPHAM/DanhSachSanPham.php?<?php echo 'id=' . $id . '&order=asc' . '&querry=' . $querry ?>"
                            class="btn btn-outline-primary">
                            Giá tăng dần <i class="fas fa-arrow-up"></i>
                        </a>
                    </div>
                </header><!-- sect-heading -->
                <?php if ( mysqli_num_rows($result) <> 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($listSanPham)): ?>
                        <article class="card card-product-list">
                            <div class="row no-gutters">
                                <aside class="col-md-4">
                                <a href="../SANPHAM/Detail.php?id=<?php echo $row['MASP']; ?>" class="img-wrap">
                                         <?PHP 
                                      // Giả sử $row['NGAYTAO'] chứa giá trị ngày từ cột 'NGAYTAO' trong cơ sở dữ liệu
                                            $ngaytao_str = $row['NGAYTAO'];

                                            // Chuyển đổi chuỗi ngày thành số nguyên thời gian
                                            $ngaytao_timestamp = strtotime($ngaytao_str);

                                            // Lấy timestamp của ngày hiện tại
                                            $now_timestamp = time();

                                            // So sánh với 7 ngày
                                            if ($now_timestamp - $ngaytao_timestamp <= 7 * 24 * 60 * 60) {
                                                echo '<span class="badge badge-danger">new</span>';
                                            }?> 
                                        <img src="../../admin/images/sanpham/<?php echo $row['ANH']; ?>">
                                    </a>
                                </aside> <!-- col.// -->
                                <div class="col-md-5">
                                    <div class="info-main">
                                        <a href="../SANPHAM/Detail.php?id=<?php echo $row['MASP']; ?>" class="h5 title">
                                            <?php echo $row['TENSP']; ?>
                                        </a>
                                        

                                        <p class="mb-3">
                                            <span class="tag">
                                                <?php echo $row['TENLOAISP']; ?>
                                            </span>
                                            <span class="tag">Còn
                                                <?php echo $row['SOLUONG']; ?> sản phẩm
                                            </span>
                                            <span class="tag">
                                                <?php echo $row['TENTHUONGHIEU']; ?>
                                            </span>
                                        </p>

                                        <p>
                                            <?php echo $row['MOTA']; ?>
                                        </p>

                                    </div> <!-- info-main.// -->
                                </div> <!-- col.// -->
                                <aside class="col-sm-3">
                                    <div class="info-aside">
                                    <div class="price-wrap">
                                        <?php if ($row['SALE'] > 0) { ?>
                                            <span class="h5 sale-price" style="color: red">
                                                <?php echo formatCurrencyVND($row['SALE']); ?>
                                            </span><br>
                                            <span class="h6 original-price"><del style="color: gray">
                                                <?php echo formatCurrencyVND($row['DONGIA']); ?>
                                                </del>
                                                </span>
                                                <?php
                                                $phanTramGiamGia = round((($row['DONGIA'] - $row['SALE']) / $row['DONGIA']) * 100);
                                                if ($phanTramGiamGia > 0) {
                                                    echo '<span class="badge badge-danger discount-badge">' . $phanTramGiamGia . '% giảm giá</span>';
                                                }
                                            } else { ?>
                                                <span class="h5 price">
                                                <?php echo formatCurrencyVND($row['DONGIA']); ?>
                                            </span>
                                        <?php } ?>
                                    </div> <!-- price-wrap.// -->
                                        <small class="text-success">Free ship</small>
                                        <p class="text-muted mt-3">
                                            <?php echo $row['TENLOAISP']; ?>
                                        </p>
                                        <p class="mt-3">
                                            <a <?php if (!isset($_SESSION['MAND'])) { ?> 
                                                href="../AUTHENTICATION/DangNhap.php" <?php } else { ?> href="javascript:void(0)" 
                                                onclick="addToCart('<?php echo $row['MASP']; ?>');" <?php } ?> 
                                                class="btn btn-outline-primary">
                                                <i class="fa fa-cart-arrow-down" ></i>
                                                    Thêm vào giỏ hàng
                                            </a>
                                        </p>

                                    </div> <!-- info-aside.// -->
                                </aside> <!-- col.// -->
                            </div> <!-- row.// -->
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>

                <!-- Template điều hướng phân trang -->
                <nav class="mb-4" aria-label="Page navigation sample">
                    <ul class="pagination">
                        <?php if ($maxPage > 1) { ?>
                            <!-- Nút Previous -->
                            <?php if ($_GET['page'] > 1) { ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($_GET['page'] - 1) . '&id=' . $id . '&order=' . $order . '&querry=' . $querry ?>">Previous</a>
                                </li>
                            <?php } ?>

                            <!-- Các nút trang -->
                            <?php for ($i = 1; $i <= $maxPage; $i++) { ?>
                                <li class="page-item <?php echo ($_GET['page'] == $i) ? 'active' : ''; ?>">
                                    <a class="page-link"
                                        href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $i . '&id=' . $id . '&order=' . $order . '&querry=' . $querry?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <!-- Nút Next -->
                            <?php if ($_GET['page'] < $maxPage) { ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($_GET['page'] + 1) . '&id=' . $id . '&order=' . $order . '&querry=' . $querry ?>">Next</a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </nav>

            </main> <!-- col.// -->

        </div>
        <form method="get" action="DanhSachSanPham.php" id="duLieuBoLoc" style="display: none">
            <!-- Đặt input elements cho loaisanpham, hedieuhanh, thuonghieu, ram, rom, giamin, và giamax ở đây -->
            <input type="hidden" name="loaisanpham" value="" />
            <input type="hidden" name="thuonghieu" value="" />
            <input type="hidden" name="giamin" value="" />
            <input type="hidden" name="giamax" value="" />
            <!-- Nút gửi form -->
            <button name="filter" type="submit">Gửi</button>
        </form>
    </div> <!-- container .//  -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#btnApplyFilter').click(function (e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a (chuyển hướng)
                // lọc thông tin check box

                var LSP = [];
                $('input[name=loaiSanPham]:checked').each(function () {
                    LSP.push($(this).parent().text().trim());
                });
                var TH = [];
                $('input[name=thuongHieu]:checked').each(function () {
                    TH.push($(this).parent().text().trim());
                });

                var Gmin = $("input[name='giaMin']").val();
                var Gmax = $("input[name='giaMax']").val();
                if(Gmax==0) Gmax = 999999999;
                // Gửi dữ liệu bộc lọc đến action

                $("input[name='loaisanpham']").val(LSP);
                $("input[name='thuonghieu']").val(TH);
                $("input[name='giamin']").val(Gmin);
                $("input[name='giamax']").val(Gmax);
                $('button[name="filter"]').click();

            });


        });
        function addToCart(masp) {

            var soluong = 1;
            $.ajax({
                url: '../GIOHANG/ThemVaoGioHang.php', // URL của phương thức "ThemVaoGioHang" trong controller
                type: 'POST',
                data: { MASP: masp, SOLUONG: soluong }, // Truyền dữ liệu masp và soluong
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        $("#CartCount").text(result.slgh);
                        showSuccessToast("Đã thêm sản phẩm vào giỏ hàng");
                    } else {
                        // Chuyển sang trang đăng nhập nếu chưa đăng nhập
                        window.location.href = "../AUTHENTICATION/DangNhap.php";
                       
                    }
                },
                error: function () {
                    alert("Có lỗi xảy ra khi thêm vào giỏ hàng!");
                }
            });
        }

    </script>

</section>
<?php 
include ("../Shared_Layout/footer.php");
?>