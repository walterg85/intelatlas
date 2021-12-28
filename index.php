<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="carousel-item d-none carouselClone">
        <div class="carousel-container">
            <h2 class="animate__animated animate__fadeInDown pName">Websites and more</h2>
            <p class="animate__animated animate__fadeInUp pPrice">Basic website only $189</p>
            <a href="javascript:void(0);" class="btn-get-started animate__animated animate__fadeInUp scrollto btnAddtocart labelPurchase1">Order now</a>
        </div>
    </div>

    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
        <div class="objContenedor"></div>
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bx bx-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bx bx-chevron-right" aria-hidden="true"></span>
        </a>
    </div>
</section>
<!-- End Hero -->

<!-- ======= Website Pricing Section ======= -->
<section id="web-price" class="pricing web-price">
    <div class="container" data-aos="fade-up">
        <div class="col-lg-3 col-md-6 webClone d-none">
            <div class="box">
                <span class="advanced d-none">Popular</span>
                <a href="javascript:void(0);" class="linkto"> <h3 class="card-title">Free Website Draft</h3></a>
                <div class="mb-3">
                    <a href="javascript:void(0);">
                        <img src="#" alt="image" class="img-fluid card-img-top">
                    </a>
                </div>
                <h4 class="lblPrice"></h4>
                <ul class="lblDescriptions"></ul>
                <div class="btn-wrap">
                    <a href="javascript:void(0);" class="btn-buy btnAddtocart labelPurchase2">Buy Now</a>
                </div>
            </div>
        </div>
        <div class="row listWebPrice"></div>
    </div>
</section>
<!-- End Website Section -->

<!-- ======= Cta Section ======= -->
<section id="cta" class="cta">
    <div class="container">
        <div class="row" data-aos="zoom-in">
            <div class="col-lg-9 text-center text-lg-start">
                <h3 class="bannerTittle">Your brand</h3>
                <p class="bannerSubTittle"> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="col-lg-3 cta-btn-container text-center">
                <a class="cta-btn align-middle ctaCall" href="#">Call</a>
                <a class="cta-btn align-middle linkChat ctaMessage" href="javascript:void(0);">Chat</a>
            </div>
        </div>
    </div>
</section>
<!-- End Cta Section -->

<!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2 class="ctaStoreTittle">ONLINE STORE</h2>
            <p class="ctaStoreSubTittle">Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row listStorePrice"></div>
    </div>
</section>
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
                    productCard.find(".card-title").html(item.name);
                    let descriptions = JSON.parse(item.descriptions);
                    $.each( descriptions, function(i, d){
                        productCard.find(".lblDescriptions").append(`<li class="${(d.underline == 1) ? 'na' : ''}">${d.descripcion}</li>`);
                    });
                }else{
                    productCard.find(".card-title").html(item.optional_name);
                    let descriptions = JSON.parse(item.descriptions);
                    $.each( descriptions, function(i, d){
                        productCard.find(".lblDescriptions").append(`<li class="${(d.underline == 1) ? 'na' : ''}">${d.descripcionOpc}</li>`);
                    });
                }

                let img = (item.thumbnail != "" &&  item.thumbnail != "0") ? `${base_url}/${item.thumbnail}` : `${base_url}/assets/img/default.jpg`;
                productCard.find(".card-img-top").attr("src", `${img}`);
                productCard.find(".card-img-top").parent().attr("href", `${base_url}/product/index.php?pid=${item.id}`);
                productCard.find(".linkto").attr("href", `${base_url}/product/index.php?pid=${item.id}`);

                productCard.find(".lblPrice").html(`<sup>$</sup> ${item.price}`);
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
                } else {
                    objHTML.find(".pName").html(item.optional_name);

                    if(alternatives){
                        objHTML.find(".pPrice").html(`${alternatives.alternativeSp}`);
                    }
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
                newItem.price                   = currentItem.price;
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