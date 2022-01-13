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

    <!-- Bootstrap, CSS, Icons & fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css?v=1.3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300&display=swap" rel="stylesheet">

    <title>Websites and more | INTELATLAS</title>

    <!-- Stylo del chat -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/chat.min.css?v=1.3">

    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" async></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
<body class="bg-light">
    <div class="nav-scroller container-fluid top-menu py-1">
        <div class="container">
            <nav class="nav d-flex justify-content-center">
                <a class="p-2 link-secondary text-decoration-none text-light changeLang" href="javascript:void(0);"><i class="bi bi-globe2 top-menu-color px-2"></i> Español</a>
                <a class="py-2 text-decoration-none text-light" href="<?php echo $base_url; ?>/account.php"><i class="top-menu-color bi bi-person-circle px-2"></i> <text class="link4">Account</text></a>
                <a class="p-2 link-secondary text-decoration-none text-light" href="#"><i class="bi bi-telephone-fill top-menu-color px-2"></i> +1(520) 955-8534</a>
            </nav>
        </div>
    </div>

    <div class="nav-scroller container-fluid top-menu-sec py-1">
        <div class="container">
            <nav class="nav d-flex justify-content-between">
                <a class="p-2 link-secondary text-decoration-none text-light link1" href="#">Websites</a>
                <a class="p-2 link-secondary text-decoration-none text-light link2" href="#">Online Store</a>
                <a class="p-2 link-secondary text-decoration-none text-light" href="#">Logos</a>
                <a class="p-2 link-secondary text-decoration-none text-light" href="#">Bootstrap Themes</a>
            </nav>
        </div>
    </div>

    <div class="container-fluid hero">  
        <header class="py-1">
            <div class="container">
                <nav class="container d-flex justify-content-between">
                    <a class="logo fs-2" href="/">I<span class="logo-blue">A</span></a>
                    <div class="search-box">
                        <button class="btn-search"><i class="bi bi-search top-menu-color"></i></button>
                        <div class="dropdown">
                            <input type="text" class="input-search dropdown-toggle" id="inputSearch" placeholder="Type to Search..." autocomplete="off" >
                            <ul class="dropdown-menu" aria-labelledby="inputSearch"></ul>
                        </div>
                    </div>
                    <a class="py-2 text-decoration-none top-menu-color fs-5 btnCheckout" href="#">
                        <i class="bi bi-bag"></i> 
                        <span class="translate-middle badge rounded-pill bg-danger qtyCart btnCheckout">0</span>
                    </a>            
                </nav>
            </div>
        </header>

        <!-- Impresion del carusel si esta definidio, solo para la pagina principal -->
        <?php echo (isset($carousel)) ? $carousel : ''; ?>
    </div>

    <!-- ======= Main Section ======= -->
    <main id="main">
        <?php echo $content; ?>
    </main>
    <!-- End #main -->

    <!-- ========== FOOTER ========== -->
    <div class="container-fluid bg-light">
        <div class="container">
            <footer class="py-5">
                <div class="row">
                    <div class="col-6 col-lg-3 mt-sm-0">
                        <h5>Services</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Online store</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Websites</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Logos</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Bootstrap Themes</a></li>
                        </ul>
                    </div>
                    <div class="col-4 col-lg-3 mt-5 mt-lg-0">
                        <h5>More</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About Us</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">CLUBTRES</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-3">
                        <h5>Contact</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">+1(520) 955-8534</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">1690 N Stone Ave</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Tucson, Arizona 85705</a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-sm-8 col-lg-3 mt-5 mt-lg-0 text-center text-lg-start">
                        <form>
                            <h5 class="subTittle">Subscribe to our newsletter</h5>
                            <p class="subSubTittle">Monthly digest of whats new and exciting from us.</p>
                            <div class="gap-2">
                                <label for="newsletter1" class="visually-hidden">Email address</label>
                                <input type="email" id="txtEmail" class="form-control" placeholder="Email address">
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-info" type="submit" id="btnSuscribe">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-between py-4 my-4 border-top">
                    <p><script>document.write(new Date().getFullYear())</script> &copy;  INTELATLAS</p>
                    <ul class="list-unstyled d-flex">
                        <li class="ms-3"><a class="link-dark" href="#"><i class="bi bi-facebook"></i></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><i class="bi bi-twitter"></i></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><i class="bi bi-instagram"></i></a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <!-- ========== END FOOTER ========== -->

    <!-- ==== Formulario para el chat ==== -->
    <input type="checkbox" id="check"><label class="chat-btn" for="check"><i class="bi bi-chat-dots comment"></i><i class="bi bi-x-lg close"></i></label>
    <div class="wrapper bg-light">
        <div class="header pt-2">
            <a href="javascript:void(0);"class="lblControl d-none">
                <span><i class="bi bi-x-circle-fill"></i> <text class="labelFinish">Finish chatting</text></span>
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

    <!-- Masterpage JS File -->
    <script type="text/javascript">
        var base_url = "<?php echo $base_url; ?>"
    </script>
    
    <script src="<?php echo $base_url; ?>/assets/js/masterpage.js"></script>
</body>
</html>