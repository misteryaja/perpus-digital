<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/photos/agung.jpg') ?>">

    <style>
        body {
            background-image: url('assets/photos/libraries.jpg');
            background-size: cover;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.7) !important;
            border-radius: 10px;
        }

        .card-header p {
            color: #333;
        }

        .card-body p {
            color: #555;
        }

        .login-box {
            width: 400px;
        }

        @media (max-width: 768px) {
            .login-box {
                width: 90%;
            }
        }
    </style>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte') ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline">
            <div class="card-header text-center">
                <p class="h1"><b><?= $header; ?></b></p>
            </div>
            <div class="card-body">
                <p class="login-box-msg text-dark"><?= $message; ?></p>

                <!-- Calling pages -->
                <?php
                if (isset($page)) {
                    echo $page;
                }
                ?>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/adminlte') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url('assets/adminlte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/adminlte') ?>/dist/js/adminlte.min.js"></script>
</body>

</html>