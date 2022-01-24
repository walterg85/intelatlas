<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<!-- Colocar el contenido HTML Aqui -->
<div class="container py-4">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">FAQ's</h1>
            <p class="fs-4">How long does it takes for my website to be ready?</p>
            <p class="lead">Get a website in less than 48hrs.  Online store takes about 5 days.</p>
            <p class="fs-4">How much does it cost to get a website?</p>                
            <p class="lead">We offer a variety of prices for all our services.  Please contact us for more information.</p>
            <p class="fs-4">What is hosting?</p>
            <p class="lead">Hosting is where your design lives. Every website needs hosting to be available online all the time.</p>
        </div>
    </div>
</div>

<?php
    // Se obtiene el contenido del bufer
    $content = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se carga la pagina maestra para imprimir la pagina global
    include("../masterPage.php");
?>