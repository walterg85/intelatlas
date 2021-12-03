<?php
    // Se inicia el metodo para encapsular todo el contenido de las paginas (bufering), para dar salida al HTML 
    ob_start();
?>

<!-- ======= Website Pricing Section ======= -->
<section id="web-price" class="pricing web-price">
    <div class="container" data-aos="fade-up">
        <div class="col-lg-3 col-md-6 webClone d-none" data-aos="fade-up" data-aos-delay="100">
            <div class="box">
                <h3 class="card-title">Free Website Draft</h3>
                <h4 class="lblPrice"></h4>
                <ul>
                    <li>Custom Web Design</li>
                    <li>Frontpage</li>
                    <li>Contact form</li>
                    <li>Images</li>
                    <li>Multi language ready</li>
                </ul>
                <div class="btn-wrap">
                    <a href="javascript:void(0);" class="btn-buy btnAddtocart">Buy Now</a>
                </div>
            </div>
        </div>
        <div class="row listWebPrice"></div>
    </div>
</section>
<!-- End Pricing Section -->

<!-- ======= Cta Section ======= -->
<section id="cta" class="cta">
    <div class="container">
        <div class="row" data-aos="zoom-in">
            <div class="col-lg-9 text-center text-lg-start">
                <h3>Custom Website</h3>
                <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="col-lg-3 cta-btn-container text-center">
                <a class="cta-btn align-middle" href="#">Call</a>
                <a class="cta-btn align-middle linkChat" href="javascript:void(0);">Chat</a>
            </div>
        </div>
    </div>
</section>
<!-- End Cta Section -->

<!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>ONLINE STORE</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="box">
                    <h3>Free Store Draft</h3>
                    <h4><sup>$</sup>0</h4>
                    <ul>
                        <li>Front page</li>
                        <li>Nec feugiat nisl</li>
                        <li>Nulla at volutpat dola</li>
                        <li class="na">Pharetra massa</li>
                        <li class="na">Massa ultricies mi</li>
                    </ul>
                    <div class="btn-wrap">
                        <a href="#" class="btn-buy">Buy Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
                <div class="box featured">
                    <h3>Store Starter</h3>
                    <h4><sup>$</sup>19</h4>
                    <ul>
                        <li>Aida dere</li>
                        <li>Nec feugiat nisl</li>
                        <li>Nulla at volutpat dola</li>
                        <li>Pharetra massa</li>
                        <li class="na">Massa ultricies mi</li>
                    </ul>
                    <div class="btn-wrap">
                        <a href="#" class="btn-buy">Buy Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                <div class="box">
                    <span class="advanced">Popular</span>
                    <h3>Store Professional</h3>
                    <h4><sup>$</sup>29</h4>
                    <ul>
                        <li>Aida dere</li>
                        <li>Nec feugiat nisl</li>
                        <li>Nulla at volutpat dola</li>
                        <li>Pharetra massa</li>
                        <li>Massa ultricies mi</li>
                    </ul>
                    <div class="btn-wrap">
                        <a href="#" class="btn-buy">Buy Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                <div class="box">              
                    <h3>Store Advance</h3>
                    <h4><sup>$</sup>49</h4>
                    <ul>
                        <li>Aida dere</li>
                        <li>Nec feugiat nisl</li>
                        <li>Nulla at volutpat dola</li>
                        <li>Pharetra massa</li>
                        <li>Massa ultricies mi</li>
                    </ul>
                    <div class="btn-wrap">
                        <a href="#" class="btn-buy">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Pricing Section -->

