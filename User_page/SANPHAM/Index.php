<title>Cửa hàng</title>
<?php
 include ("../Shared_Layout/header.php");
?>

<div class="container">
    <section class="section-main padding-y">
            <main class="card">
                <div class="card-body">
                    <div class="row">
                        <aside class="col-lg col-md-3 flex-lg-grow-0">
                        </aside> <!-- col.// -->
                        <div class="col-md-9 col-xl-12 col-lg-7">
                            <!-- ================== COMPONENT SLIDER  BOOTSTRAP  ==================  -->
                            <div id="carousel1_indicator" class="slider-home-banner carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                    <li data-target="#carousel1_indicator" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel1_indicator" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col">
                                                <img src="../../admin/images/logo/banner14.png" alt="First slide">
                                            </div>
                                            <div class="col">
                                                <img src="../../admin/images/logo/banner12.png" alt="Second slide">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col">
                                                <img src="../../admin/images/logo/banner13.png" alt="Third slide">
                                            </div>
                                            <div class="col">
                                                <img src="../../admin/images/logo/banner11.png" alt="Fourth slide">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <!-- ==================  COMPONENT SLIDER BOOTSTRAP end.// ==================  .// -->
                        </div> <!-- col.// -->
                    </div> <!-- row.// -->
                </div> <!-- card-body.// -->
            </main> <!-- card.// -->
    </section>

    <!-- ========================= SECTION MAIN END// ========================= -->
        
            <div class="row justify-content-center text-uppercase">
                <div class="col-xl-6 col-lg-5 col-md-4 order-lg-1 order-md-1" >
                        <form action="../LOAISANPHAM/DanhSachSanPham.php" method="get" >
                            <select class="form-control" name="id" style="width: 350px;" onchange="this.form.submit()">
                                <option value="">CHỌN DANH MỤC SẢN PHẨM</option>
                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM loaisanpham");
                                if (mysqli_num_rows($result) <> 0) {
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$rows['MALOAISP']}'>{$rows['TENLOAISP']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </form>
                </div>
                <div class="col-xl-6 col-lg-5 col-md-6 order-lg-2 order-md-2">
                    <form action="../LOAISANPHAM/DanhSachSanPham.php" method="get" class="search-header">
                        <div class="input-group w-100">
                            <input type="text" class="form-control" placeholder="Tìm kiếm theo tên sản phẩm" name="id">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        

    <!-- =============== SECTION 1 =============== -->
    <section class="padding-bottom-sm">
    <header class="section-heading heading-line">
        <h4 class="title-section text-uppercase">Sản phẩm đang ưu đãi</h4>
    </header>
    <div class="row row-sm">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE SALE > 0 LIMIT 6");
        if (mysqli_num_rows($result) <> 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $phangiamgia = ((($rows['DONGIA'] - $rows['SALE']) / $rows['DONGIA']) * 100);
                ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <div class="card card-sm card-product-grid">
                        <a href="../SANPHAM/Detail.php?id=<?php echo $rows['MASP'] ?>" class="img-wrap">
                        <span class="badge badge-danger discount-badge">-<?= number_format($phangiamgia) ?>%</span>
                            <img src="../../admin/images/sanpham/<?= $rows['ANH'] ?>">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="../SANPHAM/Detail.php?id=<?php echo $rows['MASP'] ?>" class="title">
                                <?= $rows['TENSP'] ?>
                            </a>
                            <?php if ($rows['SALE'] > 0) { ?>
                                <div class="price mt-1">
                                    <span class="sale-price" style="color: red;"><?= number_format($rows['SALE']) . '₫'?></span>
                                    <span class="h6 original-price"><del style="color:gray;">
                                        <?= number_format($rows['DONGIA']) . '₫'?></del></span>
                                    
                                </div>
                            <?php } else { ?>
                                <div class="price mt-1">
                                    <?= $rows['DONGIA'] . '₫'?>
                                </div>
                            <?php } ?>
                        </figcaption>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div> <!-- row.// -->
    </section>

    <!-- xịt dưỡng tóc -->
    <section class="padding-bottom">
        <header class="section-heading heading-line">
            <h4 class="title-section text-uppercase">Xịt dưỡng tóc</h4>
        </header>

        <div class="card card-home-category">
            <div class="row no-gutters">
                <div class="col-md-3">

                    <div class="home-category-banner bg-light-orange">
                        <h5 class="title">Danh sách xịt dưỡng tóc hot nhất tại Guy hair studio</h5>
                        <p>Tìm kiếm những loại xịt dưỡng tóc tốt nhất tại Guy hair studio.</p>
                        <a href="../LOAISANPHAM/DanhSachSanPham.php?id=LSP01"
                            class="btn btn-outline-primary rounded-pill">Xem ngay</a>
                        
                    </div>
                </div> <!-- col.// -->
                <div class="col-md-9">
                    <ul class="row no-gutters bordered-cols">

                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE MALOAISP = 'LSP01' LIMIT 6");

                        if (mysqli_num_rows($result) <> 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                echo '<li class="col-6 col-lg-4 col-md-4">';
                                echo "<a href='../SANPHAM/Detail.php?id={$rows['MASP']} ' class='item'>";
                                echo '<div class="card-body">';
                                echo "<img class='img-sm float-right' src=../../admin/images/sanpham/{$rows['ANH']}> ";
                                echo "<p class='text-dark'> {$rows['TENSP']}</p>";
                                echo '</div>';
                                echo '</a>';
                                echo '</li>';

                            }
                        }
                        ?>
                    </ul>
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- card.// -->
    </section>


    <!-- Dầu gội -->
    <section class="padding-bottom">
        <header class="section-heading heading-line">
            <h4 class="title-section text-uppercase">Dầu gội</h4>
        </header>

        <div class="card card-home-category">
            <div class="row no-gutters">
                <div class="col-md-3">

                    <div class="home-category-banner bg-light-orange">
                        <h5 class="title">Danh sách dầu gội hot nhất tại Guy hair studio</h5>
                        <p>Tìm kiếm những loại dầu gội tốt nhất tại Guy hair studio.</p>
                        <a href="../LOAISANPHAM/DanhSachSanPham.php?id=LSP02"
                            class="btn btn-outline-primary rounded-pill">Xem ngay</a>
                        
                    </div>
                </div> <!-- col.// -->
                <div class="col-md-9">
                    <ul class="row no-gutters bordered-cols">

                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE MALOAISP = 'LSP02' LIMIT 6");

                        if (mysqli_num_rows($result) <> 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                echo '<li class="col-6 col-lg-4 col-md-4">';
                                echo "<a href='../SANPHAM/Detail.php?id={$rows['MASP']} ' class='item'>";
                                echo '<div class="card-body">';
                                echo "<img class='img-sm float-right' src=../../admin/images/sanpham/{$rows['ANH']}> ";
                                echo "<p class='text-dark'> {$rows['TENSP']}</p>";
                                echo '</div>';
                                echo '</a>';
                                echo '</li>';

                            }
                        }
                        ?>
                    </ul>
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- card.// -->
    </section>


    <!-- Dầu xã -->
    <section class="padding-bottom">
        <header class="section-heading heading-line">
            <h4 class="title-section text-uppercase">Dầu xã</h4>
        </header>

        <div class="card card-home-category">
            <div class="row no-gutters">
                <div class="col-md-3">

                    <div class="home-category-banner bg-light-orange">
                        <h5 class="title">Danh sách dầu xã hot nhất tại Guy hair studio</h5>
                        <p>Tìm kiếm những loại dầu xã tốt nhất tại Guy hair studio.</p>
                        <a href="../LOAISANPHAM/DanhSachSanPham.php?id=LSP03"
                            class="btn btn-outline-primary rounded-pill">Xem ngay</a>
                        
                    </div>
                </div> <!-- col.// -->
                <div class="col-md-9">
                    <ul class="row no-gutters bordered-cols">
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE MALOAISP = 'LSP03' LIMIT 6");

                        if (mysqli_num_rows($result) <> 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                echo '<li class="col-6 col-lg-4 col-md-4">';
                                echo "<a href='../SANPHAM/Detail.php?id={$rows['MASP']} ' class='item'>";
                                echo '<div class="card-body">';
                                echo "<img class='img-sm float-right' src=../../admin/images/sanpham/{$rows['ANH']}> ";
                                echo "<p class='text-dark'> {$rows['TENSP']}</p>";
                                echo '</div>';
                                echo '</a>';
                                echo '</li>';

                            }
                        }
                        ?>
                    </ul>
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- card.// -->
    </section>

    <article class="my-4">
        <img src="../../admin/images/logo/b15.png" width="100%" height="350px";>
    </article>

     <!-- Phần cuối  -->                   
    <section class="padding-bottom">

        <header class="section-heading heading-line">
            <h4 class="title-section text-uppercase">thương hiệu hợp tác</h4>
        </header>

        <div class="row">
            <div class="col-md-3 col-sm-6">
                <article class="card card-post">
                    <img src="../../admin/images/logo/banner21.png" class="card-img-top">
                    <div class="card-body">
                        <h6 class="title">Thương hiệu OLAPLEX</h6>
                        <p class="small text-uppercase text-muted">Nguyên lý này khởi nguồn từ các nghiên cứu trong phòng thí nghiệm 
                            nơi sản sinh ra những bí quyết làm đẹp chuyên nghiệp nhưng gần gũi và phù hợp với tất cả mọi người</p>
                    </div>
                </article> <!-- card.// -->
            </div> <!-- col.// -->
            <div class="col-md-3 col-sm-6">
                <article class="card card-post">
                    <img src="../../admin/images/logo/banner22.png" class="card-img-top">
                    <div class="card-body">
                        <h6 class="title">Thương hiệu LACEI</h6>
                        <p class="small text-uppercase text-muted">Nguyên lý này khởi nguồn từ các nghiên cứu trong phòng thí nghiệm 
                            nơi sản sinh ra những bí quyết làm đẹp chuyên nghiệp nhưng gần gũi và phù hợp với tất cả mọi người</p>
                    </div>
                </article> <!-- card.// -->
            </div> <!-- col.// -->
            <div class="col-md-3 col-sm-6">
                <article class="card card-post">
                    <img src="../../admin/images/logo/banner23.png" class="card-img-top">

                    <div class="card-body">
                        <h6 class="title">Thương hiệu MYDENTITY</h6>
                        <p class="small text-uppercase text-muted">Nguyên lý này khởi nguồn từ các nghiên cứu trong phòng thí nghiệm 
                            nơi sản sinh ra những bí quyết làm đẹp chuyên nghiệp nhưng gần gũi và phù hợp với tất cả mọi người</p>
                    </div>
                </article> <!-- card.// -->
            </div> <!-- col.// -->
            <div class="col-md-3 col-sm-6">
                <article class="card card-post">
                    <img src="../../admin/images/logo/banner24.png" class="card-img-top">
                    <div class="card-body">
                        <h6 class="title">Thương hiệu L'OREAL</h6>
                        <p class="small text-uppercase text-muted">Nguyên lý này khởi nguồn từ các nghiên cứu trong phòng thí nghiệm
                             nơi sản sinh ra những bí quyết làm đẹp chuyên nghiệp nhưng gần gũi và phù hợp với tất cả mọi người</p>
                    </div>
                </article> <!-- card.// -->
            </div> <!-- col.// -->
        </div> <!-- row.// -->

    </section>

    
</div>


<?php 
include ("../Shared_Layout/footer.php");
?>