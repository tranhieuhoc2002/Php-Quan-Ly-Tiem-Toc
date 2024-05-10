<?php
include("../../header_admin.php");
require("../../db_connect.php");

if (isset($_GET['search'])) {
        if (isset($_GET['input'])) {
            $input = $_GET['input'];
        } else {
            $input = '';
        }
    
        $sql = "SELECT * FROM NGUOIDUNG
                WHERE TENND LIKE '%$input%'                  
                    OR SDT LIKE '%$input%'
                    OR EMAIL LIKE '%$input%'
                    OR GIOITINH = '$input'
                    OR DIACHI = '$input' 
                ORDER BY nguoidung.MAND ASC";
    
    } else {
        $input = '';
        $sql = "SELECT * FROM NGUOIDUNG ORDER BY nguoidung.mand";
    }

$result = mysqli_query($conn, $sql);
$rowsPerPage = 5; 

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

//vị trí của mẩu tin đầu tiên trên mỗi trang
$offset = ($_GET['page'] - 1) * $rowsPerPage;

//lấy $rowsPerPage mẩu tin, bắt đầu từ vị trí $offset
$list = mysqli_fetch_all($result, MYSQLI_NUM);
?>

<div class="container">
    <h2 style="text-align:center">Danh sách người dùng</h2>

    <div class="d-flex justify-content-between">
        <a href="Create.php" class="btn btn-primary m-2"> Thêm mới</a>
        <form action="" method="get">
            <input type="text" name="input" value="<?php echo isset($_GET['input']) ? $_GET['input'] : ''; ?>" placeholder="Tìm kiếm">
            <input type="submit" value="Tìm" name="search" class="btn btn-primary">
        </form>
    </div>
    <table class="table">
        <form action="" method="post">
            <!-- Code để sắp xếp -->
            <tr align = "center">
                <th>
                    Mã người dùng
                </th>
                <th>
                    Tên người dùng
                </th>
                <th>
                    SĐT
                </th>
                <th>
                    Email
                </th>
                <th>
                    Giới tính
                </th>
                <th>
                    Địa chỉ
                </th>
                <th>
                    Phân quyền
                </th>
                <th>
                    Chức năng
                </th>
            </tr>
        </form>

            <?php
            for ($i = 0; $i < $rowsPerPage; $i++) {
                if ($offset + $i == count($list)) break;
                $row = $list[$offset + $i];
            ?>
            
            <tr align="center">
                <td><?php echo $row[0] ?></td>
                <td><?php echo $row[3] ?></td>
                <td><?php echo $row[6] ?></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[5] ?></td>
                <td><?php echo $row[7] ?></td>
                <td>
                    <?php 
                    if($row[8] == 1) {
                        echo "Admin";
                    } else {
                        echo "Khách hàng";
                    }
                    ?>
                </td>
                <td>
                    <a href="./Edit.php?maND=<?php echo $row[0] ?>"><button class='btn btn-success btn-sm edit btn-flat'><i class='fa fa-edit'></i> Sửa</button></a>
                    <a href="./Details.php?maND=<?php echo $row[0] ?>"><button class='btn btn-info btn-sm info btn-flat'><i class='fa fa-circle-info'></i> Chi tiết</button></a>
                    <a href="./Delete.php?maND=<?php echo $row[0] ?>"><button class='btn btn-danger btn-sm delete btn-flat'><i class='fa fa-trash'></i> Xoá</button></a>
                </td>
            </tr>
        <?php
        }
    
        ?>
    </table>
        <!-- Hiển thị phân trang -->
        <div style="display: flex; width: 100%;">
                <?php
                $numRows = count($list);

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