<script type="text/javascript">
    $(document).ready(function(){
        fnWebPrice();
    });

    function fnWebPrice(){
        let objData = {
                "_method":"GET",
                "limite": 0,
                "categoria": "Website"
            };

        $.post(`${base_url}/core/controllers/product.php`, objData, function(result) {
            $(".listWebPrice").html("");
            $.each( result.data, function( index, item){
                let productCard = $(".webClone").clone();

                if(lang == "en"){
                    productCard.find(".card-title").html(item.name);
                }else{
                    productCard.find(".card-title").html(item.optional_name);
                }

                productCard.find(".lblPrice").html(`<sup>$</sup> ${item.price}`);

                productCard.find(".btnAddtocart").data("item", item);

                productCard.removeClass("d-none webClone");
                $(productCard).appendTo(".listWebPrice");
            });
        });

        

        // $(".btnAddtocart").unbind().click(function(){
        //     let currentItem = $(this).data("item"),
        //         newItem = {},
        //         currentCart = JSON.parse(localStorage.getItem("currentCart")),
        //         config = JSON.parse(currentItem.dimensions);

        //     if( config=="0" || ((config[0].sizes).length == 0 && config[1].colors[0] == "") ){
        //         if(!currentCart){
        //             localStorage.setItem("currentCart", "{}");
        //             currentCart = {};
        //         }                    

        //         newItem.id = currentItem.id;
        //         newItem.name = currentItem.name;
        //         newItem.optional_name = currentItem.optional_name;
        //         newItem.descriptions = currentItem.descriptions;
        //         newItem.optional_description = currentItem.optional_description;
        //         newItem.thumbnail = currentItem.thumbnail;

        //         if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
        //             newItem.price = currentItem.sale_price;
        //         }else{
        //             newItem.price = currentItem.price;
        //         }

        //         if(currentCart[currentItem.id]){
        //             currentCart[currentItem.id].qty = currentCart[currentItem.id].qty + 1;
        //         }else{
        //             newItem.qty = 1;
        //             currentCart[currentItem.id] = newItem;
        //         }

        //         localStorage.setItem("currentCart", JSON.stringify(currentCart));
        //         countCartItem();

        //         // Ejecutar para redirigir al checkout
        //         $(".btnCheckout").click();
        //     }else{
        //         if(lang == "en"){
        //             $(".lblMdlName").html(currentItem.name);
        //             $(".lblDescription").html(currentItem.descriptions);
        //         }else{
        //             $(".lblMdlName").html(currentItem.optional_name);
        //             $(".lblDescription").html(currentItem.optional_description);
        //         }                        

        //         if( (currentItem.sale_price).length > 0 && currentItem.sale_price > 0){
        //             $(".lblMdlPrice").html( formatter.format(currentItem.sale_price) );
        //         }else{
        //             $(".lblMdlPrice").html( formatter.format(currentItem.price) );
        //         }

        //         $("#mdlAddtoCart").data("item", currentItem);

        //         let images = JSON.parse(currentItem.images);
        //         $.each( images, function( index, item){
        //             $(`.img${index}`)
        //                 .attr("src", `${base_url}/${item}`)
        //                 .parent().removeClass("d-none");
        //         });

        //         $(".dvSizes").addClass("d-none");
        //         if((config[0].sizes).length > 0){
        //             $(".dvSizes").removeClass("d-none");
        //             $(".toRemoves").remove();

        //             $.each(config[0].sizes, function(index, item){
        //                 let dv = $(".chSizes").clone();

        //                 dv.find(".chk").val(item).attr("id", `ch${item}`);

        //                 if(item == "sm")
        //                     dv.find(".lbl").html("Small");

        //                 if(item == "m")
        //                     dv.find(".lbl").html("Medium");

        //                 if(item == "l")
        //                     dv.find(".lbl").html("Large");

        //                 if(item == "xl")
        //                     dv.find(".lbl").html("Extra large");

        //                 dv.find(".lbl").attr("for", `ch${item}`);
                        
        //                 if(index == 0)
        //                     dv.find(".chk").prop("checked", true);

        //                 dv.removeClass("d-none chSizes");
        //                 dv.addClass("toRemoves");
        //                 $(dv).appendTo(".dvSizes");
        //             });
        //         }

        //         $(".dvColors").addClass("d-none");
        //         if(config[1].colors[0] != ""){
        //             $(".dvColors").removeClass("d-none");
        //             $(".toRemovec").remove();

        //             let items = (config[1].colors[0]).split(",");
        //             $.each(items, function(index, item){
        //                 let dv = $(".chColors").clone();

        //                 dv.find(".chk").val(item).attr("id", `rd${item}`);
        //                 dv.find(".lbl").html(item).attr("for", `rd${item}`);

        //                 if(index == 0)
        //                     dv.find(".chk").prop("checked", true);

        //                 dv.removeClass("d-none chColors");
        //                 dv.addClass("toRemovec");
        //                 $(dv).appendTo(".dvColors");

        //             });
        //         }

        //         $("#mdlProDetalle").modal("show");
        //     }
        // });
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