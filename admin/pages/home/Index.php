<?php
include("../../header_admin.php");
require("../../db_connect.php");
?>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
            <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                    <?php 
                       
                        $sql_datlich = "SELECT COUNT(*) FROM datlich";
                        $kq = mysqli_query($conn, $sql_datlich);
                        $kq = mysqli_fetch_row($kq);
                        ?>
                        <h3><?php echo $kq[0] ?></h3>

                        <p>Lịch hẹn</p>
                    </div>
                    <div class="icon">
                         <i class="nav-icon fa fa-calendar-check"></i>
                    </div>
                    <a href="../lichhen/Index.php" class="small-box-footer"> Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <?php 
                       
                        $sql_countHD = "SELECT COUNT(*) FROM hoadon";
                        $kq = mysqli_query($conn, $sql_countHD);
                        $kq = mysqli_fetch_row($kq);
                        ?>
                        <h3><?php echo $kq[0] ?></h3>
                        <p>Tổng đơn đặt hàng</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="../hoadon/Index.php" class="small-box-footer"> Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <?php 
                        
                        $sql_countSP = "SELECT COUNT(*) FROM sanpham";
                        $kq = mysqli_query($conn, $sql_countSP);
                        $kq = mysqli_fetch_row($kq);
                        ?>
                        <h3><?php echo $kq[0] ?></h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="../sanpham/Index.php" class="small-box-footer"> Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-pink">
                    <div class="inner">
                    <?php 
                        
                        $sql_countKH = "SELECT COUNT(*) FROM nguoidung";
                        $kq = mysqli_query($conn, $sql_countKH);
                        $kq = mysqli_fetch_row($kq);
                        ?>
                        <h3><?php echo $kq[0] ?></h3>

                        <p>Người dùng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="../nguoidung/Index.php" class="small-box-footer"> Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Đồ thị -->

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <!-- Đưa chữ đồ thị vào giữa -->
                <h3 class="box-title text-center">Đồ thị</h3>
                <div class="box-tools pull-right">
                    <form class="form-inline">
                        <div class="form-group">
                            <!-- Đưa chọn năm vào góc phải -->
                            <label class="mr-2" style="padding: 10px;">Chọn năm: </label>
                            <select class="form-control input-sm" id="select_year">
                                <?php
                                for ($i = 2020; $i <= 2065; $i++) {
                                    $selected = ($i == $year) ? 'selected' : '';
                                    echo "<option value='" . $i . "' " . $selected . ">" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body">
                <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
                    <div id="legend" class="text-center"></div>
                    <canvas id="barChart" width="1150" height="500"></canvas>
                </div>
                <div id="debug-months"></div>
                <div id="debug-sales"></div>
            </div>
        </div>
    </div>
</div>

<?php
$months = array();
$sales = array();
$totalRevenue = 0; // Thêm biến để lưu tổng doanh thu

// Khởi tạo mảng giá trị ban đầu cho tất cả 12 tháng
for ($m = 1; $m <= 12; $m++) {
    array_push($sales, 0);
    array_push($months, date('M', mktime(0, 0, 0, $m, 1)));
}

// Sử dụng một truy vấn để lấy tổng cho từng tháng trong năm được chọn
$stmt = $conn->prepare("SELECT MONTH(hoadon.NGAYTAO) AS month, SUM(chitiethoadon.DONGIAXUAT * chitiethoadon.SOLUONG) AS total
                        FROM chitiethoadon
                        LEFT JOIN hoadon ON hoadon.MAHOADON=chitiethoadon.MAHOADON 
                        LEFT JOIN sanpham ON sanpham.MASP=chitiethoadon.MASP 
                        WHERE YEAR(hoadon.NGAYTAO)=? AND hoadon.TINHTRANGDONHANG='Giao hàng thành công'
                        GROUP BY MONTH(hoadon.NGAYTAO)");
$stmt->bind_param("s", $_GET['year']);
$stmt->execute();


$result = $stmt->get_result();

// Lấy dữ liệu từ kết quả truy vấn và đưa vào mảng
while ($srow = $result->fetch_assoc()) {
    // Sử dụng $srow['month'] để đặt giá trị vào đúng vị trí trong mảng
    $sales[$srow['month'] - 1] = round($srow['total'], 2);
    // Tính tổng doanh thu
    $totalRevenue += $srow['total'];
}

$stmt->close();

$months = json_encode($months);
$sales = json_encode($sales);
?>

<!-- End Chart Data -->

<canvas id="barChart" height="200"></canvas>
<div id="legend"></div>
<!-- Hiển thị tổng doanh thu -->
<div style="text-align: center; margin-top: 10px;" ><b>Tổng doanh thu: <?php echo number_format($totalRevenue,); ?> VNĐ</b></div>
            </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: <?php echo $months; ?>,
            datasets: [
                {
                    label: 'Doanh thu bán sản phẩm',
                    backgroundColor: 'rgba(153, 102, 255, 0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: <?php echo $sales; ?>
                }
            ]
        };

        console.log('Months:', <?php echo $months; ?>);
        console.log('Sales:', <?php echo $sales; ?>);

        var barChartOptions = {
            // Your options here
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function (value, index, values) {
                            // Định dạng số với dấu phẩy ngăn cách hàng nghìn
                            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        // Định dạng số với dấu phẩy ngăn cách hàng nghìn
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            }
        };

        barChartOptions.datasetFill = false;
        var myChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });

        document.getElementById('legend').innerHTML = myChart.generateLegend();
    });
</script>
<script>
   $(function () {
    // Hàm để thay đổi trang và lưu giá trị vào localStorage
    function changeYearAndSave(value) {
        window.location.href = 'Index.php?year=' + value;
        localStorage.setItem('selectedYear', value);
    }

    // Lắng nghe sự kiện thay đổi của select
    $('#select_year').change(function () {
        // Gọi hàm thực hiện cả hai công việc
        changeYearAndSave($(this).val());
    });

    // Lấy giá trị năm từ localStorage khi trang được tải
    var selectedYear = localStorage.getItem('selectedYear');
    
    // Nếu có giá trị năm, thiết lập giá trị mặc định cho select
    if (selectedYear) {
        $('#select_year').val(selectedYear);
    } else {
        // Nếu không có giá trị năm trong localStorage, thì kiểm tra trên URL
var urlParams = new URLSearchParams(window.location.search);
        var yearFromURL = urlParams.get('year');
        
        if (yearFromURL) {
            // Nếu có giá trị năm trên URL, thiết lập giá trị cho select
            $('#select_year').val(yearFromURL);
        } else {
            // Nếu không có giá trị năm trên URL, mặc định là 2020
            $('#select_year').val('2020');
        }
    }
});
</script>

<?php
$conn->close();
include("../../footer_admin.php");
?>
<style>
    ul {
    list-style-type: none; /* Loại bỏ dấu chấm của danh sách */
}

/* CSS tùy chọn nếu bạn muốn giữ dấu chấm cho các mục danh sách khác */
ul li {
    list-style-type: none;
}
.small-box .inner  {
    color: #FFFFFF;/* Mã màu hoặc tên màu bạn muốn sử dụng */;
}

.small-box-footer {
    color: #FFFFFF !important;
}
</style>