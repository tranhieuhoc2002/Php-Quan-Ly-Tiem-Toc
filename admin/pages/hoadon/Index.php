<?php
require("../../db_connect.php");
include("../../header_admin.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    if (isset($_GET['input'])) {
        $input = $_GET['input'];
    } else {
        $input = '';
    }

    $sql = "SELECT
                h.MAHOADON,
                nd.TENND,
                (c.DONGIAXUAT * c.SOLUONG) AS 'TONGCONG',
                h.NGAYTAO,
                h.TINHTRANGDONHANG,
                c.SOLUONG as SOLUONG,
                nd.SDT,
                nd.DIACHI
            FROM
                hoadon h
            JOIN
                nguoidung nd ON h.MAND = nd.MAND
            JOIN
                chitiethoadon c ON h.MAHOADON = c.MAHOADON
            WHERE
                h.MAHOADON LIKE '%$input%' 
                OR nd.TENND LIKE '%$input%'               
                OR h.TINHTRANGDONHANG LIKE '%$input%'
                OR h.NGAYTAO LIKE '%$input%'
            GROUP BY
                h.MAHOADON
            ORDER BY
                h.NGAYTAO DESC";
} else {
    $input = '';
    $sql = "SELECT
                    h.MAHOADON,
                    nd.TENND,
                    (c.DONGIAXUAT * c.SOLUONG) AS 'TONGCONG',
                    h.NGAYTAO,
                    h.TINHTRANGDONHANG,
                    c.SOLUONG as SOLUONG,
                    nd.SDT,
                    nd.DIACHI
                FROM
                    hoadon h
                JOIN
                    nguoidung nd ON h.MAND = nd.MAND
                JOIN
                    chitiethoadon c ON h.MAHOADON = c.MAHOADON
                GROUP BY
                    h.MAHOADON, nd.TENND, h.NGAYTAO, h.TINHTRANGDONHANG
                ORDER BY
                    h.NGAYTAO DESC";
}


// Lấy kết quả từ câu truy vấn SQL
$result = mysqli_query($conn, $sql);

// Đếm tổng số hàng từ kết quả truy vấn CSDL
$totalRowsQuery = "SELECT COUNT(*) as totalRows FROM ($sql) AS countResult";
$totalRowsResult = mysqli_query($conn, $totalRowsQuery);
$totalRowsData = mysqli_fetch_assoc($totalRowsResult);
$numRows = $totalRowsData['totalRows'];

$rowsPerPage = 5 ; // số hàng trên mỗi trang

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
// Vị trí của hàng đầu tiên trên mỗi trang
$offset = ($_GET['page'] - 1) * $rowsPerPage;

// Sửa câu truy vấn SQL của bạn để bao gồm mệnh đề LIMIT
$sql .= " LIMIT $offset, $rowsPerPage";

$result = mysqli_query($conn, $sql);

// Lấy dữ liệu cho trang hiện tại
$list = mysqli_fetch_all($result, MYSQLI_NUM);

?>
<div class="container">
    <h2 style="text-align:center">Danh sách hóa đơn</h2>
    <div class="d-flex justify-content-between">
        <a></a>
        <form action="" method="get">
            <input type="text" name="input" value="<?php echo isset($_GET['input']) ? $_GET['input'] : ''; ?>" placeholder="Tìm kiếm">
            <input type="submit" value="Tìm" name="search" class="btn btn-primary">
        </form>
    </div>
    <table class="table">
        <tr align="center">
            <th>Mã hóa đơn</th>
            <th>Ngày tạo</th>
            <th>Tên khách hàng</th>
            <th>SDT</th>
            <th>Địa chỉ</th>
            <th>Tình trạng đơn hàng</th>
            <th>Tổng tiền</th>
            <th>Chức năng</th>
        </tr>
        <?php
        $total = 0;
        foreach ($list as $row) {
            $total = 0;
            ?>
            <tr align="center">
                <td><?php echo $row[0] ?></td>
                <td><?php echo date('d \t\h\á\n\g m \n\ă\m Y', strtotime($row[3])); ?></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[6] ?></td>
                <td><?php echo $row[7] ?></td>
                <td><?php echo $row[4] ?></td>
                <td>
                    <?php
                    $maHD = $row[0];
                    $sqlProducts = "SELECT DONGIAXUAT * SOLUONG AS 'TONGCONG' FROM chitiethoadon WHERE MAHOADON = ?";
                    $stmtProducts = mysqli_prepare($conn, $sqlProducts);
                    mysqli_stmt_bind_param($stmtProducts, "s", $maHD);
                    mysqli_stmt_execute($stmtProducts);
                    $resultProducts = mysqli_stmt_get_result($stmtProducts);
                    $products = mysqli_fetch_all($resultProducts, MYSQLI_NUM);

                    foreach ($products as $product) {
                        $subtotal = $product[0];
                        $total += $subtotal;
                    }

                    echo number_format($total);
                    ?>
                </td>
                

                <td width="120px">
                    <button type="button" class="btn btn-primary chitiethoadon" data-id="<?php echo $row[0]; ?>"
                            data-toggle="modal" data-target="#chitiethoadonModal">
                        <i class='fa fa-search'></i> Xem
                    </button>
                    <button type="button" class="btn btn-success capnhathoadon" data-id="<?php echo $row[0]; ?>"
                            data-toggle="modal" data-target="#capnhathoadonModal">
                        <i class="fa fa-refresh"></i>Cập nhật
                    </button>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <div style="display: flex; width: 100%;">
    
    <?php


    // gắn thêm nút back
    if ($_GET['page'] > 1) {
        echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] - 1) . "&search=true&input=" . urlencode($input) . "'>Back</a> ";
    } else {
        echo "<button class='btn btn-default' disabled>Back</button>";
    }

    // Trang đầu
    echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . "?page=1&search=true&input=" . urlencode($input) . "'>Trang đầu</a> ";

    // Tổng số trang
    $maxPage = ($numRows % $rowsPerPage) ? floor($numRows / $rowsPerPage) + 1 : floor($numRows / $rowsPerPage);
    $delta = 3; // số lượng trang hiển thị 2 bên

    echo "<div style='display: flex; justify-content: center; align-items: center; flex-grow: 1;'>";

    if ($maxPage < 10) {
        for ($i = 1; $i <= $maxPage; $i++) {
            // tạo link tương ứng tới các trang
            if ($i == $_GET['page']) {
                echo '<b class="btn btn-default">Trang ' . $i . '</b> '; //trang hiện tại
            } else {
                echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . "?page=" . $i . "&search=true&input=" . urlencode($input) . "'>" . $i . "</a> ";
            }
        }
    } else {
        for ($i = $_GET['page'] - $delta; $i <= $_GET['page'] + $delta; $i++) {
            // tạo link tương ứng tới các trang
            if ($i == $_GET['page']) {
                echo '<b class="btn btn-default w-40">Trang ' . $i . '</b> '; //trang hiện tại
            } else if ($i > 0 && $i <= $maxPage) {
                echo "<a class='btn btn-primary w-40' href='" . $_SERVER['PHP_SELF'] . "?page=" . $i . "&search=true&input=" . urlencode($input) . "'>" . $i . "</a> ";
            }
        }
    }

    echo "</div>";

    // Trang cuối
    echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . "?page=" . $maxPage . "&search=true&input=" . urlencode($input) . "'>Trang cuối</a> ";

    // gắn thêm nút Next
    if ($_GET['page'] < $maxPage) {
        echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] + 1) . "&search=true&input=" . urlencode($input) . "'>Next</a>";
    } else {
        echo "<button class='btn btn-default' disabled>Next</button>";
    }
    ?>
