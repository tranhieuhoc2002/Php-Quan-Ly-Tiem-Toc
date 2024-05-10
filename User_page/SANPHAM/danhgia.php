<?php
include("../../db_connect.php");

// Kiểm tra xem 'maSP', 'rating', và 'user_id' có tồn tại trong $_POST hay không
if (isset($_POST['product_id'], $_POST['index'], $_POST['user_id'])) {
    $maSP = $_POST['product_id'];
    $rating = $_POST['index'];
    $user_id = $_POST['user_id'];

    // Kiểm tra xem người dùng đã đánh giá chưa
    $sql_check_review = "SELECT COUNT(*) as user_reviews FROM danhgia WHERE MASP = '$maSP' AND MAND = '$user_id'";
    $result_check_review = mysqli_query($conn, $sql_check_review);
    $row_check_review = mysqli_fetch_assoc($result_check_review);

    if ($row_check_review['user_reviews'] > 0) {
        // Người dùng đã đánh giá, trả về thông báo hoặc xử lý theo ý của bạn
        echo "Bạn chỉ được đánh giá một lần.";
    } else {
        // Thực hiện truy vấn để lưu đánh giá vào cơ sở dữ liệu
        $sql = "INSERT INTO danhgia (MASP, MAND, rating) VALUES ('$maSP', '$user_id', '$rating')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'Đánh giá của bạn đã được gửi thành công!';
        } else {
            echo 'Có lỗi xảy ra khi lưu đánh giá. Lỗi: ' . mysqli_error($conn);
        }
    }
} else {
    echo 'Thiếu dữ liệu cần thiết.';
}
?>