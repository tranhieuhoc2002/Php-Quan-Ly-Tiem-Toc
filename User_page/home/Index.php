<title>Trang chủ</title>
<?php
 include ("../Shared_Layout/header.php");
?>
<style>
    .section-m1 {
        margin: 40px 0;
    }
    #banner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background-image: url(../../admin/images/logo/background3.png); 
        width: 100%;
        height: 30vh;
        background-size: cover;
        background-position: center;
    }
    .container-fluid{
        padding: 0;
    }

    .banner1{
    height: 580px;
    background-image: url(../../admin/images/logo/person.png);
    background-size: 100% 580px;
    padding: 60px 60px;
    }
    .banner1 h2{
        font-size: 30px;
        padding-top: 150px;
        color: orange;
        font-weight: 900;
    }
    .banner1 p{
        
        font-size: 18px;
        padding-right: 60%;
        color: white;
        font-weight: 700;
    }
    </style>

<!-- banner -->
<div class="container-fuild">
    <div class="banner1">
        <div class="row featurette">
            <div class="col-md-12">
                <h2>Nơi bạn tỏa sáng với mái tóc đẹp!</h2>
                <p>Tại đây, chúng tôi cung cấp đa dạng dịch vụ chăm sóc tóc chuyên nghiệp như cắt, uốn, nhuộm,... với đội ngũ thợ tay nghề cao, tận tâm cùng sản phẩm cao cấp.
                Đặc biệt, bạn có thể đặt lịch nhanh chóng và dễ dàng ngay trên website của chúng tôi.
                Đừng bỏ lỡ cơ hội sở hữu mái tóc đẹp rạng ngời! Hãy đến với HAIR GUY SALON ngay hôm nay!
                </p>
                <button type="submit" onclick="window.location.href='../DATLICH/Index.php'" class="btn btn-primary">ĐẶT LỊCH NGAY</button>
                <button style="margin-left: 15px;" type="submit" onclick="window.location.href='../GIOITHIEU/Index.php'" class="btn btn-outline-primary ">TÌM HIỂU THÊM</button>
            </div>
        </div>
    </div>
</div>

<!-- about us -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="about-img position-relative-overflow-hidden p-5 pe-0">
                    <img src="../../admin/images/logo/aboutus2.png" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="display-4 mb-3" style="font-style: italic"> FROM HAIR GUY SALON </h2>
                <p>
                    HAIR GUY SALON hân hạnh mang đến cho quý khách những dịch vụ chăm sóc tóc chuyên nghiệp, giúp bạn sở hữu mái tóc đẹp rạng ngời và tự tin khẳng định phong cách.
                </p>
                <p>
                    HAIR GUY SALON là điểm đến lý tưởng cho những ai yêu thích phong cách thời trang tóc hiện đại và trẻ trung.
                    Với đội ngũ thợ tay nghề cao, giàu kinh nghiệm cùng sản phẩm chất lượng, chúng tôi cam kết mang đến cho bạn mái tóc đẹp rạng ngời và ưng ý nhất. <br>
                    Tại HAIR GUY SALON, bạn sẽ được trải nghiệm dịch vụ chăm sóc tóc chuyên nghiệp trong không gian hiện đại, sang trọng.<br>
                    HAIR GUY SALON - Nơi bạn tự tin khẳng định phong cách!
                </p>

                <button type="submit" onclick="window.location.href='../GIOITHIEU/Index.php'" class="btn btn-primary">Tìm hiểu thêm</button>
            </div>
        </div>
    </div>
</div>

<!-- bảng giá -->
<div class="container">
    <section>
        <header class="section-heading heading-line">
            <h4 class="title-section text-uppercase">bảng giá tại hair guy salon</h4>
        </header>
        <img src="../../admin/images/banggia/banggia123.png" alt="" width="100%">
    </section>
</div>

<!-- Dịch vụ -->
<div class="container" style="margin-top: 50px;">
    <header class="section-heading heading-line">
        <h4 class="title-section text-uppercase">DỊch VỤ tại hair guy salon</h4>
    </header>
    <div class="row">
        <div class="col-md-3">
        <div class="card" style="width: 18rem;">
            <img src="../../admin/images/logo/dv1.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body text-center">
                <h5 class="card-title">Cắt thiết kế tóc</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary text-center">Tư vấn ngay</a>
            </div>
        </div>
      </div>

        <div class="col-md-3">
        <div class="card text-center" style="width: 18rem;">
            <img src="../../admin/images/logo/dv2.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body">
                <h5 class="card-title">Tẩy & Nhuộm tóc</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Tư vấn ngay</a>
            </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center" style="width: 18rem;">
            <img src="../../admin/images/logo/dv3.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body">
                <h5 class="card-title ">Uốn tóc</h5>
                <p class="card-text ">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary text-center">Tư vấn ngay</a>
            </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center" style="width: 18rem;">
            <img src="../../admin/images/logo/dv4.png" class="card-img-top" height="300px" alt="...">
            <div class="card-body">
                <h5 class="card-title">Duỗi tóc</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary ">Tư vấn ngay</a>
            </div>
        </div>
      </div>
    </div>
    
  </div>

<!-- Đặt lịch -->
<div class="container-fluid">
    <section id="banner" class="text-light ">
        <h2 class="text-primary " style="font-weight: 900;">ĐẶT LỊCH GIỮ CHỖ CHỈ 30 GIÂY</h2>
        <h4>Hãy để chúng tôi mang lại cho bạn một mái tóc thật đẹp </h4>
        <button style="margin-top: 50px;" type="submit" onclick="window.location.href='../DATLICH/Index.php'" class="btn btn-primary">ĐẶT LỊCH NGAY TẠI ĐÂY</button>
    </section>
    
</div>



<!-- sản phẩm -->
<div class="container" style="margin-top: 60px;">
    <section class="padding-bottom-sm">
        <header class="section-heading heading-line">
            <h4 class="title-section text-uppercase">SẢN PHẨM tại HAIR guy salon</h4>
        </header>
        <div class="row row-sm">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE SALE > 0 LIMIT 12");
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
    <section class="text-center" style="margin-bottom: 50px;">
        <button type="submit" onclick="window.location.href='../SANPHAM/Index.php'" class="btn btn-primary">XEM THÊM TẤT CẢ SẢN PHẨM TẠI ĐÂY</button>
    </section>
    <article class="my-4">
        <img src="../../admin/images/logo/banner7.png" width="100%" height="350px";>
    </article>
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