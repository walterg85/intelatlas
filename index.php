<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<div class="section-title">
    <h2>TOP PRODUCTS</h2>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="box">
            <div class="card shadow">
        <div class="badge bg-warning text-white position-absolute d-none brandPrice" style="top: 0.5rem; right: 0.5rem">
            Sale
        </div>
        <div>
            <a href="javascript:void(0);">
                <img src="#" alt="image" class="img-fluid card-img-top">
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <h5>
                <span class="text-muted text-decoration-line-through lblOldPrice d-none"></span>
                <span class="price lblPrice"></span>
            </h5>
            <input type="hidden">
            <button type="button" class="btn btn-success my-3 btnAddtocart">Add To Cart</button>                                                   
        </div>
    </div>
            <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
            </div>
        </div>
    </div>
</div>


<!-- Products -->
<!-- <div class="text-center col-lg-3 col-md-4 col-6 my-3 itemClone d-none">
    <div class="card shadow">
        <div class="badge bg-warning text-white position-absolute d-none brandPrice" style="top: 0.5rem; right: 0.5rem">
            Sale
        </div>
        <div>
            <a href="javascript:void(0);">
                <img src="#" alt="image" class="img-fluid card-img-top">
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <h5>
                <span class="text-muted text-decoration-line-through lblOldPrice d-none"></span>
                <span class="price lblPrice"></span>
            </h5>
            <input type="hidden">
            <button type="button" class="btn btn-success my-3 btnAddtocart">Add To Cart</button>                                                   
        </div>
    </div>
</div> -->
<div class="row" id="ListProduct"></div>

<script type="text/javascript">
    $(document).ready(function(){
        // Invoca al metodo de listar productos declarada en la pagina maestra, se setea un patrametro que indica la cantidad de prodcuto a listar
        // getProducts(20);
    });
</script>

<?php
    // Se obtiene el contenido del bufer
    $content = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se carga la pagina maestra para imprimir la pagina global
    include("masterPage.php");
?>