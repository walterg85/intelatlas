var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2
            }),
            searchRequest = null,
            productLimite = 0,
            refreshLog          = null,
            lang                = (window.navigator.language).substring(0,2),
            intervalContador    = null, // Contador para establecer los 20 segundos para lanzar el chat
            contador            = 0,
            estadoChat          = false,
            emitirSonido        = true,
            mensageRecibido     = "",
            messageInicial      = "";

        $(document).ready(function(){
            $(".nav-link").click( function(){
                let seccion = $(this).attr("href");
                window.location.replace(`${base_url}/${seccion}`);
            });
            // Control de chat
            $("#btnStart").on("click", function(){
                // Validar que se hayan ingresado todos los datos adecuadamente
                if(($("#inputMail").val()).length == 0 || ($("#inputNameChat").val()).length == 0 || ($("#inputInitialMessage").val()).length == 0 || ($("#inputPhone").val()).length == 0)
                    return false;

                // Se registra como prospecto y se guarda el archivo de chat
                $("#chatLog")
                .html(`<h5>${mensageRecibido}</h5>`)
                .addClass('text-center');
                
                registrarProspecto();              
            });

            $("#btnSendmessage").click( fnSendMsg);

            $(".lblControl").on("click", function(){
                (async () => {
                    const tmpResult = await showConfirmation('Do you really want to end the chat with tech support?', "", "Yes");
                    if(tmpResult.isConfirmed){
                        // Detener la busqueda de log
                        clearInterval(refreshLog);

                        let dt = new Date(),
                            time = dt.getHours() + ":" + dt.getMinutes(),
                            cliData = JSON.parse( localStorage.getItem("cliData") ),
                            geo = JSON.parse( cliData.ip);

                        let objData = {
                            chatId: cliData.chatId,
                            ip: geo.ip,
                            _method: "closeChat",
                            _time: time
                        };

                        $.post(`${base_url}/core/controllers/chat.php`, objData, function(){
                            // Borrar todos los datos
                            $("#chatLog").html("");
                            localStorage.removeItem("cliData");

                            intervalContador = null;
                            contador = 0;

                            getConfig(false);
                            $(".chat-btn").click();
                        });
                    }
                })()
            });

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
                                        ${(lang == 'en') ? prod.name : prod.optional_name}
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

            // Verificar si ya se lanzo el chat parar el contador e iniciar el chat
            $('#check').change(function() {
                if(this.checked && intervalContador && contador < 20) {
                    clearInterval(intervalContador);
                    // Para registrar el chat y saludar al usuario.
                    fnSaludoInicial();
                }      
            });
        });

        function countCartItem(){
            let currentCart = JSON.parse(localStorage.getItem("currentCart"));
            if(currentCart)
                $(".qtyCart").html(Object.keys(currentCart).length);
        }

        function switchLanguage(lang){
            $.post(`${base_url}/assets/lang.json`, {}, function(data) {
                $(".changeLang").html(`<i class="bi bi-globe2"></i> ${data[lang]["buttonText"]}`);

                let myLang = data[lang]["home"];
                $("#inputSearch").attr("placeholder", myLang.search);
                $(".link1").attr("placeholder", myLang.link1);
                $(".link2").attr("placeholder", myLang.link2);
                $(".link3").attr("placeholder", myLang.link3);
                $(".link1").html(myLang.link1);
                $(".link2").html(myLang.link2);
                $(".link3").html(myLang.link3);
                $(".link4").html(myLang.link4);
                $(".link5").html(myLang.link5);
                $(".bannerTittle").html(myLang.bannerTittle);
                $(".bannerSubTittle").html(myLang.bannerSubTittle);
                $(".ctaCall").html(myLang.ctaCall);
                $(".ctaMessage").html(myLang.ctaMessage);
                $(".ctaStoreTittle").html(myLang.ctaStoreTittle);
                $(".ctaStoreSubTittle").html(myLang.ctaStoreSubTittle);
                $(".subTittle").html(myLang.subTittle);
                $(".subSubTittle").html(myLang.subSubTittle);
                $("#btnSuscribe").val(myLang.btnSuscribe);
                $(".labelPurchase1").html(myLang.labelPurchase1);
                $(".labelPurchase2").html(myLang.labelPurchase2);

                // Page title
                document.title = myLang.pageTitle;

                myLang = data[lang]["chat"];

                $(".labelChatTitle").html(myLang.chatTitle);
                $("#inputNameChat").attr("placeholder", myLang.inputName);
                $("#inputMail").attr("placeholder", myLang.inputMail);
                $("#inputPhone").attr("placeholder", myLang.inputPhone);
                $("#inputInitialMessage").attr("placeholder", myLang.inputInitialMessage);
                $("#btnStart").html(myLang.btnStart);
                $("#inputNewMessage").attr("placeholder", myLang.inputNewMessage);
                $("#btnSendmessage").html(myLang.btnSendmessage);
                $(".labelFinish").html(myLang.labelFinish);
                messageInicial = myLang.messageInicial;

                mensageRecibido = myLang.msgReceived;
            });
        }
        
        function fnSuscribe(){
            let objData = {
                "_method":"suscribe",
                "email": $("#txtEmail").val()
            };

            $.post(`${base_url}/core/controllers/user.php`, objData, function(result) {
                $("#txtEmail").val("");
                showAlert("success", "you have successfully subscribed");
            });
        }

        function getConfig(initial = true){
            let objData = {
                _method: "getUnique",
                parametro: "chat"
            };

            $.post(`${base_url}/core/controllers/setting.php`, objData, function(result){
                // Se obtiene el resutado, si aun no se configura este valor, se toma como estado inactivo
                if(result.data)
                    estadoChat = (result.data.value == 1) ? true : false;

                if(estadoChat){
                    $("#divRegistro").addClass("d-none");
                    $("#divConversasion").removeClass("d-none");
                    $("#chatLog").removeClass("d-none");
                    $(".lblControl").removeClass("d-none");
                } else {
                    $("#divRegistro").removeClass("d-none");
                    $("#divConversasion").addClass("d-none");
                    $("#chatLog").addClass("d-none");
                    $(".lblControl").addClass("d-none");
                }
            }).done( function(){
                let cliData = JSON.parse( localStorage.getItem("cliData") );
                if(cliData){
                    $("#inputMail").val(cliData.mail);
                    $("#inputNameChat").val(cliData.name);

                    $("#divRegistro").addClass("d-none");
                    $("#divConversasion").removeClass("d-none");
                    $("#chatLog").removeClass("d-none");
                    $(".lblControl").removeClass("d-none");

                    loadLog();
                    refreshLog = setInterval(loadLog, 2500);
                }else{
                    // Si la configuracion del chat no esta activa, no se muetra el formulario automaticamente
                    if(estadoChat && initial){
                        intervalContador = setInterval( function(){
                            // Incrementar el contador en 1
                            contador += 1;

                            // Verificar si pasaron los 20 segundos, detener el contador y mostrar el formulario del chat
                            if(contador > 20){
                                // Para limpiar el contador
                                clearInterval(intervalContador);

                                // Validar si ya esta activo el chat ya no hacer nada.
                                if(!$("#check").is(':checked')){
                                    // Para lanzar el formulario de chat
                                    $(".chat-btn").click();

                                    // Para registrar el chat y saludar al usuario.
                                    fnSaludoInicial();
                                }
                            }

                        }, 1000);
                    }
                }
            });
        }

        function registrarProspecto(){
            $("#chatLog")
                .html(`<h5>${mensageRecibido}</h5>`)
                .addClass('text-center');

            let formData = new FormData();

            formData.append("_method", "POST");
            formData.append("leads", 1);
            formData.append("inputName", $("#inputNameChat").val());
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

            sendContact();
        }

        function pad (str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }

        function fnSaludoInicial(){
            // Obtener la informacion de geolocalizacion del usuario y despues usarla
            objData = {
                _method: "loadIpconfig"
            };

            $.post(`${base_url}/core/controllers/chat.php`, objData, function (ipinfo) {
                // Obtener la hora local del usuario
                let dt = new Date(),
                    time = dt.getHours() + ":" + dt.getMinutes(),
                    ip = JSON.stringify(ipinfo),
                    objData = {
                        message: messageInicial,
                        email: "No email",
                        name: "no name",
                        phone: "No phone",
                        ip: ip,
                        _method: "saludarIniciar",
                        _time: time
                    };

                // Enviar la peticion de inicio y saludo
                $.post(`${base_url}/core/controllers/chat.php`, objData, function (chatId) {
                    localStorage.setItem("cliData", JSON.stringify({name: "No name", mail: "No email", phone: "No phone", ip: ip, chatId: chatId}));

                    loadLog();
                    refreshLog = setInterval(loadLog, 2500);                    
                });
            });
        }

        function fnSendMsg(){
            // No enviar mensaje vacio
            if( $("#inputNewMessage").val() == "")
                return;

            // Obtener la infromacion del chat actual
            let cliData = JSON.parse( localStorage.getItem("cliData") ),
                usIp    = JSON.parse(cliData.ip);

            // Obtener la hora local del usuario
            let dt = new Date(),
                time = dt.getHours() + ":" + dt.getMinutes(),
                objData = {
                    message: $("#inputNewMessage").val(),
                    chatId: cliData.chatId,
                    chatIp: usIp.ip,
                    _method: "responseChat",
                    _time: time
                };

            // Enviar la peticion y actualizar el log
            $.post(`${base_url}/core/controllers/chat.php`, objData, function(){
                emitirSonido = false;
                $("#inputNewMessage").val("");
                loadLog();
            });
        }

        function loadLog(){
            let cliData = JSON.parse( localStorage.getItem("cliData") );

            let objData = {
                chatId: cliData.chatId,
                _method: "loadLog"
            },
            oldscrollHeight = $("#chatLog")[0].scrollHeight - 20;

            $.post(`${base_url}/core/controllers/chat.php`, objData, function(result) {
                if(result){
                    $("#chatLog").html(result.message);

                    let newscrollHeight = $("#chatLog")[0].scrollHeight - 20;
                    if(newscrollHeight > oldscrollHeight){
                        $("#chatLog").animate({ scrollTop: newscrollHeight }, 'normal');

                        if(emitirSonido){
                            let audio = new Audio(`${base_url}/assets/sound/bell.wav`);
                            audio.play();
                        }

                        emitirSonido = true;                        
                    }
                }else{
                    $("#chatLog").html("");
                    clearInterval(refreshLog);
                    localStorage.removeItem("cliData");

                    intervalContador = true;
                    contador = 0;

                    $(".chat-btn").click();
                    showAlert("info", "Tech support decided to end the chat.");
                }
            }).fail(function() {
                $("#chatLog").html("");
            });
        }

        function sendContact(){
            // Obtener la informacion de geolocalizacion del usuario y despues usarla
            objData = {
                _method: "loadIpconfig"
            };
            
            $.post(`${base_url}/core/controllers/chat.php`, objData, function (ipinfo) {
                // Obtener la hora local del usuario
                let dt = new Date(),
                    time = dt.getHours() + ":" + dt.getMinutes(),
                    ip = JSON.stringify(ipinfo),
                    objData = {
                        message: $("#inputInitialMessage").val(),
                        email: $("#inputMail").val(),
                        name: $("#inputNameChat").val(),
                        phone: $("#inputPhone").val(),
                        ip: ip,
                        chatIp: ipinfo.ip,
                        _method: "dejarMensaje",
                        _time: time
                    };

                // Enviar la peticion de inicio y saludo
                $.post(`${base_url}/core/controllers/chat.php`, objData, function (chatId) {
                    $("#divRegistro").addClass("d-none");
                    $("#chatLog").removeClass("d-none");
                });
            });
        }

        // Metodo para mostrar una alerta de notificaicon
        // icon: success || error
        // text: texto que se mostrara en pantalla
        function showAlert(icon, text){
            Swal.fire({
                position: 'top-end',
                icon: icon,
                text: text,
                showConfirmButton: false,
                timer: 3000
            });
        }

        // Metodo para mostrar una alerta de confirmacion
        // title: Cuestion proincipal
        // text: Texto explicativo
        // confirmButtonText: texto que se colocara en el boton de confirmacion
        /*
        [USAGE]
        (async () => {
            const alert = await showConfirmation("¿Deseas eliminar?", "Esto no se podra revertir!", "Si eliminar");
            console.log(alert);
        })()

        [RESULT]
        {
            "isConfirmed": false,
            "isDenied": false,
            "isDismissed": true,
            "dismiss": "cancel"
        }
        */
        function showConfirmation(title, text, confirmButtonText){
            return Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                allowOutsideClick: false
            });
        }

        window.addEventListener('online',  updateIndicator);
        window.addEventListener('offline', updateIndicator);

        function updateIndicator() {
            let isOnline = window.navigator.onLine;

            if(isOnline){
                showAlert("success", "The network connection has been restored");
                loadLog();
                refreshLog = setInterval(loadLog, 2500);
            } else {
                showAlert("error", "The network connection has been lost");
                clearInterval(refreshLog);
                $("#chatLog").html("");
            }
        }