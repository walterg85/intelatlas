<?php
    // Url raiz, para todas las coneciones al controlador, este se debe cambiar cuando se publica el proecto con una DNS
    $base_url = 'http://localhost/intelatlas';
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="<?php echo $base_url; ?>/assets/img/favicon.png" rel="icon">
    <link href="<?php echo $base_url; ?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link href="<?php echo $base_url; ?>/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo $base_url; ?>/assets/css/style.min.css?v=1.6" rel="stylesheet">

    <!-- Stylo del chat -->   

    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/chat.min.css?v=1.3">

    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" async></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>Online Store</title>
</head>
<style type="text/css">
    .dropdown-menu{
        width: 100% !important;
    }
    .fixBaground{
        background-image: linear-gradient(to top left, #7E2395, #9A348E);
        height: 160px;
    }
</style>
<body>
    <div id="fixBaground" class="fixBaground">
        <!-- ======= Top Bar ======= -->
        <div id="topbar" class="fixed-top d-flex align-items-center ">
            <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <a class="text-decoration-none changeLang" href="javascript:void(0);"><i class="bi bi-envelope-fill"></i> Español</a>
                    <a class="text-decoration-none" href="tel:520-955-8534"><i class="bi bi-telephone-plus-fill"></i> +1 (520) 955-8534</a>
                </div>
                <div class="cta d-none d-md-block">
                    <a href="javascript:void(0);" class="scrollto linkChat text-light link5">Let's Talk!</a>
                </div>
            </div>
        </div>
        <!-- End Top Bar -->

        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top d-flex align-items-center ">
            <div class="container d-flex align-items-center justify-content-between">
                <a class="logo" href="/">I<span class="logo-blue">A</span></a>

                <text><i class="bi bi-cart3 text-light btnCheckout"></i> <span class="badge qtyCart btnCheckout">0</span></text>
                <div class="search-box">
                    <button class="btn-search"><i class="ri-search-line"></i></button>
                    <div class="dropdown">
                        <input type="text" class="input-search dropdown-toggle" id="inputSearch" placeholder="Type to Search..." autocomplete="off" >
                        <ul class="dropdown-menu" aria-labelledby="inputSearch"></ul>
                    </div>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto active link1" href="#web-price">Websites</a></li>
                        <li><a class="nav-link scrollto link2" href="#pricing">Online Store</a></li>          
                        <li><a class="nav-link scrollto link3" href="#cta">Custom Packages</a></li>
                        <li><a class="nav-link scrollto link4" href="<?php echo $base_url; ?>/account.php">My account</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->
            </div>
        </header>
        <!-- End Header -->
    </div>


    <!-- ======= Main Section ======= -->
    <main id="main">
        <?php echo $content; ?>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="subTittle">Our Newsletter</h4>
                        <p class="subSubTittle">Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    </div>
                    <div class="col-lg-6">
                        <form>
                            <input type="email" id="txtEmail"><input type="submit" id="btnSuscribe" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; <script>document.write(new Date().getFullYear())</script> <strong><span>INTELATLAS</span></strong>.
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- ==== Formulario para el chat ==== -->
    <input type="checkbox" id="check"><label class="chat-btn" for="check"><i class="fa fa-commenting-o comment"></i><i class="fa fa-close close"></i></label>
    <div class="wrapper bg-light">
        <div class="header pt-2">
            <a href="javascript:void(0);"class="lblControl d-none">
                <span><i class="fa fa-power-off"></i> <text class="labelFinish">Finish chatting</text></span>
            </a>
            <h6 class="labelChatTitle text-center mt-2">Let's Chat - Online</h6>
        </div>
        <div class="text-center p-2">
            <div id="chatLog" class="d-none"></div>
        </div>
        <div class="chat-form">
            <div id="divRegistro">
                <input type="text" class="form-control" placeholder="Name" id="inputNameChat">
                <input type="text" class="form-control" placeholder="Email" id="inputMail">
                <input type="text" class="form-control" placeholder="Phone" id="inputPhone">
                <textarea class="form-control" placeholder="Your Text Message" id="inputInitialMessage"></textarea>
                <div class="d-grid gap-2">
                    <button class="btn text-light" id="btnStart">Submit</button>
                </div>
            </div>
            <div id="divConversasion" class="d-none">
                <textarea class="form-control" rows="1" placeholder="Your Message" id="inputNewMessage"></textarea>
                <button class="btn pull-right" data-round="1" id="btnSendmessage">Send</button>
            </div>
        </div>
    </div>
    <!-- End formulario para el chat -->

    <!-- Vendor JS Files -->
    <script src="<?php echo $base_url; ?>/assets/vendor/aos/aos.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/php-email-form/validate.min.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo $base_url; ?>/assets/js/main.min.js"></script>

    <!-- Masterpage JS File -->
    <script type="text/javascript">
        var base_url = "<?php echo $base_url; ?>"
    </script>
    <script src="<?php echo $base_url; ?>/assets/js/masterpage.min.js"></script>
</body>
</html>