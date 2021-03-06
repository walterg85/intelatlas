<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<!-- Colocar el contenido HTML Aqui -->
<div class="container py-4">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">About Us</h1>
            <p class="fs-4">We are a web development company located in Tucson, AZ.</p>
            <p class="fs-4">We are a web development company located in Tucson, AZ.</p>
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