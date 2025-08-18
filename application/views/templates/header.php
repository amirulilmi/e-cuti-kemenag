<!DOCTYPE html>
<html lang="en">

<head>
    <title>E-Cuti Kementerian Agama</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin, Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url('files/assets/images/favicon.ico') ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

    <!-- Required Framework -->
    <link rel="stylesheet" href="<?= base_url('files/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/bower_components/bootstrap/css/bootstrap.min.css') ?>">

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="<?= base_url('files/assets/icon/themify-icons/themify-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/icon/icofont/css/icofont.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/icon/feather/css/feather.css') ?>">

    <!-- Charts -->
    <link rel="stylesheet" href="<?= base_url('files/assets/pages/chart/radial/css/radial.css') ?>">

    <!-- Plugins -->
    <link rel="stylesheet" href="<?= base_url('files/bower_components/select2/css/select2.min.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/css/component.css') ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('files/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/css/jquery.mCustomScrollbar.css') ?>">

    <!-- Date & Time Picker -->
    <link rel="stylesheet"
        href="<?= base_url('files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/bower_components/datedropper/css/datedropper.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/pages/j-pro/css/demo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/pages/j-pro/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('files/assets/pages/j-pro/css/j-pro-modern.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css') ?>">

    <!-- Summernote -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <style>
        /* Theme Loader full screen */
        .theme-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* Loader Circle Container */
        .loader-circle {
            position: relative;
            width: 80px;
            height: 80px;
        }

        /* Each circle */
        .circle {
            position: absolute;
            width: 20px;
            height: 20px;
            background: #01a9ac;
            border-radius: 50%;
            animation: pulse 1.5s infinite ease-in-out;
        }

        /* Offset the three circles */
        .circle1 {
            left: 0;
            animation-delay: 0s;
        }

        .circle2 {
            left: 30px;
            animation-delay: 0.3s;
        }

        .circle3 {
            left: 60px;
            animation-delay: 0.6s;
        }

        /* Pulse Animation */
        @keyframes pulse {

            0%,
            80%,
            100% {
                transform: scale(0);
                opacity: 0.3;
            }

            40% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
    </div>
</head>

<body>
    <div class="theme-loader">
        <div class="loader-circle">
            <div class='contain'>
                <div class="circle circle1">
                   
                </div>
                <div class="circle circle2">
                   
                </div>
                <div class="circle circle3">
                   
                </div>

            </div>
        </div>
    </div>

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">