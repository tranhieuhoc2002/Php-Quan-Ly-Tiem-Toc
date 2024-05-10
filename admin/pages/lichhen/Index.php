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
                h.MADL,
                nd.TENND,
                nd.SDT,
                h.NGAYDEN,
                t.TENTG,
                h.TINHTRANGDAT,
                c.TENDV
            FROM
                datlich h
            JOIN
                nguoidung nd ON h.MAND = nd.MAND
            JOIN
                thoigian t ON h.MATG = t.MATG
            JOIN
                dichvu c ON h.MADV = c.MADV
            WHERE
                h.MADL LIKE '%$input%' 
                OR nd.TENND LIKE '%$input%'               
                OR h.TINHTRANGDAT LIKE '%$input%'
                OR h.NGAYDEN LIKE '%$input%'
            GROUP BY
                h.MADL
            ORDER BY
                h.NGAYDEN DESC";
} else {
    $input = '';
    $sql = "SELECT
                    h.MADL,
                    nd.TENND,
                    nd.SDT,
                    h.NGAYDEN,
                    t.TENTG,
                    h.TINHTRANGDAT,
                    c.TENDV
                FROM
                    datlich h
                JOIN
                    nguoidung nd ON h.MAND = nd.MAND
                JOIN
                    thoigian t ON h.MATG = t.MATG
                JOIN
                    dichvu c ON h.MADV = c.MADV
                GROUP BY
                    h.MADV, nd.TENND, h.NGAYDEN, h.TINHTRANGDAT
                ORDER BY
                    h.NGAYDEN DESC";
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
    <h2 style="text-align:center">Danh sách lịch hẹn</h2>
    <div class="d-flex justify-content-between">
        <a></a>
        <form action="" method="get">
            <input type="text" name="input" value="<?php echo isset($_GET['input']) ? $_GET['input'] : ''; ?>" placeholder="Tìm kiếm">
            <input type="submit" value="Tìm" name="search" class="btn btn-primary">
        </form>
    </div>
    <table class="table">
        <tr align="center">
            <th>Mã đặt lịch</th>
            <th>Tên khách hàng</th>
            <th>SDT</th>
            <th>Ngày đặt</th>
            <th>Thời gian</th>
            <th>Dịch vụ</th>
            <th>Tình Trạng đặt</th>
            <th>Chức năng</th>
        </tr>
        <?php
        $total = 0;
        foreach ($list as $row) {
            $total = 0;
            ?>
            <tr align="center">
                <td><?php echo $row[0] ?></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[2] ?></td>
                <td><?php echo date('d \t\h\á\n\g m \n\ă\m Y', strtotime($row[3])); ?></td>
                <td><?php echo $row[4] ?></td>
                <td><?php echo $row[6] ?></td>
                <td><?php echo $row[5] ?></td>
                
                <td width="120px">
                    <button type="button" class="btn btn-success capnhatdatlich" data-id="<?php echo $row[0]; ?>"
                            data-toggle="modal" data-target="#capnhatdatlichModal">
                        <i class="fa fa-refresh"></i></i> Cập nhật
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

<div class="modal fade" id="capnhatdatlichModal" tabindex="-1" role="dialog" aria-labelledby="capnhatdatlichModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="capnhatdatlichModalLabel"><b>Cập Nhật Lich Hẹn</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span><b>Mã Đặt Lịch</b></span> <span id="maDL"></span><br />
        <span><b>Ngày Đặt</b></span> <span id="ngayDEN"></span><br />
        <div class="form-group">
            <label for="tinhtrang">Tình trạng đặt:</label>
            <select class="form-control" id="tinhtrang" name="tinhtrang">
                <option value="Đang xử lý">Đang xử lý</option>
                <option value="Đồng ý lịch đặt">Đồng ý lịch đặt</option>
                <option value="Không nhận lịch đặt">Không nhận lịch đặt</option>
                <option value="Hoàn thành lịch đặt">Hoàn thành lịch đặt</option>
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
  $(document).on('click', '.capnhatdatlich', function(e){
    e.preventDefault();
    
    // Lấy giá trị id từ data-attribute của nút
    var id = $(this).data('id');
    
    $('#capnhatdatlich').modal('show');
    
    $.ajax({
      type: 'POST',
      url: 'Update.php',
      data: {id: id},
      dataType: 'json',
      success:function(response){
        $('#maDL').html(response.maDL);
      
        $('#ngayDEN').html(response.ngayDEN);
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


  $("#capnhatdatlichModal").on("hidden.bs.modal", function () {
    $('#maDL').html('');
    $('#ngayDEN').html('');
    $('#update_tinhtrang').html('');
  });
});


</script>