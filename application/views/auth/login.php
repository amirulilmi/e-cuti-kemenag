<!DOCTYPE html>
<html lang="en">

<head>
    <title>E-Cuti-Kemenag</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- SweetAlert dari CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('files/assets/images/favicon.ico'); ?>" type="image/x-icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

    <!-- Required Framework (Bootstrap) -->
    <link rel="stylesheet" type="text/css"
        href="<?= base_url('files/bower_components/bootstrap/css/bootstrap.min.css'); ?>">

    <!-- Themify Icons -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('files/assets/icon/themify-icons/themify-icons.css'); ?>">

    <!-- IcoFont -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('files/assets/icon/icofont/css/icofont.css'); ?>">

    <!-- Feather Icons -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('files/assets/icon/feather/css/feather.css'); ?>">

    <!-- Radial Chart -->
    <link rel="stylesheet" href="<?= base_url('files/assets/pages/chart/radial/css/radial.css'); ?>" type="text/css"
        media="all">

    <!-- Main Style -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('files/assets/css/style.css'); ?>"> -->

    <!-- jQuery Custom Scrollbar -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('files/assets/css/jquery.mCustomScrollbar.css'); ?>">

    <!-- jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>

    <!-- SweetAlert2 dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <!-- ⚠️ Catatan: File ini bukan JavaScript, tapi kamu memuatnya sebagai script -->
    <!-- Jika ini file CSS, ubah jadi <link rel="stylesheet" ...> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    <style>
        html,
        body {
            overflow: hidden;
            /* Hilangkan scroll horizontal & vertikal */
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #edfcf9;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header-bar {
            background-color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .header-bar img {
            height: 50px;
            max-width: 100%;
        }

        .header-bar span {
            font-weight: bold;
            font-size: 18px;
            margin-left: 10px;
            white-space: nowrap;
        }

        /* Login section takes all remaining height */
        .login-block {
            flex: 1;
            display: flex;
            align-items: stretch;
        }

        .illustration {
            height: 100%;
            object-fit: cover;
            width: 100%;
            display: block;
        }

        /* Login Form Area */
        .auth-box {
            border-radius: 10px;
        }

        .login-title {
            color: #3cb8a0;
            font-weight: bold;
            text-align: center;
        }

        .form-control:focus {
            border-color: #0000ff;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #0000ff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0000cc;
        }

        .role-box {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }

        .role-box i {
            margin-right: 8px;
            font-size: 18px;
        }

        .row.no-gap {
            margin-right: 0;
            margin-left: 0;
        }

        .row.no-gap>[class*='col-'] {
            padding-right: 0;
            padding-left: 0;
        }

        #login-form {
            position: relative;
            z-index: 10;
            cursor: pointer;
        }

        #login-form {
            background-color: #01A9AC;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        #login-form:hover {
            position: relative;
            z-index: 10;
            background-color: #018f91;
            /* warna sedikit lebih gelap */
            /* warna sedikit lebih gelap */
            color: white;
        }

        .form-check {
            display: flex;
            align-items: center;
            padding-left: 0;
            /* hilangkan padding default bootstrap */
        }

        .form-check-input {
            margin-left: 0;
            /* rapat ke kiri */
            margin-right: 8px;
            /* beri jarak antara checkbox dan label */
        }

        .form-check-label {
            margin-bottom: 0;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .login-block {
                flex-direction: column;
            }

            .illustration {
                height: 40vh;
            }
        }

        @media (max-width: 991.98px) {

            /* sesuai breakpoint Bootstrap md */
            .illustration {
                display: none;

            }

            .login-form {
                display: none;
                margin-top: 40px;
            }
        }
    </style>


</head>

