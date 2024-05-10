<?php
session_start();
include("../../db_connect.php");

if (isset($_POST['EMAIL']) && isset($_POST['MATKHAU'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['EMAIL']);
    $matkhau = validate($_POST['MATKHAU']);
    $user_data = 'EMAIL=' . $email;

    if (empty($email)) {
        header("Location: DangNhap.php?error=Vui lòng nhập tên đăng nhập&$user_data");
        exit();
    } elseif (empty($matkhau)) {
        header("Location: DangNhap.php?error=Vui lòng nhập mật khẩu&$user_data");
        exit();
    } else {
        $sql = "SELECT * FROM nguoidung WHERE EMAIL='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['MATKHAU'] === $matkhau && $row['EMAIL'] === $email && $row['ISADMIN'] ==0) {
                $_SESSION['TENND'] = $row['TENND'];
                $_SESSION['MAND'] = $row['MAND'];
				$_SESSION['GIOITINH'] = $row['GIOITINH'];
                $_SESSION['SDT'] = $row['SDT'];
                $_SESSION['DIACHI'] = $row['DIACHI'];
                $_SESSION['EMAIL'] = $row['EMAIL'];

                $slgh = "SELECT COUNT(giohang.SOLUONG) AS total FROM giohang JOIN nguoidung ON giohang.MAND = nguoidung.MAND WHERE giohang.MAND = '{$row['MAND']}'";
                $result = mysqli_query($conn, $slgh);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['SLGH'] = $row['total'];
                header("Location: ../home/Index.php");
                exit();
            }elseif($row['MATKHAU'] === $matkhau && $row['EMAIL'] === $email && $row['ISADMIN'] ==1){
                $_SESSION['TENND'] = $row['TENND'];
                $_SESSION['MAAD'] = $row['MAND'];
				$_SESSION['GIOITINH'] = $row['GIOITINH'];
                $_SESSION['SDT'] = $row['SDT'];
                $_SESSION['DIACHI'] = $row['DIACHI'];
                $_SESSION['EMAIL'] = $row['EMAIL'];
                header("Location: ../../admin/pages/home/Index.php");
            } 
            else {
                header("Location: DangNhap.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
                exit();
            }
        } else {
            header("Location: DangNhap.php?error=Sai tên đăng nhập hoặc mật khẩu&$user_data");
            exit();
        }
    }
} else {
    header("Location: DangNhap.php");
    exit();
}
?>