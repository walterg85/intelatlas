<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<!-- Colocar el contenido HTML Aqui -->
<div class="container py-4">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold pageTitle">Logo Design</h1>
            <p class="col-md-8 fs-4 pageDescription">Grab the attention of potential customers and make a strong first impression by getting an awesome logo design.</p>
            <!-- <button class="btn btn-orange labelButton" type="button">Order Now</button> -->
        </div>
    </div>
</div>

<div class="container">
    <div class="col webClone d-none">
        <div class="card mb-4 rounded-3 bg-gris text-gris">
            <a href="javascript:void(0);" class="linkto text-decoration-none text-gris"> <h4 class="cardtitle mt-4 fw-normal">Free Website Draft</h4></a>
            <span class="text-secondary advanced d-none">Popular</span>
            <div class="card-body pt-0">
                <h3 class="card-title fw-light text-secondary">
                    <span class="lblPrice">$149</span><span class="lblSalePrice d-none ms-2">$149</span>
                </h3>
                <ul class="list-unstyled mt-3 mb-4 lblDescriptions"></ul>
                <button type="button" class="w-100 btn-orange btnAddtocart labelPurchase2">Buy Now</button>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 mb-3 text-center text-light listLogosPrice"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        loadData("listLogosPrice", "Logo");

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
        });
    }

    function languagePage(lang){
        $.post(`${base_url}/assets/lang.json`, {}, function(data) {

            let myLang = data[lang]["logos"];

            $(".pageTitle").html(myLang.pageTitle);
            $(".pageDescription").html(myLang.pageDescription);
            $(".labelButton").html(myLang.labelButton);
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