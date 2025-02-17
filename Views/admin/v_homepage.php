<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/photos/agung.jpg') ?>">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte') ?>/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte') ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Fullscreen -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="https://www.instagram.com/ansdyi/" class="brand-link">
                <img src="<?php echo base_url('assets/adminlte') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Perpus Digital</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo base_url('assets/adminlte') ?>/dist/img/user4-128x128.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="https://www.instagram.com/ansdyi/" class="d-block"><?= session()->get('name') ?></a>
                    </div>
                </div>
                <div class="user-panel mt-3 mb-4 d-flex">
                    <div class="info">
                        <p class="text-white">Your Role as: <?= session()->get('role') ?></p>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-header">MENU</li>
                        <li class="nav-item">
                            <a href="<?= base_url('books') ?>" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Books Administration
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('transactions') ?>" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Library Transactions
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('reports') ?>" class="nav-link">
                                <i class="nav-icon fas fa-print"></i>
                                <p>
                                    Print Summary
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">AUTH</li>
                        <li class="nav-item">
                            <a href="<?= base_url('logout') ?>" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <?php
        if (isset($page)) {
            echo $page;
        }
        ?>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2025 Anisa Damayanti for 12th Grade of Software Engineering [Ujikom P1 Website 2024].</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/adminlte') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/adminlte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/adminlte') ?>/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url('assets/adminlte') ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('document').ready(function() {
                <?php if (session()->getFlashdata('title')) { ?>
                    Toast.fire({
                        icon: 'success',
                        title: '<?= session()->getFlashdata('title') ?>',
                        text: '<?= session()->getFlashdata('text') ?>',
                    });
                <?php } ?>
            });
        });
    </script>
    <!-- bs-custom-file-input -->
    <script src="<?php echo base_url('assets/adminlte') ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>