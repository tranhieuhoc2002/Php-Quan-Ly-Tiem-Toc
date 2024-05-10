<?php 
include ("../../db_connect.php");

if (isset($_POST['TENND']) && isset($_POST['MATKHAU']) 
    && isset($_POST['EMAIL']) && isset($_POST['CONFIRM-MATKHAU']) 
    && isset($_POST['GIOITINH']) && isset($_POST['SDT']) 
    && isset($_POST['DIACHI']) ) {
    function LayMaND($db) {
        // Lấy danh sách các MAND từ bảng nguoidung
        $query = "SELECT MAND FROM nguoidung";
        $result = mysqli_query($db, $query);

        // Lấy MAND lớn nhất
        $maMax = '';
        while ($row = mysqli_fetch_assoc($result)) {
            $maND = $row['MAND'];
            if ($maND > $maMax) {
                $maMax = $maND;
            }
        }

        // Tạo mã ND mới
        $maND = intval(substr($maMax, 2)) + 1;
        $SP = str_pad($maND, 3, '0', STR_PAD_LEFT);
        return 'ND' . $SP;
    }

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $mand = LayMaND($conn);
    $tennd = validate($_POST['TENND']);
    $email = validate($_POST['EMAIL']);
    $matkhau = validate($_POST['MATKHAU']);
    $confirm_password = validate($_POST['CONFIRM-MATKHAU']);
    $gioitinh = validate($_POST['GIOITINH']);
    $sdt = validate($_POST['SDT']);
    $diachi = validate($_POST['DIACHI']);
    $isadmin = 0;
    $user_data = 'TENND=' . $tennd . '&MATKHAU=' . $matkhau . '&CONFIRM-MATKHAU=' . $confirm_password 
    . '&gioitinh=' . $gioitinh . '&SDT=' . $sdt . '&DIACHI=' . $diachi . '&EMAIL=' . $email;

    if (empty($tennd)) {
        header("Location: DangKy.php?error=Tên là bắt buộc&$user_data");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: DangKy.php?error=Địa chỉ email không hợp lệ&$user_data");
        exit();
    } else if (empty($matkhau)) {
        header("Location: DangKy.php?error=Mật khẩu là bắt buộc&$user_data");
        exit();
    } else if ($confirm_password != $matkhau) {
        header("Location: DangKy.php?error=Mật khẩu không khớp&$user_data");
        exit();
    } else if (empty($gioitinh)) {
        header("Location: DangKy.php?error=Giới tính là bắt buộc&$user_data");
        exit();
    } else if (empty($sdt)) {
        header("Location: DangKy.php?error=Số điện thoại là bắt buộc&$user_data");
        exit();
    } else if (empty($diachi)) {
        header("Location: DangKy.php?error=Địa chỉ là bắt buộc&$user_data");
        exit();
    } else {
        $sql = "SELECT * FROM nguoidung WHERE TENND='$tennd' ";
        $result = mysqli_query($conn, $sql);

        // Kiểm tra xem địa chỉ email đã tồn tại trong cơ sở dữ liệu chưa
        $sql_check_email = "SELECT * FROM nguoidung WHERE EMAIL='$email'";
        $result_check_email = mysqli_query($conn, $sql_check_email);
        if (mysqli_num_rows($result_check_email) > 0) {
            header("Location: DangKy.php?error=Địa chỉ email đã được sử dụng bởi người khác&$user_data");
            exit();
        } else {
            // Tiếp tục chèn dữ liệu vào cơ sở dữ liệu
            $sql3 = "INSERT INTO nguoidung(MAND, EMAIL, MATKHAU, TENND, GIOITINH, SDT, DIACHI, ISADMIN) 
                    VALUES('$mand', '$email', '$matkhau', '$tennd', '$gioitinh', '$sdt', '$diachi', b'0')";
            $result3 = mysqli_query($conn, $sql3);

            if ($result3) {
                header("Location: DangNhap.php?success=Đăng ký thành công");
                exit();
            } else {
                header("Location: DangKy.php?error=Đã xảy ra lỗi khi đăng ký&$user_data");
                exit();
            }
        }

    }
} else {
    header("Location: DangKy.php");
    exit();
}
?>