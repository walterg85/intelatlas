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
                </div>
            </div>
        </section>
<?php
    }
?>


<script type="text/javascript">
    $(document).ready(function(){
        $("#btnLogin").click( fnValidarInfo);
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