<body>
    <!-- Header -->
    <div class="header-bar">
        <img src="<?php echo base_url('') ?>/assets/logo.webp" alt="Logo">
        <span>SISTEM INFORMASI CUTI</span>
    </div>

    <!-- Login Section -->
    <section class="login-block">
        <div class="container-fluid px-0">
            <div class="row no-gap align-items-center px-4">

                <!-- Illustration -->
                <div class="col-lg-8 col-md-12 text-center">
                    <img src="<?php echo base_url('') ?>/assets/login_page1.png" alt="Illustration"
                        class="illustration img-fluid">
                </div>

                <!-- Login Form -->
                <div class="col-lg-4 col-md-12  d-flex justify-content-center align-items-center login-form">
                    <div class="md-float-material form-material w-100" style="max-width: 450px;">
                        <div class="auth-box card border-0 shadow-sm w-100">
                            <div class="card-block p-4">
                                <h4 class="login-title mb-0">Login To E-Cuti</h4>
                                <div class="text-center my-3">
                                    <img src="<?php echo base_url('') ?>/assets/logo.webp" alt="Logo"
                                        style="height: 100px;max-width: 100%;">
                                </div>

                                <div class="role-box mb-3">
                                    <i class="bi bi-person-fill"></i>
                                    <span class="text-center"><strong>Selamat Datang Kembali</strong> <br>Untuk tetap
                                        terhubung dengan kami silahkan masuk dengan akun anda</br></span>
                                </div>

                                <div class="form-group form-primary mb-3">
                                    <input type="text" id="nip" name="nip" class="form-control email" required
                                        placeholder="Email">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary mb-3">
                                    <input type="password" id="password" name="password" class="form-control password"
                                        required placeholder="Password">
                                    <span class="form-bar"></span>
                                </div>

                                <div class="form-group form-primary mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">Remember</label>
                                    </div>
                                </div>

                                <button type="submit" id="login-form"
                                    class="btn btn-md w-100 waves-effect waves-light">Masuk</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Required Jquery -->
    <script type="text/javascript"
        src="<?php echo base_url('files/bower_components/jquery/js/jquery.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= base_url('files/bower_components/jquery/js/jquery.min.js'); ?>"></script>
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/jquery-ui/js/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('files/bower_components/popper.js/js/popper.min.js'); ?>"></script>
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- jquery slimscroll js -->
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js'); ?>"></script>

    <!-- modernizr js -->
    <script type="text/javascript" src="<?= base_url('files/bower_components/modernizr/js/modernizr.js'); ?>"></script>
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/modernizr/js/css-scrollbars.js'); ?>"></script>

    <!-- i18next.min.js -->
    <script type="text/javascript" src="<?= base_url('files/bower_components/i18next/js/i18next.min.js'); ?>"></script>
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js'); ?>"></script>
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js'); ?>"></script>
    <script type="text/javascript"
        src="<?= base_url('files/bower_components/jquery-i18next/js/jquery-i18next.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= base_url('files/assets/js/common-pages.js'); ?>"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>

    <script type="text/javascript">
        $('#login-form').click(function (event) {
            event.preventDefault(); // prevent the default form submission

            (async () => {
                var baseUrl = "<?php echo base_url(); ?>";
                var data = {
                    email: $('.email').val(),
                    password: $('.password').val(),
                    action: "save",
                };
                if (data.email.trim() === '' || data.password.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Semua field wajib diisi. Silakan lengkapi semua',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(data.email)) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Silahkan Masukkan Alamat Email yang Valid',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                $.ajax({
                    url: '<?= base_url("auth/login"); ?>',
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response.message);
                        console.log("response user_type: " + response.role);
                        if (response.status == 'success') {
                            let titleMessage = response.message + " as " + response.role;
                            if (response.password_reset == false) {
                                titleMessage = "Please reset your password to proceed.";
                            }
                            Swal.fire({
                                icon: 'success',
                                title: titleMessage,
                                confirmButtonColor: '#01a9ac',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Simulasi menutup modal (jika ada)
                                    var closeButtons = document.querySelectorAll('.md-close');
                                    closeButtons.forEach(btn => btn.click());

                                    if (response.password_reset === false) {
                                        // Redirect ke halaman reset_password di controller Dashboard
                                        window.location = baseUrl + 'dashboard/reset_password';
                                    } else {
                                        // Redirect berdasarkan role user
                                        if (response.role === 'admin' || response.role === 'manager') {
                                            window.location = baseUrl + 'Dashboard';
                                        } else if (response.role === 'staff') {
                                            window.location = baseUrl + 'Dashboard';
                                        } else if (response.role === 'kepala') {
                                            window.location = baseUrl + 'Dashboard';
                                        }
                                        else if (response.role === 'ptsp') {
                                            window.location = baseUrl + 'Dashboard';
                                        }
                                        else {
                                            Swal.fire({
                                                icon: 'error',
                                                text: 'Invalid user type or error',
                                                confirmButtonColor: '#eb3422',
                                                confirmButtonText: 'OK'
                                            });
                                        }
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: response.message,
                                confirmButtonColor: '#eb3422',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("AJAX error: " + jqXHR.responseText + ' : ' + errorThrown);
                        Swal.fire({
                            icon: 'error',
                            text: 'Internal Server Error: ' + textStatus,
                            confirmButtonColor: '#eb3422',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            })()
        })

        var data = {
            email: $('.email').val(),
            password: $('.password').val(),
            remember: $('#remember').is(':checked') ? 1 : 0, // kirim nilai 1 kalau dicentang
            action: "save",
        };
    </script>

</body>

</html>