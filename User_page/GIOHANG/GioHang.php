<title>Giỏ hàng</title>
<?php
include("../LOGIN_REQUIRED/Login_Required.php"); 
if(!isset($_SESSION['MAND']))
{
    header("Location: ../AUTHENTICATION/DangNhap.php");
   
    exit();
    
}
include ("../Shared_Layout/header.php");

?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
    <div class="container">

        <div class="row">
            <main class="col-md-9">
                <div class="card">
                    <?php
                 
                 $result = mysqli_query($conn, "SELECT sanpham.*, thuonghieu.*, giohang.SOLUONG as SLGH, sanpham.DONGIA as DGSP, sanpham.SALE as sale,sanpham.SOLUONG as SLSP
                 FROM giohang
                 JOIN sanpham ON giohang.MASP = sanpham.MASP 
                 JOIN thuonghieu ON sanpham.MATH = thuonghieu.MATH
                 WHERE giohang.MAND = '{$_SESSION['MAND']}'");
                    ?>
                    <?php if (mysqli_num_rows($result) == 0): ?>
                        <h3 class="text-dark">Không có sản phẩm trong giỏ hàng</h3>
                    <?php else: ?>
                    <table class="table table-borderless table-shopping-cart">
                        <thead class="text-dark">
                            <tr class="small text-uppercase">
                                <th scope="col" width="60"> </th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col" width="120">Số lượng</th>
                                <th scope="col" width="150">Giá</th>
                                <th scope="col" width="200">Thành tiền</th>
                                <th scope="col" class="text-right" width="80"></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="col-9 sanpham-checkbox pt-4" style="height: 20px"
                                        id="sanpham" data-idsp="<?php echo $row['MASP']?>" onchange="calculateTotalPrice()" />
                                </td>
                                <td>
                                    <figure class="itemside">
                                        <div class="aside">
                                            <a href="../SANPHAM/Detail.php?id=<?php echo $row['MASP']?>">
                                                <img src="../../admin/images/sanpham/<?php echo $row['ANH']?>" class="img-sm"></a>
                                        </div>
                                        <figcaption class="info">
                                            <a href="#" class="title text-dark"><?php echo $row['TENSP']?></a>
                                        </figcaption>
                                    </figure>
                                </td>
                                <td>
                                <div class="input-group mb-3 input-spinner">
                                    <div class="input-group-prepend">
                                        <button onclick="decreaseQuantity('<?php echo $row['MASP']?>')" class="btn btn-light button-minus" type="button">
                                            &minus;
                                        </button>
                                    </div>
                                    <input id="soluong_<?php echo $row['MASP']; ?>" type="text" class="form-control input-quantity" readonly="readonly" value="<?php echo $row['SLGH']; ?>" min="1" max="<?php echo $row['SLSP']; ?>">
                                    <div class="input-group-append">
                                        <button onclick="increaseQuantity('<?php echo $row['MASP']?>')" class="btn btn-light button-plus" type="button">
                                            +
                                        </button>
                                    </div>
                                </div>
                                </td>
                                <td>
                                <div class="price-wrap">
                                    <?php if ($row['SALE'] > 0) { ?>
                                        <var class="price pt-2 sale-price"
                                            id="giaSP_<?php echo $row['MASP']?>">  <?php echo formatCurrencyVND($row['sale']); ?></var>
                                    <?php } else { ?>
                                        <var class="price pt-2"
                                            id="giaSP_<?php echo $row['MASP']?>">  <?php echo formatCurrencyVND($row['DGSP']); ?></var>
                                    <?php } ?>
                                </div>
                                </td>
                                <td>
                                <div class="price-wrap">
                                    <?php if ($row['SALE'] > 0) { ?>
                                        <var id="subtotal_<?php echo $row['MASP']?>" class="price pt-2 item-total">
                                            <?php echo formatCurrencyVND($row['SALE'] * $row['SLGH']); ?>
                                        </var>
                                    <?php } else { ?>
                                        <var id="subtotal_<?php echo $row['MASP']?>" class="price pt-2 item-total">
                                            <?php echo formatCurrencyVND($row['DGSP'] * $row['SLGH']); ?>
                                        </var>
                                    <?php } ?>
                                </div>
                                </td>
                                <td class="text-right">

                                    <a id="xoaSP_<?php echo $row['MASP']?>" href="" class="btn btn-light btn-delete"
                                        data-masp="<?php echo $row['MASP']?>"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                   
                    <?php endif; ?>
                    <div class="card-body border-top">
                        <a href="" class="btn btn-primary float-md-right" id="btnThanhToan">
                            Thanh toán giỏ hàng <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="../LOAISANPHAM/DanhSachSanPham.php" class="btn btn-light">
                            <i class="fa fa-chevron-left"></i> Tiếp tục xem hàng
                        </a>
                    </div>
                </div> <!-- card.// -->

                <div class="alert alert-success mt-3">
                    <p class="icontext">
                        <i class="icon text-success fa fa-truck"></i> Giao hàng miễn phí trong vòng
                        2-4 ngày
                    </p>
                </div>

            </main> <!-- col.// -->
            <aside class="col-md-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Có mã giảm giá?</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name=""
                                        placeholder="Nhập mã giảm giá ở đây">
                                    <span class="input-group-append">
                                        <button class="btn btn-primary">Áp dụng</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <dl class="dlist-align">
                            <dt>Tổng tiền:</dt>
                            <dd class="text-right" id="TongTien">0</dd>
                        </dl>
                        <dl class="dlist-align">
                            <dt>Giảm giá</dt>
                            <dd class="text-right">0</dd>
                        </dl>
                        <dl class="dlist-align">
                            <dt>Thành tiền:</dt>
                            <dd class="text-right h5" id="ThanhTien"><strong>0</strong></dd>
                        </dl>
                        <hr>
                        <p class="text-center mb-3">
                            <img src="../../Content/images/misc/payments.png" height="26">
                        </p>
                    </div>
                </div>
            </aside> <!-- col.// -->
        </div>

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->
<!-- ========================= SECTION  ========================= -->
<section class="section-name border-top padding-y">
    <div class="container">
        <h6>Chính sách thanh toán và hoàn trả</h6>
        <p>
            Chúng tôi cam kết cung cấp cho khách hàng của chúng tôi một quy trình thanh toán đơn giản, an toàn và
            tiện lợi.
            bảo thông tin cá nhân và tài khoản ngân hàng của khách hàng được bảo vệ tối đa.
        </p>
        <p>
            Đối với chính sách hoàn tiền, chúng tôi cam kết tuân thủ theo quy định và quy trình được xác định rõ
            ràng. Trong
            trường hợp khách hàng gặp vấn đề với đơn hàng như hàng hỏng, không đúng mô tả hoặc giao hàng chậm, chúng
            tôi sẽ
            xem xét và xử lý yêu cầu hoàn tiền một cách nhanh chóng và công bằng. Quy trình hoàn tiền sẽ được thực
            hiện qua
            cùng phương thức thanh toán ban đầu hoặc thông qua các phương thức khác mà khách hàng và chúng tôi thỏa
            thuận.
        </p>
        <p>
            Chúng tôi cam kết mang đến trải nghiệm mua sắm trực tuyến tin cậy và đáng tin cậy cho khách hàng, bằng
            cách cung
            cấp chính sách thanh toán và hoàn tiền rõ ràng và công bằng.


        </p>
    </div><!-- container // -->
    <form id="hiddenForm" action="../GIOHANG/XacNhanDonHang.php" method="POST">
    <input type="hidden" name="selectedProducts" id="hiddenSelectedProducts">
</form>
</section>
<!-- ========================= SECTION  END// ========================= -->

<script>

    // hàm hiển thị thông báo cạnh viền
    
    $(function () {
        
        // Lấy các phần tử DOM cần thiết
        var checkboxes = document.querySelectorAll('[id="sanpham"]');
        var checkAllCheckbox = document.getElementById('check-all');
        // Thiết lập sự kiện cho checkbox check-all
        $("#check-all").click(function () {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
            calculateTotalPrice();
            calculateSelectedCount();
        });
        // Thiết lập sự kiện cho các checkbox sản phẩm
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
            
                calculateTotalPrice();
                calculateSelectedCount();
                // Kiểm tra nếu tất cả các checkbox sản phẩm đều được chọn
                var allChecked = Array.from(checkboxes).every(function (checkbox) {
                    return checkbox.checked;
                });
                // Cập nhật trạng thái của checkbox "Tất cả"
                checkAllCheckbox.checked = allChecked;
            });
        });
    });
    function calculateSelectedCount() {
        var checkboxes = document.querySelectorAll('.sanpham-checkbox');
        var countElement = document.querySelector('.countslsp');
        var countElement1 = document.querySelector('.countslsp1');
        var selectedCount = 0;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedCount++;
            }
        });

        countElement.innerText = selectedCount;
        countElement1.innerText = selectedCount;
    }
   
    //Cập nhật số lượng vào csdl
    function updateCart(idsp, soluong) {
      
        $.ajax({
            type: "POST",
            url: "CapNhatSoLuong.php",
            data: { MASP: idsp, SOLUONG: soluong },
            success: function (response) {
              
                var result = JSON.parse(response); 
              
                // Xử lý kết quả trả về
                if (result.success) {               
                    showSuccessToast("Giỏ hàng đã được cập nhật");

                } else {   
                    // Hiển thị thông báo lỗi
                    alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
                }
            },
            error: function () {
                // Hiển thị thông báo lỗi
                alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
            }
        });
    }
    //Nút bấm giảm 1 số lượng
    function decreaseQuantity(productId) {
       
        var inputElement = document.getElementById('soluong_' + productId);
        var quantity = parseInt(inputElement.value);
        if (quantity > 1) {
            quantity -= 1;
            inputElement.value = quantity;
            updateCart(productId, quantity);
            calculateSubtotalPrice(productId);
            calculateTotalPrice();
        }
    }
    //xóa sản phẩm khỏi giỏ hàng
    $('[id^="xoaSP_"]').click(function (e) {
        e.preventDefault();
        var masp = $(this).data('masp');
        var currentRow = $(this).closest('tr'); // Lấy hàng chứa nút xóa sản phẩm

        $.ajax({
            url: 'XoaSanPham.php',
            type: 'POST',
            data: { MASP: masp },
            success: function (response) {
                var result = JSON.parse(response); 
             
                if (result.success) {
                    showSuccessToast("Đã xóa sản phẩm khỏi giỏ hàng");
                    $("#CartCount").text(result.slgh);
                    currentRow.remove(); // Xóa hàng khỏi bảng

                } else {
                    alert("Xóa lỗi");
                }
            },
            error: function () {
                // Xử lý lỗi nếu cần thiết
            }
        });
    });


    //Nút bấm tăng 1 số lượng
    function increaseQuantity(productId) {
    var inputElement = document.getElementById('soluong_' + productId);
    var quantity = parseInt(inputElement.value);
    var maxQuantity = parseInt(inputElement.getAttribute('max'));
    
    if (quantity < maxQuantity) {
        quantity += 1;
        inputElement.value = quantity;
        updateCart(productId, quantity);
        calculateSubtotalPrice(productId);
        calculateTotalPrice();
    }
}

    //Tính thành tiền cho từng sản phẩm
    function calculateSubtotalPrice(idsp) {
        var inputElement = document.getElementById("soluong_" + idsp);
        var quantity = parseInt(inputElement.value);
        var price = parseInt(document.getElementById("giaSP_" + idsp).innerText.replace(/\D/g, ""));
        var subtotalPrice = quantity * price;
        var subtotalElement = document.getElementById("subtotal_" + idsp);
        subtotalElement.innerText = formatCurrency(subtotalPrice);
    }
    
    //Tính tổng tiền
    function calculateTotalPrice() {
        var total = 0;
        var checkboxes = document.querySelectorAll('.sanpham-checkbox');
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                var idsp = checkbox.getAttribute('data-idsp');              
                var subtotalElement = document.getElementById('subtotal_' + idsp);
                
                var subtotalPrice = parseInt(subtotalElement.innerText.replace(/\D/g, ''));
                total += subtotalPrice;
            
            }
        });
      
        var sumElement = document.getElementById('TongTien');
        sumElement.innerText = formatCurrency(total);
        var finalSumElement = document.getElementById('ThanhTien');
        finalSumElement.innerText = formatCurrency(total);
       
    }
    $('#btnThanhToan').click(function (e) {
        e.preventDefault();
        sendSelectedProducts();
    });
    // Truyền dữ liệu selected products sang action XacNhanDatHang
    function sendSelectedProducts() {
    var checkboxes = document.querySelectorAll('.sanpham-checkbox:checked');
    var selectedProducts = [];

    checkboxes.forEach(function (checkbox) {
        var masp = checkbox.dataset.idsp;
        var soluong = parseInt(document.getElementById('soluong_' + masp).value);

        var selectedProduct = {
            MASP: masp,
            SOLUONG: soluong,
        };

        selectedProducts.push(selectedProduct);
    });

    // Gán giá trị selectedProducts vào trường ẩn trong biểu mẫu
    document.getElementById('hiddenSelectedProducts').value = JSON.stringify(selectedProducts);

    // Gửi biểu mẫu
    if(selectedProducts.length > 0)
    document.getElementById('hiddenForm').submit();
    else
    alert("Vui lòng chọn sản phẩm trong giỏ hàng để thanh toán");
}
   
    function formatCurrency(number) {
        return number.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
    }
</script>


<?php
include ("../Shared_Layout/footer.php");
?>