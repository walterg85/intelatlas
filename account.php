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
                    </div>
                </div>
            </div>
        </section>
<?php
    } else {
?>
        <section class="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p>Welcome</p>
                        <nav class="navbar">
                            <ul>
                                <li><a href="javascript:void(0);" class=" active" style="color:#0a58ca !important;">Profile</a></li>
                                <li><a href="javascript:void(0);" class="" style="color:#0a58ca !important;">my digital purchases</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-5 ms-5">
                        <form id="clientForm" class="needs-validation" novalidate>
                            <input type="hidden" name="clientId" id="clientId" value="0">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="inputName" class="form-label labelName">Name</label>
                                    <input type="text" id="inputName" name="inputName" class="form-control" autocomplete="off" maxlength="250" required value="<?php echo $_SESSION['intelatlasClientData']->nombre; ?>">
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
                                    <label for="inputPhone" class="form-label labelPhone">Phone</label>
                                    <input type="text" id="inputPhone" name="inputPhone" class="form-control" autocomplete="off" maxlength="20" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="inputAddress" class="form-label labelAddress">Address</label>
                                <input type="text" id="inputAddress" name="inputAddress" class="form-control" autocomplete="off" maxlength="500" required>
                            </div>
                            <div class="mb-3">
                                <label for="inputAddress2" class="form-label labelAddress2">Address 2</label>
                                <input type="text" id="inputAddress2" name="inputAddress2" class="form-control" autocomplete="off" maxlength="500">
                            </div>
                            <div class="row">
                                <div class="col-5 mb-3">
                                    <label for="inputCity" class="form-label labelCity">City</label>
                                    <input type="text" id="inputCity" name="inputCity" class="form-control" autocomplete="off" maxlength="50" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="inputState" class="form-label labelState">State</label>
                                    <input type="text" id="inputState" name="inputState" class="form-control" autocomplete="off" maxlength="50" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="inputZip" class="form-label labelZip">Zip</label>
                                    <input type="text" id="inputZip" name="inputZip" class="form-control" autocomplete="off" maxlength="10" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
?>


<script type="text/javascript">
    $(document).ready(function(){
        $("#btnLogin").click( fnValidarInfo);

        $(".nav-link").removeClass("active");
        $(".link4").addClass("active");
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
</script>

<?php
    // Se obtiene el contenido del bufer
    $content = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se carga la pagina maestra para imprimir la pagina global
    include("masterPage.php");
?>