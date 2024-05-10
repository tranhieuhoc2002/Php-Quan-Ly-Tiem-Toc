<title>Liên hệ</title>
<?php
 include ("../Shared_Layout/header.php");
?>

<div id="page-content" class="single-page" style="margin-top:50px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading" style="margin-bottom: 30px;"><h1>LIÊN HỆ VỚI CHÚNG TÔI</h1></div>
            </div>

            <div class="col-md-6" style="margin-bottom: 30px;">
                <form name="form1" id="ff" method="post" action="contact.php">
                    <div class="form-group" style="margin-bottom: 30px; width: 500px;">
                        <input type="text" class="form-control" placeholder="Nhập họ và tên *" name="name" id="name" required data-validation-required-message="Vui lòng nhập tên của bạn.">
                    </div>
                    <div class="form-group" style="margin-bottom: 30px;width: 500px;">
                        <input type="email" class="form-control" placeholder="Nhập Email của bạn *" name="email" id="email" required data-validation-required-message="Please enter your email address.">
                    </div>
                    <div class="form-group" style="margin-bottom: 30px;width: 500px;">
                        <input type="tel" class="form-control" placeholder="Nhập số điện thoại *" name="phone" id="phone" required data-validation-required-message="Please enter your phone number.">
                    </div>
                    <div class="form-group" style="margin-bottom: 30px;width: 500px;">
                        <textarea class="form-control" placeholder="Viết nhận xét và góp ý của bạn" name="message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Gửi thư</button>
                </form>
            </div>

            <div class="col-md-6">
                <p><i class="fas fa-map-marker-alt"></i> 90 Mê Linh, Nha Trang, Việt Nam</p>
                <p><i class="fa fa-phone"></i> +090 207 59 86</p>
                <p><i class="fas fa-envelope"></i> hoc.th.62ttql@ntu.edu.vn</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1639.38488960952!2d109.18849986355718!3d12.2390457942147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3170677d85e23f99%3A0x3c1b9cbf74b563e3!2zOTAgTcOqIExpbmgsIFTDom4gTOG6rXAsIE5oYSBUcmFuZywgS2jDoW5oIEjDsmEgNjUwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1713973069468!5m2!1svi!2s" width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>


<?php 
include ("../Shared_Layout/footer.php");
?>