<?php
    // Se requiere el modelo de setting para recuperar el id de paypal    
    require_once '../core/models/setting.php';

    // Se instancia la clase
    $settingsModel  = new Settingsmodel();

    // Se recuperan los parametros de configuracion
    $configs = $settingsModel->get();
    $data['existeId'] = FALSE;

    // Estructura de control para validar que exista el id de paypal
    foreach ($configs as $key => $value) {
        if($value['parameter'] == 'paypalid'){
            $data['existeId'] = TRUE;
            $data['paypalId'] = $value['value'];
            break;
        }
    }

    // Si no existe el id de paypal, se redirige al index de la tienda
    if(!$data['existeId']){
        header('Location: ../index.php');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap, CSS & Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Checkout | IntelAtlas</title>
</head>
<body> 
    <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $data['paypalId']; ?>&currency=USD&disable-funding=credit"></script>
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <a href="javascript:void(0);"><img class="d-block mx-auto mb-4" src="../assets/img/logo.png" alt="logo" height="100"></a>
                <h2 class="labelSeccion">Invoice payment</h2>
                <!-- <p class="lead lblLetrero">You have 14 days to return your product if not satisfied.</p> -->
            </div>
            <div class="row g-5">
                <div class="col-md-7 col-lg-8">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary labelCart">Your invoice</span>
                    </h4>
                    <embed id="pdfPreview" src="" type="application/pdf" width="100%" height="600px"/>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="mt-md-5" id="paypal-button-container"></div>          
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy; 2021 Intel Atlas</p>
        </footer>
    </div> 

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }),
        lang = "en",
        currentInvoiceId = 0,
        grantotal = 0;

    $(document).ready(function(){
        let queryString = window.location.search,
            urlParams   = new URLSearchParams(queryString);
        currentInvoiceId= urlParams.get('id');

        loadInvoice();
    });

    function loadInvoice(){
        let objData = {
                "_method":"generatePdf",
                "invoiceId": currentInvoiceId
            };

        $.post("../core/controllers/invoice.php", objData, function(result){
            grantotal = result.importeTotal;
            let element = result.htmlBoddy,
                opt     = {
                    margin:       1,
                    filename:     `My invoice ${pad(currentInvoiceId, 5)}`,
                    jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                };

            // html2pdf(element, opt, {
            //     onComplete: function(pdf){
            //         let pdfData = pdf.output('datauristring');
            //         console.log(pdfData);
            //     }
            // });

            html2pdf().from(element, opt).outputPdf().then(function(pdf) {
                $("#pdfPreview").attr("src", `data:application/pdf;base64,${btoa(pdf)}`);
            });
        });
    }

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
</script>

<script>
    paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: parseFloat(grantotal).toFixed(2)
                    }
                }]
            });
        },
        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                if(orderData.status == "COMPLETED"){
                    let objData = {
                        "_method":"_POST",
                        "amount": grantotal,
                        "ship_price": ship_price,
                        "shipping_address": JSON.stringify(orderData.purchase_units[0].shipping.address),
                        "payment_data": JSON.stringify(orderData),
                        "order": JSON.stringify(orderDetails),
                        "coupon": $("#inputCode").val()
                    };

                    $.post("../core/controllers/checkout.php", objData, function(result) {
                        localStorage.removeItem("currentCart");
                        window.location.replace(`../order/index.php?orderId=${result.id}`);
                    });
                }else{
                    alert("Payment was not processed correctly, please try again.");
                }
            });
        }
    }).render('#paypal-button-container');
</script>
  </body>
</html>