</div>

</div>
<?php
include("../../footer_admin.php");
?>

 
 <div class="modal fade" id="chitiethoadonModal" tabindex="-1" role="dialog" aria-labelledby="chitiethoadonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="chitiethoadonModalLabel"><b>Chi Tiết Hóa Đơn</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span><b>Ngày tạo</b></span> <span id="ngaytao"></span>
        <br/>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Tên Sản Phẩm</th>
              <th scope="col">Đơn Giá</th>
              <th scope="col">Số Lượng</th>
              <th scope="col">Thành Tiền</th>
            </tr>
          </thead>
          <tbody id="detail"></tbody>
        </table>
        <div style="text-align: right; padding-top: 10px;">
          <span><b>Tổng</b></span>
          <span id="total"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="capnhathoadonModal" tabindex="-1" role="dialog" aria-labelledby="capnhathoadonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="capnhathoadonModalLabel"><b>Cập Nhật Hóa Đơn</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span><b>Mã Hóa Đơn</b></span> <span id="maHD"></span><br />
        <span><b>Ngày Tạo</b></span> <span id="ngaytaoHD"></span><br />
        <div class="form-group">
            <label for="tinhtrang">Tình trạng đơn hàng:</label>
            <select class="form-control" id="tinhtrang" name="tinhtrang">
                <option value="Đang xử lý">Đang xử lý</option>
                <option value="Đang giao hàng">Đang giao hàng</option>
                <option value="Giao hàng thành công">Giao hàng thành công</option>
                <option value="Giao hàng thất bại">Giao hàng thất bại</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-success" id="luuChinhSua">Lưu</button>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
  $(document).on('click', '.chitiethoadon', function(e){
    e.preventDefault();

    $('#chitiethoadon').modal('show');
    var id = $(this).data('id');
    
    $.ajax({
      type: 'POST',
      url: 'View.php',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        $('#ngaytao').html(response.ngaytao);
        $('#maHD').html(response.maHD);
        $('#detail').html(response.list);
        $('#total').html(response.total);
      }
    });
  });

  $("#chitiethoadon").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});

$(function(){
  $(document).on('click', '.capnhathoadon', function(e){
    e.preventDefault();
    
    // Lấy giá trị id từ data-attribute của nút
    var id = $(this).data('id');
    
    $('#capnhathoadon').modal('show');
    
    $.ajax({
      type: 'POST',
      url: 'Update.php',
      data: {id: id},
      dataType: 'json',
      success:function(response){
        $('#maHD').html(response.maHD);
        $('#ngaytaoHD').html(response.ngaytaoHD);
        // Đặt giá trị cho combo box
        $('#tinhtrang').val(response.tinhtrang);
        
        // Truyền giá trị id vào hàm xuất hiện modal
        setupLuuChinhSua(id);
      }
    });
  });

  function setupLuuChinhSua(id) {
    // Sự kiện click của nút "Lưu"
    $(document).on('click', '#luuChinhSua', function(e){
      e.preventDefault();
  
      // Lấy giá trị từ combo box
      var tinhtrang = $('#tinhtrang').val();
  
      // Gửi dữ liệu đến file xử lý lưu
      $.ajax({
        type: 'POST',
        url: 'Save.php', // Đặt tên file PHP xử lý lưu
        data: {id: id, tinhtrang: tinhtrang},
        dataType: 'json',
        success:function(response){
          // Xử lý kết quả nếu cần thiết
          location.reload();
        }
      });
    });
  }


  $("#capnhathoadonModal").on("hidden.bs.modal", function () {
    $('#maHD').html('');
    $('#ngaytaoHD').html('');
    $('#update_tinhtrang').html('');
  });
});


</script>