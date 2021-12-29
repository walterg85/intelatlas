<?php
    @session_start();
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();

    $clientID   = (array_key_exists('restore', $_GET)) ? $_GET['restore'] : 0;
    $token      = (array_key_exists('token', $_GET)) ? $_GET['token'] : '';
?>
<script type="text/javascript">
    var clientId    = <?php echo $clientID ?>,
        token       = "<?php echo $token ?>";
</script>

<?php
    if (!isset($_SESSION['intelatlasClientLoged']) && $clientID == 0){
?>
        <section class="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-5 mb-3">
                        <div class="mb-3">
                            <label for="txtClientEmail" class="form-label labelMail">Email address</label>
                            <input type="email" class="form-control" id="txtClientEmail" placeholder="">
                        </div>
                        <div class="">
                            <label for="txtPassword" class="form-label linkPassword">Password</label>
                            <input type="password" id="txtPassword" class="form-control">
                        </div>
                        <a href="javascript:void(0);" class="text-decoration-none mx-2 labelCreateaccount" data-bs-toggle="modal" data-bs-target="#mdlCreateaccount">Create new account</a> |
                        <a href="javascript:void(0);" class="text-decoration-none ms-2 labelRecoveryPassw" data-bs-toggle="modal" data-bs-target="#mdlRestorepassword">Recover password</a>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btnLogin" class="btn btn-success mb-3">Confirm identity</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal para Registrar nueva cuenta -->
        <div class="modal fade" id="mdlCreateaccount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title labelCreateaccount" id="staticBackdropLabel">Create new account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addClientForm" class="needs-validation-client" novalidate>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputNameNewClient" class="form-label labelName">Name</label>
                                    <input type="text" id="inputNameNewClient" name="inputNameNewClient" class="form-control" autocomplete="off" maxlength="250" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="inputLastnameNewClient" class="form-label labelLastname">Last name</label>
                                    <input type="text" id="inputLastnameNewClient" name="inputLastnameNewClient" class="form-control" autocomplete="off" maxlength="50" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputEmailNewClient" class="form-label labelMail">Email</label>
                                    <input type="text" id="inputEmailNewClient" name="inputEmailNewClient" class="form-control" autocomplete="off" maxlength="20" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="inputPasswordNewClient" class="form-label labelPassword">Password</label>
                                    <input type="password" id="inputPasswordNewClient" name="inputPasswordNewClient" class="form-control" autocomplete="off" maxlength="20" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btnClose" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success" id="btnCreateAccount">Create account</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Restaurar contraseña -->
        <div class="modal fade" id="mdlRestorepassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title labelRecoveryPassw" id="staticBackdropLabel2">Restore password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation-restorepassword" novalidate>
                            <div class="mb-4">
                                <input type="text" class="form-control" id="inputRestoreMail" name="inputRestoreMail" aria-describedby="emailHelp" placeholder="Email to restore" required>
                            </div>
                            <button type="button" class="w-100 btn btn-success" id="btnRestore">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btnClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else if(isset($_SESSION['intelatlasClientLoged']) && $clientID == 0){
?>
        <section class="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="lead labelWelcome">Welcome</p>
                        <nav class="navbar">
                            <ul>
                                <li><a href="javascript:void(0);" id="linkData" class="active" style="color:#0a58ca !important;">Profile</a></li>
                                <li><a href="javascript:void(0);" id="linkList" class="" style="color:#0a58ca !important;">My digital purchases</a></li>
                                <li><a href="javascript:void(0);" id="linkPassword" class="" style="color:#0a58ca !important;">Password</a></li>
                                <li><a href="core/controllers/_logout.php" id="linkLogout" class="" style="color:#0a58ca !important;">Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-5 ms-5" id="tbData">
                        <form id="clientForm" class="needs-validation" novalidate>
                            <input type="hidden" name="clientId" id="clientId" value="<?php echo $_SESSION['intelatlasClientData']->id; ?>">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputName" class="form-label labelName">Name</label>
                                    <input type="text" id="inputName" name="inputName" class="form-control" autocomplete="off" maxlength="250" required value="<?php echo $_SESSION['intelatlasClientData']->nombre; ?>">
                                </div>
                                <div class="col mb-3">
                                    <label for="inputLastname" class="form-label labelLastname">Last name</label>
                                    <input type="text" id="inputLastname" name="inputLastname" class="form-control" autocomplete="off" maxlength="50" required value="<?php echo $_SESSION['intelatlasClientData']->apellido; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputEmail" class="form-label labelMail">Email</label>
                                    <input type="text" id="inputEmail" name="inputEmail" class="form-control" autocomplete="off" maxlength="20" required value="<?php echo $_SESSION['intelatlasClientData']->email; ?>">
                                </div>
                                <div class="col mb-3">
                                    <label for="inputPhone" class="form-label labelPhone">Phone</label>
                                    <input type="text" id="inputPhone" name="inputPhone" class="form-control" autocomplete="off" maxlength="20" required value="<?php echo $_SESSION['intelatlasClientData']->telefono; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="inputAddress" class="form-label labelAddress">Address</label>
                                <input type="text" id="inputAddress" name="inputAddress" class="form-control" autocomplete="off" maxlength="500" required value="<?php echo $_SESSION['intelatlasClientData']->direccion_a; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="inputAddress2" class="form-label labelAddress2">Address 2</label>
                                <input type="text" id="inputAddress2" name="inputAddress2" class="form-control" autocomplete="off" maxlength="500" value="<?php echo $_SESSION['intelatlasClientData']->direccion_b; ?>">
                            </div>
                            <div class="row">
                                <div class="col-5 mb-3">
                                    <label for="inputCity" class="form-label labelCity">City</label>
                                    <input type="text" id="inputCity" name="inputCity" class="form-control" autocomplete="off" maxlength="50" required value="<?php echo $_SESSION['intelatlasClientData']->ciudad; ?>">
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="inputState" class="form-label labelState">State</label>
                                    <input type="text" id="inputState" name="inputState" class="form-control" autocomplete="off" maxlength="50" required value="<?php echo $_SESSION['intelatlasClientData']->estado; ?>">
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="inputZip" class="form-label labelZip">Zip</label>
                                    <input type="text" id="inputZip" name="inputZip" class="form-control" autocomplete="off" maxlength="10" required value="<?php echo $_SESSION['intelatlasClientData']->codigo_postal; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="inputInfo" class="form-label labelOtionalInfo">Optional info</label>
                                <input type="text" id="inputInfo" name="inputInfo" class="form-control" autocomplete="off" maxlength="500" value="<?php echo $_SESSION['intelatlasClientData']->adicional; ?>">
                            </div>
                            <div class="d-grid gap-2 my-5">
                                <button class="btn btn-success btn-lg" type="button" id="updateClient">
                                    <i class="bi bi-check2"></i> Save information
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-5 ms-5 d-none" id="tbList">
                        <p class="lead mb-3 tituloTab2">My digital products</p>
                        <ul id="listaDescarga" class="ms-3" style="text-align: left !important;"></ul>
                    </div>
                    <div class="col-5 ms-5 d-none" id="tbPassword">
                        <p class="lead mb-3 tituloTab3">Change my password</p>
                        <form class="needs-validation-restore" novalidate>
                            <div class="mb-3 position-relative">
                                <label for="inputNewPassword" class="form-label inputNewPassword">Please enter your new password</label>
                                <input type="password" class="form-control" id="inputNewPassword" required>
                                <div class="invalid-tooltip">
                                    This required
                                </div>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="inputConfirmPassword" class="form-label inputConfirmPassword">Please confirm your new password</label>
                                <input type="password" class="form-control" id="inputConfirmPassword" required>
                                <div class="invalid-tooltip lableVerify">
                                    This required
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-success btnChangepassword">Change my password</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <script src="assets/js/mimes.js"></script>
        <script src="assets/js/download.js"></script>
<?php
    } else{
?>
        <section class="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-5 mb-3">
                        <form class="needs-validation-restorenewpassword" novalidate>
                            <div class="mb-3 position-relative">
                                <label for="inputNewPasswordRestore" class="form-label">Please enter your new password</label>
                                <input type="password" style="width:200px;" class="form-control" id="inputNewPasswordRestore" required>
                                <div class="invalid-tooltip">
                                    This required
                                </div>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="inputConfirmPasswordRestore" class="form-label">Please confirm your new password</label>
                                <input type="password" style="width:200px;" class="form-control" id="inputConfirmPasswordRestore" required>
                                <div class="invalid-tooltip lableVerify">
                                    This required
                                </div>
                            </div>

                            <button type="button" class="btn btn-success mb-3" id="btnRestoreNewPassword">Change my password</button>
                        </form>

                        <form class="needs-validation-sendlink d-none" novalidate>
                            <div class="mb-3 position-relative">
                                <label for="inputRestoreMailnew" class="form-label">
                                    The password recovery link has expired, you must generate a new link
                                </label>
                                <input style="width:200px;" type="text" class="form-control" id="inputRestoreMailnew" name="inputRestoreMailnew" aria-describedby="emailHelp" placeholder="Email to restore" required>
                                <div class="invalid-tooltip">
                                    This required
                                </div>
                            </div>

                            <button type="button" class="btn btn-success" id="btnSendlink">Send me a new link</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
?>


<script type="text/javascript">
    let messagePassword = "",
        messageVerify   = "",
        messageExist    = "",
        messageSuccess  = "",
        messageNoregistered = "";

    $(document).ready(function(){
        $("#btnLogin").click( fnValidarInfo);

        $(".nav-link").removeClass("active");
        $(".link4").addClass("active");

        $("#updateClient").click( updateClient);

        $("#linkData").click( function(){
            $(this).addClass("active");
            $("#linkList").removeClass("active");
            $("#linkPassword").removeClass("active");

            $("#tbData").removeClass("d-none");
            $("#tbList").addClass("d-none");
            $("#tbPassword").addClass("d-none");
        });

        $("#linkList").click( function(){
            $(this).addClass("active");
            $("#linkData").removeClass("active");
            $("#linkPassword").removeClass("active");

            $("#tbList").removeClass("d-none");
            $("#tbData").addClass("d-none");
            $("#tbPassword").addClass("d-none");
        });

        $("#linkPassword").click( function(){
            $(this).addClass("active");
            $("#linkData").removeClass("active");
            $("#linkList").removeClass("active");

            $("#tbPassword").removeClass("d-none");
            $("#tbData").addClass("d-none");
            $("#tbList").addClass("d-none");
        });

        $(".changeLang").click( function(){
            if (localStorage.getItem("currentLag") == "es") {
                localStorage.setItem("currentLag", "en");
                lang = "en";
            }else{
                localStorage.setItem("currentLag", "es");
                lang = "es";
            }
            switchLanguage(lang);
            switchLanguageB();
        });

        // Accion para cambiar la contraseña
        $(".btnChangepassword").click( fnChangepassword);

        // Accion para crear cuenta de cliente
        $("#btnCreateAccount").click( fnCreateAccount);

        // Activar solicitud de restableciiento
        $("#btnRestore").click( fnRestorePassword);

        // Validar que sea un id valido
        if(clientId == 0)
            $("#btnRestoreNewPassword").prop("disabled", "disabled");

        $("#btnRestoreNewPassword").click( fnResotre);

        $("#btnSendlink").click( fnSendNewLink);

        fnLoadMyproducts();
        switchLanguageB();
    });

    function fnValidarInfo(){
        let username        = $("#txtClientEmail").val(),
            userpassword    = $("#txtPassword").val(),
            objData         = {
                "_method":"_ValidateClient",
                "username": username,
                "userpassword": userpassword
            };

        $.post(`${base_url}/core/controllers/user.php`, objData, function(result) {
            if(result.codeResponse == 0){
                showAlert("warning", result.message);
            } else {
                showAlert("success", "Welcome");
                location.reload();
            }
        });
    }

    function updateClient() {
        let forms       = document.querySelectorAll('.needs-validation'),
            continuar   = true;

        // Recore cada campo del formulario para valirdar su contenido
        Array.prototype.slice.call(forms).forEach(function (formv){ 
            if (!formv.checkValidity()) {
                    continuar = false;
            }

            formv.classList.add('was-validated');
        });

        // si todo esta validado correctamente, se procede al envio de informacion
        if(!continuar)
            return false;

        // se bloqueda el boton para evitar doble accion
        $("#updateClient").attr("disabled","disabled");
        $("#updateClient").html('<i class="bi bi-clock-history"></i> Saving...');

        let form        = $("#clientForm")[0],
            formData    = new FormData(form);

        formData.append("_method", "POST");
        formData.append("leads", 0);        

        var request = new XMLHttpRequest();
        request.open("POST", "core/controllers/client.php");
        request.send(formData);
        
        $("#updateClient").removeAttr("disabled");
        $("#updateClient").html('<i class="bi bi-check2"></i> Save information');

        location.reload();
    }

    function fnLoadMyproducts(){
        let data = {
            "_method": "getProductsDigitales"
        }

        $.post("core/controllers/product.php", data, function(result){
            let downloads = result.data,
                links = "";

            $.each(downloads, function(index, item){
                links += `<li><a href="javascript:void(0);" data-token="${item.linkto}" data-pid="${item.id}" class="download">${item.name}</a></li>`;
            });

            $(links).appendTo("#listaDescarga");

            $(".download").unbind().click( function(){
                let token = $(this).data("token"),
                    pid   = $(this).data("pid");

                $.ajax({
                    url: `${base_url}/core/controllers/product.php`,
                    data: {
                        _method: "download",
                        pid: pid
                    },
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        "Authorization": `Bearer ${token}`
                    },
                    success: function(response){
                        if(response.codeResponse == 200){
                            showAlert("success", "Download in progress");

                            let base64File = `data:${mimestypes[`.${response.ext}`]};base64,${response.link}`;
                            download(base64File, response.file, mimestypes[`.${response.ext}`]);
                        }else{
                            showAlert("warning", "Error generating download link, try again later");
                        }
                    }
                });
            });
        });
    }

    function switchLanguageB(){
        $.post(`${base_url}/assets/lang.json`, {}, function(data) {

            let myLang = data[lang]["account"];
            $(".labelWelcome").html(myLang.labelWelcome);
            $("#linkData").html(myLang.link1);
            $("#linkList").html(myLang.link2);
            $("#linkPassword, .linkPassword").html(myLang.link3);
            $("#linkLogout").html(myLang.link4);

            $(".labelName").html(myLang.formLabel1);
            $(".labelLastname").html(myLang.formLabel2);
            $(".labelMail").html(myLang.formLabel3);
            $(".labelPhone").html(myLang.formLabel4);
            $(".labelAddress").html(myLang.formLabel5);
            $(".labelAddress2").html(myLang.formLabel6);
            $(".labelCity").html(myLang.formLabel7);
            $(".labelState").html(myLang.formLabel8);
            $(".labelZip").html(myLang.formLabel9);
            $(".labelOtionalInfo").html(myLang.formLabel10);
            $("#updateClient").html(myLang.labelButon);

            $(".tituloTab2").html(myLang.tituloTab2);
            $(".tituloTab3").html(myLang.tituloTab3);

            $(".inputNewPassword").html(myLang.inputNewPassword);
            $(".inputConfirmPassword").html(myLang.inputConfirmPassword);
            $(".btnChangepassword").html(myLang.btnChangepassword);
            messagePassword = myLang.messagePassword;
            messageVerify = myLang.messageVerify;
            $(".invalid-tooltip").html(myLang.invalid_tooltip);

            $(".labelCreateaccount").html(myLang.labelCreateaccount);
            $(".labelRecoveryPassw").html(myLang.labelRecoveryPassw);
            $("#inputRestoreMail").attr("placeholder", myLang.inputRestoreMail);
            $(".btnClose").html(myLang.btnClose);
            $("#btnRestore").html(myLang.btnRestore);
            $("#btnCreateAccount").html(myLang.btnCreateAccount);
            $("#btnLogin").html(myLang.btnLogin);

            messageExist = myLang.messageExist;
            messageSuccess = myLang.messageSuccess;
            messageNoregistered = myLang.messageNoregistered;
        });
    }

    // Metodo para cambiar contraseña
    function fnChangepassword() {
        let forms = document.querySelectorAll('.needs-validation-restore'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (form){ 
                if (!form.checkValidity()) {
                        continuar = false;
                }

                form.classList.add('was-validated');
        });

        if(!continuar)
            return false;

        if( $("#inputNewPassword").val() != $("#inputConfirmPassword").val() ){
            $(".needs-validation-restore").removeClass("was-validated");
            $("#inputConfirmPassword").addClass("is-invalid");
            $(".lableVerify").html(messageVerify);
            return false;
        }

        let objData = {
            "_method": "updatePasswordConfig",
            "newPassword": $("#inputConfirmPassword").val()
        };

        $.ajax({
            url: `core/controllers/client.php`,
            data: objData,
            type: 'POST',
            dataType: 'json',
            success: function(response){
                showAlert("success", messagePassword);
                $("#inputConfirmPassword").val("");
                $("#inputNewPassword").val("");
                $(".needs-validation-restore").removeClass("was-validated");
                $("#inputConfirmPassword").removeClass("is-invalid");
            }
        });
    }

    // Metodo para crear la cuenta de cliente
    function fnCreateAccount(){
        let forms = document.querySelectorAll('.needs-validation-client'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (form){ 
                if (!form.checkValidity()) {
                        continuar = false;
                }

                form.classList.add('was-validated');
        });

        if(!continuar)
            return false;

        let data = {
            "_method": "validarEmail",
            "email": $("#inputEmailNewClient").val()
        };

        $.post(`${base_url}/core/controllers/client.php`, data, function(result){
            if(result.existe > 0){
                $(".needs-validation-client").removeClass("was-validated");
                $("#inputEmailNewClient").addClass("is-invalid");
                showAlert("warning", messageExist);
            } else {
                let formData = new FormData();

                formData.append("_method", "POST");
                formData.append("leads", 0);
                formData.append("inputName", $("#inputNameNewClient").val());
                formData.append("inputLastname", $("#inputLastnameNewClient").val());
                formData.append("inputAddress", "");
                formData.append("inputAddress2", "");
                formData.append("inputEmail", $("#inputEmailNewClient").val());
                formData.append("inputPhone", "");
                formData.append("inputCity", "");
                formData.append("inputState", "");
                formData.append("inputZip", "");
                formData.append("inputInfo", "");
                formData.append("clientId", 0);
                formData.append("password", $("#inputPasswordNewClient").val());

                var request = new XMLHttpRequest();
                request.open("POST", "core/controllers/client.php");
                request.send(formData);

                $("#addClientForm")[0].reset();
                $(".needs-validation-client").removeClass("was-validated");
                $("#inputEmailNewClient").removeClass("is-invalid");
                $("#mdlCreateaccount").modal("hide");

                showAlert("success", messageSuccess);
            }
        });
    }

    function fnRestorePassword(){
        let forms = document.querySelectorAll('.needs-validation-restorepassword'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (form){ 
                if (!form.checkValidity()) {
                        continuar = false;
                }

                form.classList.add('was-validated');
        });

        if(!continuar)
                return false;

        let objData = {
            "_method": "_RestorePassword",
            "email": $("#inputRestoreMail").val()
        };

        $.post("core/controllers/client.php", objData, function(result) {
            if(result.data.existe == 0){
                showAlert("warning", messageNoregistered);
            } else {
                $(".needs-validation-restorepassword").removeClass("was-validated");
                $("#inputRestoreMail").val("");
                $("#mdlRestorepassword").modal("hide");
                showAlert("success", "An email was sent with the league to reset your password");
            }
        });
    }

    function fnResotre(){
        let forms = document.querySelectorAll('.needs-validation-restorenewpassword'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (form){ 
                if (!form.checkValidity()) {
                        continuar = false;
                }

                form.classList.add('was-validated');
        });

        if(!continuar)
            return false;

        if( $("#inputNewPasswordRestore").val() != $("#inputConfirmPasswordRestore").val() ){
            $(".needs-validation-restorenewpassword").removeClass("was-validated");
            $("#inputConfirmPasswordRestore").addClass("is-invalid");
            $(".lableVerify").html("Passwords do not match");
            return false;
        }

        let objData = {
            "_method": "updatePassword",
            "newPassword": $("#inputConfirmPasswordRestore").val(),
            "clientId": clientId
        };

        $.ajax({
            url: `${base_url}/core/controllers/client.php`,
            data: objData,
            type: 'POST',
            dataType: 'json',
            headers: {
                "Authorization": `Bearer ${token}`
            },
            success: function(response){
                if(response.codeResponse == 200){
                    window.location.replace("account.php");
                }else{
                    $(".needs-validation-restorenewpassword").addClass("d-none");
                    $(".needs-validation-sendlink").removeClass("d-none");
                }
            }
        });
    }

    function fnSendNewLink(){
        let forms = document.querySelectorAll('.needs-validation-sendlink'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (form){ 
                if (!form.checkValidity()) {
                        continuar = false;
                }

                form.classList.add('was-validated');
        });

        if(!continuar)
                return false;

        let objData = {
            "_method": "_RestorePassword",
            "email": $("#inputRestoreMailnew").val()
        };

        $.post("core/controllers/client.php", objData, function(result) {
            if(result.data.existe == 0){
                showAlert("warning", "The user is not registered");
            } else {
                $(".needs-validation-sendlink").removeClass("was-validated");
                $("#inputRestoreMailnew").val("");
                showAlert("success", "An email was sent with the league to reset your password");
            }
        });
    }
</script>

<?php
    // Se obtiene el contenido del bufer
    $content = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se carga la pagina maestra para imprimir la pagina global
    include("masterPage.php");
?>