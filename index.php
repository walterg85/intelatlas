<?php
    // Se inicia el metodo para encapsular el contenido del carusel, 
    // Esto solo por que se dibujan en secciones apartadas
    ob_start();
?>

<div class="container text-center">
    <div class="col col-md-8 col-lg-6 mx-auto">
        <div class="carousel-item d-none carouselClone my-3">
            <h1 class="fw-light"><span class="pName text-gris">store</span></h1>
            <p class="lead mb-4 pPrice">Get 3 design with unlimited revision. Pick your favorite for only $95.</p>
            <button type="button" class="btn-green px-4 me-sm-3 btnAddtocart labelPurchase1">Buy Now</button>     
        </div>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner objContenedor"></div>
        </div>    
    </div>
</div>

<?php
    // Se obtiene el contenido del bufer
    $carousel = ob_get_contents();

    // Limpiar el bufer para liberar
    ob_end_clean();

    // Se inicia el metodo para encapsular el resto del contenido
    ob_start();
?>

<div class="container">
    <div class="row">
        <div class="col hero-img">
            <img class="hero-img1 float-start" src="assets/img/hero.png?v=1.7" alt="Example image" loading="lazy">
            <img class="hero-img2 float-end" src="assets/img/rocket.png?v=1.1" alt="Example image" loading="lazy">           
        </div>
    </div>
</div>
<!-- ======= Website Pricing Section ======= -->
<div class="pricing-header mt-3 p-3 pb-md-4 mx-auto text-center">
    <h1 class="fw-light">Popular websites packages</h1>
</div>

<div class="container-fluid">
    <div class="col webClone d-none">
        <div class="card mb-4 rounded-3 bg-gris text-gris">
            <a href="javascript:void(0);" class="linkto text-decoration-none text-gris"> <h4 class="cardtitle mt-4 fw-normal">Free Website Draft</h4></a>
            <span class="text-secondary advanced d-none">Popular</span>
            <div class="card-body pt-0">
                <h3 class="card-title fw-light text-secondary">
                    <span class="lblPrice">$149</span><span class="lblSalePrice d-none ms-2">$149</span>
                </h3>
                <ul class="list-unstyled mt-3 mb-4 lblDescriptions"></ul>
                <button type="button" class="w-100 btn-green btnAddtocart labelPurchase2">Buy Now</button>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 mb-3 text-center text-light listWebPrice"></div>
</div>
<!-- End Website Section -->

<!-- ======= Banner Section ======= -->
<div class="container-fluid col-xl-10 col-xxl-8 px-4 py-5 text-secondary">
    <div class="row align-items-center g-5 py-5">
        <div class="col-md-10 mx-auto col-lg-6 order-lg-last">
            <img src="assets/img/home.jpg?v=1.2" class="d-block mx-lg-auto img-fluid shadow-lg" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6 text-lg-start">
            <h1 class="fw-light mb-3 bannerTittle">Vertically centered hero sign-up form</h1>
            <p class="lead bannerSubTittle">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
            <div class="d-grid gap-2 d-flex justify-content-center">
                <button type="button" class="btn-exito px-4 me-md-2 ctaCall">Primary</button>
                <button type="button" class="btn-normal px-4 linkChat ctaMessage">Default</button>
            </div>
        </div>
    </div>
</div>
<!-- End Banner Section -->

<!-- ======= Pricing Section ======= -->
<div class="pricing-header p-3 pb-md-4 mx-auto text-center">
    <h1 class="fw-light">Online Store</h1>
</div>
<div class="container-fluid">
    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 mb-3 text-center text-light listStorePrice"></div>
</div>
<!-- End Pricing Section -->

