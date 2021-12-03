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
    <link href="<?php echo $base_url; ?>/assets/css/style.css?v=1.1" rel="stylesheet">

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
    .fixBaground{
        background-image: linear-gradient(to left top, #f73a66, #fb4d5e, #fe5e57, #ff6e51, #ff7e4d);
        height: 160px;
    }
</style>
<body>
    <div id="fixBaground" class="fixBaground">
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
    <script src="<?php echo $base_url; ?>/assets/vendor/aos/aos.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo $base_url; ?>/assets/js/main.js"></script>

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

            // Contador de items en el carrito
            countCartItem();
        });

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

            $.post(`${base_url}/core/controllers/setting.php`, objData, function(result){
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

        function pad (str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }
    </script>
</body>
</html>