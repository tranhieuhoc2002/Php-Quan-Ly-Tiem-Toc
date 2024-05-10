<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../Content/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../Content/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../Content/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../Content/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../Content/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../Content/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../Content/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../Content/admin/plugins/summernote/summernote-bs4.min.css">
    <link href="../../Content/admin/dist/css/styleAdmin.css" rel="stylesheet" />
    <link href="../../Content/fonts/fontawesome/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../Content/admin.css">
    <script src="../../Content/admin/dist/js/app.js"></script>
    <script src="../../Content/admin/dist/js/app1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.css">

    
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../pages/home/Index.php" class="nav-link">Trang chủ</a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-y: auto;">
            <!-- Brand Logo -->
            <a href="../../pages/home/Index.php" class="brand-link">
                <img src="../../Content/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Trang admin</span>

            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../images/logo/logo4.png" class="img-circle elevation-2" alt="User Image">
                        <span style="color: aliceblue; font-weight: 500; font-size: large;"><?php echo 'ADMIN' ?></span>
                    </div>
                    <div class="info">

                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">LỊCH HẸN</li>
                        <li class="nav-item">
                            <a href="../../pages/lichhen/Index.php" class="nav-link">
                                <i class="nav-icon fa fa-calendar-check"></i>
                                <p>
                                    Thông tin lịch hẹn
                                </p>
                            </a>
                        </li>

                        <!-- Quản lí -->
                        <li class="nav-header">QUẢN LÍ</li>
                        <li class="nav-item">
                            <a href="../../pages/hoadon/Index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Quản lí hóa đơn
                                </p>
                            </a>

                        </li>

                        <li class="nav-item">
                            <a href="../../pages/danhmucsanpham/Index.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Quản lí loại sản phẩm
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="../../pages/sanpham/Index.php" class="nav-link">
                                <i class="nav-icon fa fa-shopping-bag"></i>
                                <p>
                                    Quản lí sản phẩm
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="../../pages/thuonghieu/Index.php" class="nav-link">
                                <i class="nav-icon fas fa-star"></i>
                                <p>
                                    Quản lí thương hiệu
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../../pages/dichvu/Index.php" class="nav-link">
                                <i class="nav-icon fa fa-book"></i>
                                <p>
                                    Quản lí dịch vụ
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="../../pages/nguoidung/Index.php" class="nav-link">
                                <i class="nav-icon ion ion-ios-people"></i>
                                <p>
                                    Quản lí người dùng
                                </p>
                            </a>

                        </li>
                        
                        <li class="nav-header">THỐNG KÊ</li>
                        <li class="nav-item">
                            <a href="../../pages/thongke/Index.php" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Thống kê doanh thu
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">TÀI KHOẢN</li>
                        
                        <li class="nav-item">
                            <a href="../../pages/home/Logout.php" class="nav-link">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>
                                    Đăng xuất
                                </p>
                            </a>
                        </li>
                        <!-- make space at bottom of the sidebar -->
                        <li class="nav-item" style="height: 100px;"></li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Render body here -->
            <!-- Content Header (Page header) -->
            <!-- Link some php page -->

            