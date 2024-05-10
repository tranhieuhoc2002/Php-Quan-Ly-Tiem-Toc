<?php
require("../../db_connect.php");
include("../../header_admin.php");

if (isset($_GET['search'])) {
    if (isset($_GET['input'])) {
        $input = $_GET['input'];
    } else {
        $input = '';
    }

    $sql = "SELECT * FROM THUONGHIEU
            WHERE TENTHUONGHIEU LIKE '%$input%'                  
                OR QUOCGIA LIKE '%$input%'  
            ORDER BY thuonghieu.math ASC";

} else {
    $input = '';
    $sql = "SELECT * FROM THUONGHIEU ORDER BY thuonghieu.math";
}

$result = mysqli_query($conn, $sql);
$rowsPerPage = 5; // số mẩu tin trên mỗi trang

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

//vị trí của mẩu tin đầu tiên trên mỗi trang
$offset = ($_GET['page'] - 1) * $rowsPerPage;

//lấy $rowsPerPage mẩu tin, bắt đầu từ vị trí $offset
$list = mysqli_fetch_all($result, MYSQLI_NUM);
?>

<div class="container">
    <h2 style="text-align:center">Danh sách thương hiệu</h2>

    <div class="d-flex justify-content-between">
        <a href="Create.php" class="btn btn-primary m-2"> Thêm mới</a>
        <form action="" method="get">
            <input type="text" name="input" value="<?php echo isset($_GET['input']) ? $_GET['input'] : ''; ?>" placeholder="Tìm kiếm">
            <input type="submit" value="Tìm" name="search" class="btn btn-primary">
        </form>
    </div>
    <table class="table">
        <tr align="center">
            <th>Mã thương hiệu</th>
            <th>Tên thương hiệu</th>
            <th>Quốc gia</th>
            <th>Chức năng</th>
        </tr>
        <?php
        for ($i = 0; $i < $rowsPerPage; $i++) {
            if ($offset + $i == count($list)) break;
            $row = $list[$offset + $i];
            ?>
            <tr align="center">
                <td><?php echo $row[0] ?></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[2] ?></td>
                <td>
                    <a href="./Edit.php?maTH=<?php echo $row[0] ?>"><button class='btn btn-success btn-sm edit btn-flat'><i class='fa fa-edit'></i> Sửa</button></a>
                    <a href="./Delete.php?maTH=<?php echo $row[0] ?>"><button class='btn btn-danger btn-sm delete btn-flat'><i class='fa fa-trash'></i> Xoá</button></a>
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