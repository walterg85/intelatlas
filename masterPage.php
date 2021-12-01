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
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Stylo del chat -->   
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/chat.css?v=1.1">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>Online Store</title>
</head>
<style type="text/css">
    .dropdown-menu{
        width: 100% !important;
    }
</style>
<body>
    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="fixed-top d-flex align-items-center ">
        <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <a class="text-decoration-none changeLang" href="javascript:void(0);"><i class="ri-earth-line"></i> Español</a>
                <a class="text-decoration-none" href="tel:520-955-8534"><i class="bi bi-phone-fill phone-icon"></i> +1 (520) 955-8534</a>
            </div>
            <div class="cta d-none d-md-block">
                <a href="javascript:void(0);" class="scrollto linkChat">Let's Talk!</a>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center ">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.html">IA</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href=index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <text><i class="ri-shopping-cart-line text-light btnCheckout"></i> <span class="badge bg-warning rounded-pill qtyCart btnCheckout">0</span></text>
            <div class="search-box">
                <button class="btn-search"><i class="ri-search-line"></i></button>
                <div class="dropdown">
                    <input type="text" class="input-search dropdown-toggle" id="inputSearch" placeholder="Type to Search..." autocomplete="off" >
                    <ul class="dropdown-menu" aria-labelledby="inputSearch"></ul>
                </div>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#web-price">Websites</a></li>
                    <li><a class="nav-link scrollto" href="#pricing">Online Store</a></li>          
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header>
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex justify-cntent-center align-items-center">
        <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Websites and more</h2>
                    <p class="animate__animated animate__fadeInUp">Basic webstite only $189</p>
                    <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Order now</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Online store</h2>
                    <p class="animate__animated animate__fadeInUp">Selling online can be easy, get an online store from $699</p>
                    <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Order Now</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Logos</h2>
                    <p class="animate__animated animate__fadeInUp">Get 3 designs and unlimited reviews for only $97</p>
                    <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Order Now</a>
                </div>
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bx bx-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bx bx-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </section>
    <!-- End Hero -->

    <!-- ======= Main Section ======= -->
    <main id="main">
        <!-- ======= Website Pricing Section ======= -->
        <section id="web-price" class="pricing web-price">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="box">
                            <h3>Free Website Draft</h3>
                            <h4><sup>$</sup>0<span> / month</span></h4>
                            <ul>
                                <li>Custom Web Design</li>
                                <li>Frontpage</li>
                                <li>Contact form</li>
                                <li>Images</li>
                                <li>Multi language ready</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="javascript:void(0);" class="btn-buy btnAddtocartStc" data-item="{'id':'1', 'name': 'Shorts', 'optional_name': 'Pantaloncillos', 'descriptions':'Pants', 'optional_description': 'Pantalones cortos', 'thumbnail': '', 'sale_price': '', 'price': '57'}">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="box featured">
                            <span class="advanced">Popular</span>
                            <h3>Website Basic</h3>
                            <h4><sup>$</sup>190<span> / month</span></h4>
                            <ul>
                                <li>Custom Web Design</li>
                                <li>3 pages</li>
                                <li>Contact form</li>
                                <li>Images</li>
                                <li>Multi language ready</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="box">
                            <h3>Website Professional</h3>
                            <h4><sup>$</sup>229<span> / month</span></h4>
                            <ul>
                                <li>Custom Web Design</li>
                                <li>5 pages</li>
                                <li>Contact form</li>
                                <li>Images</li>
                                <li>Multi language ready</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                        <div class="box">              
                            <h3>Website Advance</h3>
                            <h4><sup>$</sup>299<span> / month</span></h4>
                            <ul>
                                <li>Custom Web Design</li>
                                <li>10 pages</li>
                                <li>Contact form</li>
                                <li>Images</li>
                                <li>Multi language ready</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Pricing Section -->

        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
            <div class="container">
                <div class="row" data-aos="zoom-in">
                    <div class="col-lg-9 text-center text-lg-start">
                        <h3>Custom Website</h3>
                        <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#">Call</a>
                        <a class="cta-btn align-middle linkChat" href="javascript:void(0);">Chat</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Cta Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>ONLINE STORE</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="box">
                            <h3>Free Store Draft</h3>
                            <h4><sup>$</sup>0<span> / month</span></h4>
                            <ul>
                                <li>Front page</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li class="na">Pharetra massa</li>
                                <li class="na">Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="box featured">
                            <h3>Store Basic</h3>
                            <h4><sup>$</sup>19<span> / month</span></h4>
                            <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li class="na">Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="box">
                            <span class="advanced">Advanced</span>
                            <h3>Store Professional</h3>
                            <h4><sup>$</sup>29<span> / month</span></h4>
                            <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li>Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                        <div class="box">              
                            <h3>Store Advance</h3>
                            <h4><sup>$</sup>49<span> / month</span></h4>
                            <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li>Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Pricing Section -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    </div>
                    <div class="col-lg-6">
                        <form>
                            <input type="email" id="txtEmail"><input type="submit" id="btnSuscribe" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p>
                            1690 N Stone <br>
                            Tucson, AZ 85705<br>
                            United States <br><br>
                            <strong>Phone:</strong> +1 (520) 955-8535<br>
                            <strong>Email:</strong> info@intelatlas.com.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-info">
                        <h3>About INTELATLAS</h3>
                        <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>INTELATLAS</span></strong>.
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <div id="preloader"></div>

    <!-- ==== Formulario para el chat ==== -->
    <input type="checkbox" id="check"><label class="chat-btn" for="check"><i class="fa fa-commenting-o comment"></i><i class="fa fa-close close"></i></label>
    <div class="wrapper">
        <div class="header">
            <h6 class="labelChatTitle">Let's Chat - Online</h6>
        </div>
        <a href="javascript:void(0);"class="list-group-item lblControl d-none">
            <span><i class="fa fa-power-off"></i> <text class="labelFinish">Finish chatting</text></span>
        </a>
        <div class="text-center p-2">
            <span class="lblWelcome">Please fill out the form to start chat!</span>
            <div id="chatLog" class="d-none"></div>
        </div>
        <div class="chat-form">
            <div id="divRegistro">
                <input type="text" class="form-control" placeholder="Name" id="inputName">
                <input type="text" class="form-control" placeholder="Email" id="inputMail">
                <input type="text" class="form-control" placeholder="Phone" id="inputPhone">
                <textarea class="form-control" placeholder="Your Text Message" id="inputInitialMessage"></textarea>
                <button class="btn btn-success btn-block pull-right" id="btnStart">Submit</button>
            </div>
            <div id="divConversasion" class="d-none">
                <textarea class="form-control" placeholder="Your Message" id="inputNewMessage"></textarea>
                <button class="btn btn-success btn-block pull-right" data-round="1" id="btnSendmessage">Send</button>
            </div>
        </div>
    </div>
    <!-- End formulario para el chat -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script type="text/javascript">
        var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2
            }),
            searchRequest = null,
            productLimite = 0,
            base_url = "<?php echo $base_url; ?>",
            refreshLog          = null,
            lang                = (window.navigator.language).substring(0,2),
            intervalContador    = null, // Contador para establecer los 20 segundos para lanzar el chat
            contador            = 0,
            estadoChat          = false;

        $(document).ready(function(){
            // Control de chat
            $("#btnStart").on("click", function(){
                // Validar que se hayan ingresado todos los datos adecuadamente
                if(($("#inputMail").val()).length == 0 || ($("#inputName").val()).length == 0 || ($("#inputInitialMessage").val()).length == 0 || ($("#inputPhone").val()).length == 0)
                    return false;

                // Se registra como prospecto y se guarda el archivo de chat
                sendMessage($("#inputInitialMessage").val(), 0);
                registrarProspecto();              
            });

            $("#btnSendmessage").on("click", function(){
                let myRound = $(this).data("round");
                sendMessage($("#inputNewMessage").val(), myRound);
            });

            $(".lblControl").on("click", function(){
                if (confirm('Do you really want to end the chat with tech support?')){
                    $("#chatLog").html("");
                    clearInterval(refreshLog);
                    localStorage.removeItem("cliData");
                    $("#btnSendmessage").data("round", 1);

                    let dt = new Date(),
                        time = dt.getHours() + ":" + dt.getMinutes();

                    let objData = {
                        email: $("#inputMail").val(),
                        name: $("#inputName").val(),
                        phone: $("#inputPhone").val(),
                        _method: "POST",
                        _action: "closeChat",
                        _time: time
                    };

                    $.post(`${base_url}/core/controllers/chat.php`, objData);
                }
            });

            let cliData = JSON.parse( localStorage.getItem("cliData") );
            if(cliData){
                $("#inputMail").val(cliData.mail);
                $("#inputName").val(cliData.name);

                $(".lblWelcome").addClass("d-none");
                $("#divRegistro").addClass("d-none");
                $("#divConversasion").removeClass("d-none");
                $("#chatLog").removeClass("d-none");
                $(".lblControl").removeClass("d-none");

                $("#btnSendmessage").data("round", 2);

                loadLog();
                refreshLog = setInterval(loadLog, 2500);
            }else{
                // Si la configuracion del chat no esta activa, no se muetra el formulario automaticamente
                if(estadoChat){
                    intervalContador = setInterval( function(){
                        // Incrementar el contador en 1
                        contador += 1;

                        // Verificar si pasaron los 20 segundos, detener el contador y mostrar el formulario del chat
                        if(contador > 20){
                            clearInterval(intervalContador);
                            $(".chat-btn").click();
                        }

                    }, 1000);
                }
            }

            $(".linkChat").click( function(){
                $(".chat-btn").click();
            });
            // Fin control de chat

            // Control de idioma
            if( localStorage.getItem("currentLag") ){
                lang = localStorage.getItem("currentLag");
            }else{
                localStorage.setItem("currentLag", lang);
            }

            $(".changeLang").click( function(){
                if (localStorage.getItem("currentLag") == "es") {
                    localStorage.setItem("currentLag", "en");
                    lang = "en";
                }else{
                    localStorage.setItem("currentLag", "es");
                    lang = "es";
                }
                switchLanguage(lang);
            });

            switchLanguage(lang);
            // Fin control de idioma

            // Control para busqueda
            $('#inputSearch').keyup(function(){
                if(searchRequest)
                    searchRequest.abort();

                searchRequest = $.ajax({
                    url:`${base_url}/core/controllers/product.php`,
                    method:"POST",
                    data:{
                        _method:'search',
                        strQuery: $('#inputSearch').val()
                    },
                    success:function(data){
                        let items = '';
                        $.each(data.data, function(index, prod){
                            let img = (prod.thumbnail != "" &&  prod.thumbnail != "0") ? `${base_url}/${prod.thumbnail}` : `${base_url}/assets/img/default.jpg`;

                            items += `
                                <li>
                                    <a class="dropdown-item" href="${base_url}/product/index.php?pid=${prod.id}">
                                        <img src="${img}" alt="twbs" height="32" class="rounded flex-shrink-0 me-2">
                                        ${prod.name}
                                    </a>
                                </li>
                            `;
                        });

                        $(".dropdown-menu")
                            .html(items)
                            .addClass("show");
                    }
                });
            });

            $('body').click(function() {
                if(searchRequest)
                    searchRequest.abort();

                $(".dropdown-menu")
                    .html("")
                    .removeClass("show");
            });
            // Fin control para busqueda

            // Control para el elemento statico
            $(".btnAddtocartStc").click(function(){
                let currentItem = JSON.parse( ($(this).data("item")).replace(/'/g, '"') ),
                    newItem = {},
                    currentCart = JSON.parse(localStorage.getItem("currentCart"));

                if(!currentCart){
                    localStorage.setItem("currentCart", "{}");
                    currentCart = {};
                }

                newItem.id = currentItem.id;
                newItem.name = currentItem.name;
                newItem.optional_name = currentItem.optional_name;
                newItem.descriptions = currentItem.descriptions;
                newItem.optional_description = currentItem.optional_description;
                newItem.thumbnail = currentItem.thumbnail;

                if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
                    newItem.price = currentItem.sale_price;
                }else{
                    newItem.price = currentItem.price;
                }

                if(currentCart[currentItem.id]){
                    currentCart[currentItem.id].qty = currentCart[currentItem.id].qty + 1;
                }else{
                    newItem.qty = 1;
                    currentCart[currentItem.id] = newItem;
                }

                localStorage.setItem("currentCart", JSON.stringify(currentCart));
                countCartItem();

                // Ejecutar para redirigir al checkout
                $(".btnCheckout").click();
            });
            // Fin control para el elemnto statico

            // Accion para la suscripcion
            $("#btnSuscribe").click( function(e){
                e.preventDefault();

                console.log(1);

                if( $("#txtEmail").val() != "" )
                    fnSuscribe();
            });
            // End Accion para la suscripcion

            // Para verificar la configuracion de disponibilidad del chat
            getConfig();

            $(".btnCheckout").click( function(){
                // A todas las referencias de directorios locales se le concatena la variable base_url, para indicar la ruta absoluta
                window.location.href = `${base_url}/checkout/index.php`
            });
        });

        function getProducts(limite) {
            productLimite = limite;

            let objData = {
                "_method":"GET",
                "limite": productLimite
            };

            $.post(`${base_url}/core/controllers/product.php`, objData, function(result) {
                $("#ListProduct").html("");
                $.each( result.data, function( index, item){
                    let productCard = $(".itemClone").clone();

                    if(lang == "en"){
                        productCard.find(".card-title").html(item.name);
                        productCard.find(".card-text").html(item.descriptions);
                    }else{
                        productCard.find(".card-title").html(item.optional_name);
                        productCard.find(".card-text").html(item.optional_description);
                    }                    

                    if( (item.sale_price).length > 0 && item.sale_price > 0){
                        productCard.find(".lblOldPrice").html( formatter.format(item.price)).removeClass("d-none");
                        productCard.find(".lblPrice").html(formatter.format(item.sale_price));
                        productCard.find(".brandPrice").removeClass("d-none");
                    }else{
                        productCard.find(".lblPrice").html( formatter.format(item.price) );
                    }

                    let img = (item.thumbnail != "" &&  item.thumbnail != "0") ? `${base_url}/${item.thumbnail}` : `${base_url}/assets/img/default.jpg`;

                    productCard.find(".card-img-top").attr("src", `${img}`);
                    productCard.find(".card-img-top").parent().attr("href", `${base_url}/product/index.php?pid=${item.id}`);

                    productCard.find(".btnAddtocart").data("item", item);

                    productCard.removeClass("d-none itemClone");
                    $(productCard).appendTo("#ListProduct");
                });

                $(".btnAddtocart").unbind().click(function(){
                    let currentItem = $(this).data("item"),
                        newItem = {},
                        currentCart = JSON.parse(localStorage.getItem("currentCart")),
                        config = JSON.parse(currentItem.dimensions);

                    if( config=="0" || ((config[0].sizes).length == 0 && config[1].colors[0] == "") ){
                        if(!currentCart){
                            localStorage.setItem("currentCart", "{}");
                            currentCart = {};
                        }                    

                        newItem.id = currentItem.id;
                        newItem.name = currentItem.name;
                        newItem.optional_name = currentItem.optional_name;
                        newItem.descriptions = currentItem.descriptions;
                        newItem.optional_description = currentItem.optional_description;
                        newItem.thumbnail = currentItem.thumbnail;

                        if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
                            newItem.price = currentItem.sale_price;
                        }else{
                            newItem.price = currentItem.price;
                        }

                        if(currentCart[currentItem.id]){
                            currentCart[currentItem.id].qty = currentCart[currentItem.id].qty + 1;
                        }else{
                            newItem.qty = 1;
                            currentCart[currentItem.id] = newItem;
                        }

                        localStorage.setItem("currentCart", JSON.stringify(currentCart));
                        countCartItem();

                        // Ejecutar para redirigir al checkout
                        $(".btnCheckout").click();
                    }else{
                        if(lang == "en"){
                            $(".lblMdlName").html(currentItem.name);
                            $(".lblDescription").html(currentItem.descriptions);
                        }else{
                            $(".lblMdlName").html(currentItem.optional_name);
                            $(".lblDescription").html(currentItem.optional_description);
                        }                        

                        if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
                            $(".lblMdlPrice").html( formatter.format(currentItem.sale_price) );
                        }else{
                            $(".lblMdlPrice").html( formatter.format(currentItem.price) );
                        }

                        $("#mdlAddtoCart").data("item", currentItem);

                        let images = JSON.parse(currentItem.images);
                        $.each( images, function( index, item){
                            $(`.img${index}`)
                                .attr("src", `${base_url}/${item}`)
                                .parent().removeClass("d-none");
                        });

                        $(".dvSizes").addClass("d-none");
                        if((config[0].sizes).length > 0){
                            $(".dvSizes").removeClass("d-none");
                            $(".toRemoves").remove();

                            $.each(config[0].sizes, function(index, item){
                                let dv = $(".chSizes").clone();

                                dv.find(".chk").val(item).attr("id", `ch${item}`);

                                if(item == "sm")
                                    dv.find(".lbl").html("Small");

                                if(item == "m")
                                    dv.find(".lbl").html("Medium");

                                if(item == "l")
                                    dv.find(".lbl").html("Large");

                                if(item == "xl")
                                    dv.find(".lbl").html("Extra large");

                                dv.find(".lbl").attr("for", `ch${item}`);
                                
                                if(index == 0)
                                    dv.find(".chk").prop("checked", true);

                                dv.removeClass("d-none chSizes");
                                dv.addClass("toRemoves");
                                $(dv).appendTo(".dvSizes");
                            });
                        }

                        $(".dvColors").addClass("d-none");
                        if(config[1].colors[0] != ""){
                            $(".dvColors").removeClass("d-none");
                            $(".toRemovec").remove();

                            let items = (config[1].colors[0]).split(",");
                            $.each(items, function(index, item){
                                let dv = $(".chColors").clone();

                                dv.find(".chk").val(item).attr("id", `rd${item}`);
                                dv.find(".lbl").html(item).attr("for", `rd${item}`);

                                if(index == 0)
                                    dv.find(".chk").prop("checked", true);

                                dv.removeClass("d-none chColors");
                                dv.addClass("toRemovec");
                                $(dv).appendTo(".dvColors");

                            });
                        }

                        $("#mdlProDetalle").modal("show");
                    }
                });

                countCartItem();
            });
        }

        function countCartItem(){
            let currentCart = JSON.parse(localStorage.getItem("currentCart"));
            if(currentCart)
                $(".qtyCart").html(Object.keys(currentCart).length);
        }

        function sendMessage(strMessage, round){
            let dt = new Date(),
                time = dt.getHours() + ":" + dt.getMinutes();

            let objData = {
                message: strMessage,
                email: $("#inputMail").val(),
                name: $("#inputName").val(),
                phone: $("#inputPhone").val(),
                round: round,
                _method: "POST",
                _time: time
            };

            $.post(`${base_url}/core/controllers/chat.php`, objData);

            if(round == 1){
                localStorage.setItem("cliData", JSON.stringify({name: $("#inputName").val(), mail: $("#inputMail").val(), phone: $("#inputPhone").val()}));
                $("#inputInitialMessage").val("");
                $("#btnSendmessage").data("round", 2);
                refreshLog = setInterval(loadLog, 2500);
            }

            $("#inputNewMessage").val("");

            if(round > 0)
                loadLog();

            return false;
        }

        function loadLog(){
            let objData = {
                email: $("#inputMail").val(),
                name: $("#inputName").val(),
                _method: "GET"
            },
            oldscrollHeight = $("#chatLog")[0].scrollHeight - 20;

            $.post(`${base_url}/core/controllers/chat.php`, objData, function(result) {
                $("#chatLog").html(result);

                let newscrollHeight = $("#chatLog")[0].scrollHeight - 20;
                if(newscrollHeight > oldscrollHeight)
                    $("#chatLog").animate({ scrollTop: newscrollHeight }, 'normal');

                let isClose = $("#inputClose").val();
                if(isClose){
                    clearInterval(refreshLog);
                    localStorage.removeItem("cliData");
                }
            }).fail(function() {
                $("#chatLog").html("");
                clearInterval(refreshLog);
                localStorage.removeItem("cliData");
                $("#btnSendmessage").data("round", 1);
            });
        }

        function switchLanguage(lang){
            $.post(`${base_url}/assets/lang.json`, {}, function(data) {
                $(".changeLang").html(`<i class="ri-earth-line"></i> ${data[lang]["buttonText"]}`);

                let myLang = data[lang]["home"];
                $("#inputSearch").attr("placeholder", myLang.search);

                // Page title
                document.title = myLang.pageTitle;

                myLang = data[lang]["chat"];

                $(".labelChatTitle").html(myLang.chatTitle);
                $(".lblWelcome").html(myLang.chatSubTitle);
                $("#inputName").attr("placeholder", myLang.inputName);
                $("#inputMail").attr("placeholder", myLang.inputMail);
                $("#inputInitialMessage").attr("placeholder", myLang.inputInitialMessage);
                $("#btnStart").html(myLang.btnStart);
                $("#inputNewMessage").attr("placeholder", myLang.inputNewMessage);
                $("#btnSendmessage").html(myLang.btnSendmessage);
                $(".labelFinish").html(myLang.labelFinish);
            });
        }
        
        function fnSuscribe(){
            let objData = {
                "_method":"suscribe",
                "email": $("#txtEmail").val()
            };

            $.post(`${base_url}/core/controllers/user.php`, objData, function(result) {
                $("#txtEmail").val("");
                alert("you have successfully subscribed");
            });
        }

        function getConfig(){
            let objData = {
                _method: "getUnique",
                parametro: "chat"
            };

            $.post("core/controllers/setting.php", objData, function(result){
                // Se obtiene el resutado, si aun no se configura este valor, se toma como estado inactivo
                if(result.data)
                    estadoChat = (result.data.value == 1) ? true : false;

                if(estadoChat){
                    $(".lblWelcome").addClass("d-none");
                    $("#divRegistro").addClass("d-none");
                    $("#divConversasion").removeClass("d-none");
                    $("#chatLog").removeClass("d-none");
                    $(".lblControl").removeClass("d-none");
                }
            });
        }

        function registrarProspecto(){
            let formData = new FormData();

            formData.append("_method", "POST");
            formData.append("leads", 1);
            formData.append("inputName", $("#inputName").val());
            formData.append("inputLastname", "");
            formData.append("inputAddress", "");
            formData.append("inputAddress2", "");
            formData.append("inputEmail", $("#inputMail").val());
            formData.append("inputPhone", $("#inputPhone").val());
            formData.append("inputCity", "");
            formData.append("inputState", "");
            formData.append("inputZip", "");
            formData.append("inputInfo", "");
            formData.append("clientId", 0);

            var request = new XMLHttpRequest();
            request.open("POST", "core/controllers/client.php");
            request.send(formData);

            $("#chatLog")
                .html(`<h5>We have already received your message, we will communicate soon</h5>`)
                .addClass('text-center');

            $(".lblWelcome").addClass("d-none");
            $("#divRegistro").addClass("d-none");
            $("#chatLog").removeClass("d-none");
        }
    </script>
</body>
</html>