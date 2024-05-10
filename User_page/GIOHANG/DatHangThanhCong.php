<?php 
include("../../db_connect.php");
include("../LOGIN_REQUIRED/Login_Required.php"); 
include ("../Shared_Layout/header.php");

function LayMaHoaDon($db) {
    // Lấy danh sách các MAND từ bảng HOADON
    $query = "SELECT MAHOADON FROM hoadon";
    $result = mysqli_query($db, $query);

    // Lấy MAHOADON lớn nhất
    $maMax = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $maHD = $row['MAHOADON'];
        if ($maHD > $maMax) {
            $maMax = $maHD;
        }
    }

    // Tạo mã ND mới
    $maHD = intval(substr($maMax, 2)) + 1;
    $HD = str_pad($maHD, 3, '0', STR_PAD_LEFT);
    return 'HD' . $HD;
}
$mahd = LayMaHoaDon($conn);

//Thêm vào bảng hóa đơn
mysqli_query($conn,"INSERT INTO `hoadon` (`MAHOADON`, `MAND`, `NGAYTAO`, `TINHTRANGDONHANG`) 
VALUES ('$mahd', '{$_SESSION['MAND']}', NOW(), 'Đang xử lý');");


$selectedProducts = $_SESSION['selectedProducts'];
//Thêm từng chi tiết hóa đơn
foreach ($selectedProducts as $product) {
    $masp = $product['MASP'];
    $soluong = $product['SOLUONG'];
    
    // Lấy số lượng sản phẩm hiện tại trong bảng SANPHAM
    $soluonghientai_query = mysqli_query($conn,"SELECT SOLUONG FROM sanpham WHERE MASP = '$masp' LIMIT 1");
    $row = mysqli_fetch_assoc($soluonghientai_query);
    $soluonghientai = $row['SOLUONG'];
    
    // Kiểm tra tình trạng đơn hàng
    $tinhtrangdonhang_query = mysqli_query($conn,"SELECT TINHTRANGDONHANG FROM hoadon WHERE MAHOADON = '$mahd' LIMIT 1");
    $row = mysqli_fetch_assoc($tinhtrangdonhang_query);
    $tinhtrangdonhang = $row['TINHTRANGDONHANG'];
    
    // Nếu tình trạng đơn hàng là "Đã giao thành công" thì trừ số lượng sản phẩm
    if ($tinhtrangdonhang == "Đang giao hàng" || $tinhtrangdonhang == "Đang xử lý" || $tinhtrangdonhang == "Giao hàng thành công") {
        $soluongmoi = $soluonghientai - $soluong;
        
        // Cập nhật số lượng sản phẩm trong bảng SANPHAM
        mysqli_query($conn,"UPDATE sanpham SET SOLUONG = $soluongmoi WHERE MASP = '$masp'");
    }
    else if($tinhtrangdonhang == "Giao hàng thất bại"){
        $soluongmoi = $soluonghientai+$soluong;
        // Cập nhật số lượng sản phẩm trong bảng SANPHAM
        mysqli_query($conn,"UPDATE sanpham SET SOLUONG = $soluongmoi WHERE MASP = '$masp'");
        }
    
    // Thêm chi tiết hóa đơn vào bảng chitiethoadon
    $dongiaxuat_query = mysqli_query($conn,"SELECT DONGIA FROM giohang WHERE MASP = '$masp' AND MAND = '{$_SESSION['MAND']}' LIMIT 1");
    $row = mysqli_fetch_assoc($dongiaxuat_query);
    $dongia = $row['DONGIA'];
    mysqli_query($conn,"INSERT INTO `chitiethoadon` (`MAHOADON`, `MASP`, `SOLUONG`, `DONGIAXUAT`) 
VALUES ('$mahd', '$masp', $soluong,  $dongia)");
}
    // Xóa sản phẩm đã thanh toán khỏi bảng giỏ hàng
foreach ($selectedProducts as $product) {
    $masp = $product['MASP'];
    mysqli_query($conn, "DELETE FROM giohang WHERE MASP = '$masp' AND MAND = '{$_SESSION['MAND']}'");
}
?>
<script>
   // Xóa sản phẩm đã thanh toán khỏi danh sách sản phẩm được lưu trong localStorage
var selectedProducts = JSON.parse(localStorage.getItem("selectedProducts"));
var updatedProducts = selectedProducts.filter(function(product) {
    return !isProductPaid(product.MASP);
});
localStorage.setItem("selectedProducts", JSON.stringify(updatedProducts));

// Kiểm tra xem sản phẩm có được thanh toán hay không
function isProductPaid(masp) {
    // Thực hiện kiểm tra sản phẩm đã được thanh toán hay chưa
    // Trả về true nếu sản phẩm đã được thanh toán, ngược lại trả về false
}
</script>
<title>Đặt hàng thành công</title>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
    #payment_success {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }

    #payment_success h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    #payment_success p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    #payment_success i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    #payment_success .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }
</style>
<div id="payment_success">
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">✓</i>
        </div>
        <h1>Thành công</h1>
        <p>Chúng tôi đã nhận được đơn đặt hàng của bạn</p>
    </div>
</div>

<script>
    var countdown = 3; // Số giây đếm ngược
    var countdownElement = document.createElement('p');
    countdownElement.innerText = 'Bạn sẽ trở về trang chủ sau ' + countdown + ' giây';
    document.querySelector('.card').appendChild(countdownElement);

    // Đếm ngược và chuyển hướng về trang ../../HOME/Index.php
    var countdownInterval = setInterval(function() {
        countdown--;
        countdownElement.innerText = 'Bạn sẽ trở về trang chủ sau ' + countdown + ' giây';
        if (countdown === 0) {
            clearInterval(countdownInterval);
            window.location.href = "../HOME/Index.php";
        }
    }, 1000);

    // Ngăn người dùng quay lại trang trước đó
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>

<?php
include ("../Shared_Layout/footer.php");
?>