<script type="text/javascript">
    let setFnButton = null;

    $(document).ready(function(){
        loadData("listWebPrice", "Website");
        loadData("listStorePrice", "Store");
        getCarouselData();

        $(".changeLang").click( function(){
            if (localStorage.getItem("currentLag") == "es") {
                localStorage.setItem("currentLag", "en");
                lang = "en";
            }else{
                localStorage.setItem("currentLag", "es");
                lang = "es";
            }
            switchLanguage(lang);

            loadData("listWebPrice", "Website");
            loadData("listStorePrice", "Store");
            getCarouselData();
        });

        $("#fixBaground").removeClass("fixBaground");

        setFnButton = setInterval(activeBoton, 1500);
    });

    function loadData(obj, category){
        let objData = {
                "_method":"GET",
                "limite": 0,
                "categoria": category
            };

        $.post(`${base_url}/core/controllers/product.php`, objData, function(result) {
            $(`.${obj}`).html("");

            $.each( result.data, function( index, item){
                let productCard = $(".webClone").clone();

                if(lang == "en"){
                    productCard.find(".cardtitle").html(item.name);
                    let descriptions = JSON.parse(item.descriptions);
                    $.each( descriptions, function(i, d){
                        productCard.find(".lblDescriptions").append(`<li class="${(d.underline == 1) ? 'na' : ''}">${d.descripcion}</li>`);
                    });
                }else{
                    productCard.find(".cardtitle").html(item.optional_name);
                    let descriptions = JSON.parse(item.descriptions);
                    $.each( descriptions, function(i, d){
                        productCard.find(".lblDescriptions").append(`<li class="${(d.underline == 1) ? 'na' : ''}">${d.descripcionOpc}</li>`);
                    });
                }

                let img = (item.thumbnail != "" &&  item.thumbnail != "0") ? `${base_url}/${item.thumbnail}` : `${base_url}/assets/img/default.jpg`;
                productCard.find(".card-img-top").attr("src", `${img}`);
                productCard.find(".card-img-top").parent().attr("href", `${base_url}/product/index.php?pid=${item.id}`);
                productCard.find(".linkto").attr("href", `${base_url}/product/index.php?pid=${item.id}`);
                productCard.find(".lblPrice").html(`$${item.price}`);

                let salePrice = parseFloat(item.sale_price);
                if(salePrice > 0){
                    productCard.find(".lblPrice").addClass(`fs-6 text-decoration-line-through`);
                    productCard.find(".lblSalePrice").removeClass("d-none");
                    productCard.find(".lblSalePrice").html(`$${salePrice}`);
                }

                productCard.find(".btnAddtocart").data("item", item);

                if(item.optional_description == 1)
                    productCard.find(".advanced").removeClass("d-none");

                if(index > 0)
                    productCard.addClass("mt-4 mt-md-0");

                productCard.attr("data-aos", "fade-up");
                productCard.attr("data-aos-delay", (index +1 ) * 100 );

                productCard.removeClass("d-none webClone");
                $(productCard).appendTo(`.${obj}`);
            });
        });
    }

    // Metodo para buscar los productos del carousel
    function getCarouselData(){
        let objData = {
            _method: "getCarouselData"
        };

        $.post(`${base_url}/core/controllers/product.php`, objData, function(result){
            $(".objContenedor").html("");
            $.each( result.data, function(index, item){
                let objHTML = $(".carouselClone").clone(),
                    alternatives = (item.alternatives) ? JSON.parse(item.alternatives) : null;

                if(lang == "en"){
                    objHTML.find(".pName").html(item.name);

                    if(alternatives){
                        objHTML.find(".pPrice").html(`${alternatives.alternative}`);
                    }

                    objHTML.find(".pPrice").append(` Only $${item.price}`);
                } else {
                    objHTML.find(".pName").html(item.optional_name);

                    if(alternatives){
                        objHTML.find(".pPrice").html(`${alternatives.alternativeSp}`);
                    }

                    objHTML.find(".pPrice").append(` Solo $${item.price}`);
                }

                objHTML.find(".btnAddtocart").data("item", item);                

                if(index == 0)
                    objHTML.addClass("active");

                objHTML.removeClass("d-none carouselClone");
                $(objHTML).appendTo(".objContenedor");
            });
        });
    }

    // Activar accion del boton
    function activeBoton(){
        clearInterval(setFnButton);
        $(".btnAddtocart").unbind().click(function(){
            let currentItem = $(this).data("item"),
                newItem = {},
                currentCart = JSON.parse(localStorage.getItem("currentCart")),
                config = JSON.parse(currentItem.dimensions);

            if(!currentCart){
                localStorage.setItem("currentCart", "{}");
                currentCart = {};
            }

            if(currentCart[currentItem.id]){
                currentCart[currentItem.id].qty = currentCart[currentItem.id].qty + 1;
            }else{
                newItem.id                      = currentItem.id;
                newItem.name                    = currentItem.name;
                newItem.optional_name           = currentItem.optional_name;
                newItem.descriptions            = currentItem.descriptions;
                newItem.optional_description    = currentItem.optional_description;
                newItem.thumbnail               = currentItem.thumbnail;
                newItem.price                   = (parseFloat(currentItem.sale_price) > 0) ? currentItem.sale_price : currentItem.price;
                newItem.esdigital               = currentItem.esdigital;
                newItem.qty                     = 1;
                currentCart[currentItem.id]     = newItem;
            }

            localStorage.setItem("currentCart", JSON.stringify(currentCart));
            countCartItem();

            // Ejecutar para redirigir al checkout
            $(".btnCheckout").click();
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