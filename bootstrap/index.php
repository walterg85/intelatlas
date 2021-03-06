<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<!-- Colocar el contenido HTML Aqui -->
<div class="container py-4">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold pageTitle">Bootstrap Themes</h1>
            <p class="col-md-8 fs-4 pageDescription">Coming Soon...</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".changeLang").click( function(){
            if (localStorage.getItem("currentLag") == "es") {
                localStorage.setItem("currentLag", "en");
                lang = "en";
            }else{
                localStorage.setItem("currentLag", "es");
                lang = "es";
            }
            switchLanguage(lang);
            languagePage(lang);
        });

        languagePage(lang);
    });

    function languagePage(lang){
        $.post(`${base_url}/assets/lang.json`, {}, function(data) {

            let myLang = data[lang]["bootstrap"];

            $(".pageTitle").html(myLang.pageTitle);
            $(".pageDescription").html(myLang.pageDescription);
        });
    }
</script>

<?php
    // Se obtiene el contenido del bufer
    $content = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se carga la pagina maestra para imprimir la pagina global
    include("../masterPage.php");
?>