<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kouvee Pet Shop</title>

    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Fonts CSS-->
    <link rel="stylesheet" href="css/heading.css">
    <link rel="stylesheet" href="css/body.css">

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
            width: 323px;
            border-radius: 10px;
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
            <button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu <i class="fas fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#produk">PRODUK</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">TENTANG KAMI</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">KONTAK</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead text-white text-center" style="background-color: #b49c73">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img src="images/logo.png" style="width:250px">
            <!-- Masthead Heading-->
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="pre-wrap masthead-subheading font-weight-light mb-0">
            <h4 class="masthead-heading mb-0">SELAMAT DATANG DI</h4>
            <h4 class="masthead-heading mb-0">KOUVEE PET SHOP</h4>
            </p>
        </div>
    </header>

    <!-- FORM LOGIN -->
    @if (session('status'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{ session('status') }}
    </div>
    @endif
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-4 d-none d-lg-block bg-login-image" hidden></div>
                <div class="col-lg-4">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">FORM MASUK</h1>
                        </div>
                        <form method="POST" action="/login">
                            @csrf
                            <div class="form-group">
                                <label for="id_pegawai" style="color: black; font-size:16px;">ID Pegawai</label>
                                <input type="text" class="form-control form-control-user" name="id_pegawai" id="id_pegawai" placeholder="Masukan ID Pegawai">
                            </div>
                            <div class="form-group">
                                <label for="password" style="color: black; font-size:16px;">Password</label>
                                <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Masukan Kata Sandi">
                            </div>
                            <button id="buttonmasuk" class="btn" type="submit" name="login">
                                MASUK
                            </button>
                            <hr>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUK DAN LAYANAN -->
    <section class="page-section portfolio" id="produk">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <div class="text-center">
                <h2 class="page-section-heading text-secondary mb-0 d-inline-block">PRODUK</h2>
            </div>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Items-->
                @foreach( $produk as $produk )
                <div class="col-md-6 col-lg-4 mb-5">
                <h4 class="portfolio-modal-title text-secondary mb-0" style="text-align: center">{{$produk->nama_produk}}</h4>
                    <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#detail">
                        
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-star fa-3x"></i></div>
                        </div><img class="img-fluid" src="/gambar/{{$produk->gambar}}" alt="Picture" />
                        <h6 class="portfolio-modal-title text-secondary mb-0">Jumlah Stok : {{$produk->jumlah_stok_produk}}</h6>
                        <h6 class="portfolio-modal-title text-secondary mb-0">Harga Produk : Rp {{$produk->harga_produk}}</h6>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- TENTANG KAMI -->
    <section class="page-section text-white mb-0" id="about">
        <div class="container">
            <!-- About Section Heading-->
            <div class="text-center">
                <h2 class="page-section-heading d-inline-block text-white">TENTANG KAMI</h2>
            </div>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- About Section Content-->
            <div class="row">
                <p class="pre-wrap lead">Kouvee Pet Shop merupakan sebuah toko hewan yang sudah berdiri sejak tahun 2018 menyediakan produk dan jasa layanan yang berada di Kota Yogyakarta. Kouvee Pet Shop menyediakan berbagai macam produk untuk hewan kesayangan anda seperti makanan, aksesoris, perlengkapan dan lain-lain sesuai kebutuhan hewan kesayangan anda. Selain menjual berbagai macam produk, Kouvee Pet Shop juga menyediakan jasa layanan seperti grooming dan penitipan hewan. Kouvee Pet Shop bekerja sama dengan beberapa supplier dalam penyediaan produk yang dijual. Kouvee Pet Shop memiliki lebih dari 15 pegawai dan juga memiliki lebih dari 50 konsumen tetap.</p>
            </div>
        </div>
    </section>
    <section class="page-section" id="contact">
        <div class="container">
            <!-- Contact Section Heading-->
            <div class="text-center">
                <h2 class="page-section-heading text-secondary d-inline-block mb-0">KONTAK</h2>
            </div>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Contact Section Content-->
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="icon-contact mb-3"><i class="fas fa-mobile-alt"></i></div>
                        <div class="text-muted">Phone</div>
                        <div class="lead font-weight-bold">(0274) 357-735</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="icon-contact mb-3"><i class="far fa-envelope"></i></div>
                        <div class="text-muted">Email</div><a class="lead font-weight-bold" href="mailto:KouveePetShop@gmail.com">KouveePetShop@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer text-center" style="background-color: #565d47">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="mb-4">LOKASI</h4>
                    <p class="pre-wrap lead mb-0">Jln. Moses Gatotkaca No. 22, Yogyakarta 55281, D.I.Yogyakarta</p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="mb-4">MEDIA SOSIAL</h4><a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/StartBootstrap"><i class="fab fa-fw fa-facebook-f"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.twitter.com/sbootstrap"><i class="fab fa-fw fa-twitter"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/startbootstrap"><i class="fab fa-fw fa-linkedin-in"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.dribble.com/startbootstrap"><i class="fab fa-fw fa-dribbble"></i></a>
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="mb-4">TENTANG KAMI</h4>
                    <p class="pre-wrap lead mb-0">Kouvee Pet Shop merupakan sebuah toko hewan yang sudah berdiri sejak tahun 2018 menyediakan produk dan jasa layanan yang berada di Kota Yogyakarta. Kouvee Pet Shop menyediakan berbagai macam produk untuk hewan kesayangan anda seperti makanan, aksesoris, perlengkapan dan lain-lain sesuai kebutuhan hewan kesayangan anda. Selain menjual berbagai macam produk, Kouvee Pet Shop juga menyediakan jasa layanan seperti grooming dan penitipan hewan. Kouvee Pet Shop bekerja sama dengan beberapa supplier dalam penyediaan produk yang dijual. Kouvee Pet Shop memiliki lebih dari 15 pegawai dan juga memiliki lebih dari 50 konsumen tetap.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Copyright Section-->
    <section class="copyright py-4 text-center text-white" style="background-color: #231903">
        <div class="container"><small class="pre-wrap">Copyright © Kouvee Pet Shop 2020</small></div>
    </section>
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
</body>

</html>