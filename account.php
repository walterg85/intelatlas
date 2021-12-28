<?php
    @session_start();
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<style type="text/css"></style>

<?php
    if (!isset($_SESSION['intelatlasClientLoged'])){
?>
        <section class="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-5">
                        <div class="mb-3">
                            <label for="txtClientEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="txtClientEmail" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="txtPassword" class="form-label">Password</label>
                            <input type="password" id="txtPassword" class="form-control">
                        </div>
                        <button type="button" id="btnLogin" class="btn btn-success mb-3">Confirm identity</button>

                        <a href="javascript:void(0);" class="text-decoration-none mx-2" data-bs-toggle="modal" data-bs-target="#mdlCreateaccount">Create new account</a> |
                        <a href="javascript:void(0);" class="text-decoration-none ms-2">Recover password</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal para Registrar nueva cuenta -->
        <div class="modal fade" id="mdlCreateaccount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Create new account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addClientForm" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputName" class="form-label labelName">Name</label>
                                    <input type="text" id="inputName" name="inputName" class="form-control" autocomplete="off" maxlength="250" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="inputLastname" class="form-label labelLastname">Last name</label>
                                    <input type="text" id="inputLastname" name="inputLastname" class="form-control" autocomplete="off" maxlength="50" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputEmail" class="form-label labelMail">Email</label>
                                    <input type="text" id="inputEmail" name="inputEmail" class="form-control" autocomplete="off" maxlength="20" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="inputPassword" class="form-label labelPassword">Password</label>
                                    <input type="password" id="inputPassword" name="inputPassword" class="form-control" autocomplete="off" maxlength="20" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btnClose" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success">Create</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
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
    }
?>


<script type="text/javascript">
    let messagePassword = "",
        messageVerify = "";

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

        fnLoadMyproducts();
        switchLanguageB();
    });

    function fnValidarInfo(){
        let username = $("#txtClientEmail").val(),
            userpassword = $("#txtPassword").val(),
            objData = {
                "_method":"_ValidateClient",
                "username": username,
                "userpassword": userpassword
            };

        $.post("core/controllers/user.php", objData, function(result) {
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
            $("#linkPassword").html(myLang.link3);
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
</script>

<?php
    // Se obtiene el contenido del bufer
    $content = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se carga la pagina maestra para imprimir la pagina global
    include("masterPage.php");
?>