<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

    <!-- Font Awesome icons (free version)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Fonts CSS-->
    <link href="css/heading.css" rel="stylesheet">
    <link href="css/body.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">

    <!-- Untuk Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Style -->
    <style>
        .form {
            border-radius: 20px;
            background-color: #ffeb99;
        }

        .form-group {
            text-align: left;
        }

        #about {
            background-color: #b49c73;
        }

        #buttonmasuk {
            width: 320px;
            border-radius: 10px;
            background-color: #1abc9c;
        }

        html,
        body {
            background-color: #b49c73;
            color: #636b6f;
            height: 100vh;
            margin: 0;
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-link {
            font-size: 14px;
        }

        .dropdown-item:hover {
            background-color: #1abc9c;
        }
    </style>

</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav" style="background-color: #565d47; height:65px">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img src="/images/logo.png" style="width:100px; float:left">
            </a>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">

                    <!-- NAVBAR ADMIN -->
                    @if (session('login_admin'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">KELOLA DATA MASTER</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/produk">Produk</a>
                            <a class="dropdown-item" href="/layanan">Layanan</a>
                            <a class="dropdown-item" href="/hargaLayanan">Harga Layanan</a>
                            <a class="dropdown-item" href="/pegawai">Pegawai</a>
                            <a class="dropdown-item" href="/supplier">Supplier</a>
                            <a class="dropdown-item" href="/member">Member</a>
                            <a class="dropdown-item" href="/hewan">Hewan</a>
                            <a class="dropdown-item" href="/jenisHewan">Jenis Hewan</a>
                            <a class="dropdown-item" href="/ukuranHewan">Ukuran Hewan</a>
                            <a class="dropdown-item" href="/produkMinim">Produk Hampir Habis</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">KELOLA PRODUK & LAYANAN</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/penjualanProduk">Penjualan Produk</a>
                            <a class="dropdown-item" href="/transaksiLayanan">Jasa Layanan</a>
                            <a class="dropdown-item" href="/antrianHewan">Antrian Hewan</a>
                            <a class="dropdown-item" href="/hewanSelesai">Hewan Selesai</a>
                            <a class="dropdown-item" href="/pemesanan">Data Pengadaan Produk</a>
                            <a class="dropdown-item" href="/sudahKonfirmasi">Pengadaan Produk Terkonfirmasi</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">LAPORAN</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/produkTerlaris">Produk Terlaris</a>
                            <a class="dropdown-item" href="/layananTerlaris">Jasa Layanan Terlaris</a>
                            <a class="dropdown-item" href="/pendapatanBulanan">Pendapatan Bulanan</a>
                            <a class="dropdown-item" href="/pendapatanTahunan">Pendapatan Tahunan</a>
                            <a class="dropdown-item" href="/pengadaanBulanan">Pengadaan Produk Bulanan</a>
                            <a class="dropdown-item" href="/pengadaanTahunan">Pengadaan Produk Tahunan</a>
                        </div>
                    </li>
                    @endif

                    <!-- NAVBAR CS -->
                    @if (session('login_cs'))
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/member">MEMBER</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/hewan">HEWAN</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">KELOLA PENJUALAN PRODUK & LAYANAN</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/penjualanProduk">PENJUALAN PRODUK</a>
                            <a class="dropdown-item" href="/transaksiLayanan">JASA LAYANAN</a>
                            <a class="dropdown-item" href="/antrianHewan">ANTRIAN HEWAN</a>
                            <a class="dropdown-item" href="/hewanSelesai">HEWAN SELESAI</a>
                        </div>
                    </li>
                    @endif

                    <!-- NAVBAR KASIR -->
                    @if (session('login_kasir'))
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/transaksi">TRANSAKSI PEMBAYARAN</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/transaksiLunas">TRANSAKSI LUNAS</a>
                    </li>
                    @endif


                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" active href="/logout">KELUAR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br>

    <!-- NOTIFIKASI LOGIN -->
    @if (session('success_login'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{ session('success_login') }}
    </div>
    @endif

    <!-- NOTIFIKASI PRODUK MINIMUM  -->
    @if (session('alert_minim'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{ session('alert_minim') }}
    </div>
    @endif

    <br>
    <!-- NOTIFIKASI STATUS -->
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{ session('status') }}
    </div>
    @endif


    @yield('container')


    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
    <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Contact form JS-->
    <script src="assets/mail/jqBootstrapValidation.js"></script>
    <script src="assets/mail/contact_me.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


    <!-- Script Datatable -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript">
        $(function() {
            $("input[name='member']").click(function() {
                if ($("#memberYes").is(":checked")) {
                    $("#hewan").show();
                } else {
                    $("#hewan").hide();
                }
            });
        });

        $(document).ready(function() {
            $('#table-datatables').DataTable({});
        });
    </script>

</body>

</html>