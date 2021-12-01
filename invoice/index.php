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
                    <div class="row">
                        <div class="col-6 mb-3">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td><i class="bi bi-person-fill h4 text-secondary"></i> <texto class="lbl lblNombre"></texto></td>
                                    </tr>
                                    <tr>
                                        <td class="d-none"><i class="bi bi-at  h5 text-secondary"></i> <texto class="lbl lblEmail"></texto></td>
                                    </tr>
                                    <tr>
                                        <td class="d-none"><i class="bi bi-telephone-fill h5 text-secondary"></i> <texto class="lbl lblTelefono"></texto></td>
                                    </tr>
                                    <tr>
                                        <td class="d-none"><i class="bi bi-house-door-fill h5 text-secondary"></i> <texto class="lbl lblDireccion1"></texto></td>
                                    </tr>
                                    <tr>
                                        <td class="d-none"><i class="bi bi-house-door-fill h5 text-secondary"></i> <texto class="lbl lblDireccion2"></texto></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-pin-map-fill h5 text-secondary"></i> <texto class="lbl lblCiudad"></texto></td>
                                    </tr>
                                    <tr>
                                        <td class="d-none"><i class="bi bi-check h5 text-secondary"></i> <texto class="lbl lblExtra"></texto></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th class="labelControl2" scope="col">Concept</th>
                                        <th class="labelControl3" scope="col">Price</th>
                                        <th class="labelControl4" scope="col">Quantity</th>
                                        <th class="labelControl6" scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tblConceptos"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <table class="table w-50 float-end">
                                <tbody>
                                    <tr class="filaDescuento d-none">
                                        <td class="text-end text-dark labelMontoDescuento">Discount</td>
                                        <td class="lblDescuento text-end">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end h4 text-dark">Total</td>
                                        <td class="lblTotal text-end text-danger h3">$0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="mt-md-5" id="paypal-button-container"></div>
                    <div class="d-grid gap-2 mt-2">
                        <button class="btn btn-danger btn-lg" type="button" id="downLoadPdf">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </button>

                        <img src="https://practifinanzas.com/wp-content/uploads/2019/12/1912-01-FacturaInstant.jpg" id="imgLateral" class="img-fluid d-none">
                    </div>
                </div>
            </div>
            <div class="myInvoice d-none"></div>
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
        currentInvoiceId = 0;

    $(document).ready(function(){
        let queryString = window.location.search,
            urlParams   = new URLSearchParams(queryString);
        currentInvoiceId= urlParams.get('id');

        loadInvoice();
    });

    function loadInvoice(){
        let objData = {
                "_method":"generatePdf",
                "invoiceId": currentInvoiceId,
                "lang": lang
            };

        $.post("../core/controllers/invoice.php", objData, function(result){
            // Recuperar el importe a cobrar
            grantotal   = result.importeTotal;

            // Cargar el contenido en el div maestro
            $(".myInvoice").html(result.htmlBoddy);

            // Pintar informacion del cliente
            let data = result.allData.clientData;

            $(".lblNombre").html(`${data.nombre} ${data.apellido}`).parent().removeClass("d-none");

            if( (data.email).length > 0 )
                $(".lblEmail")
                    .html(`${data.email}`)
                    .parent().removeClass('d-none');

            if( (data.telefono).length > 0 )
                $(".lblTelefono")
                    .html(`${data.telefono}`)
                    .parent().removeClass('d-none');

            if( (data.direccion_a).length > 0 )
                $(".lblDireccion1")
                    .html(`${data.direccion_a}`)
                    .parent().removeClass('d-none');

            if( (data.direccion_b).length > 0 )
                $(".lblDireccion2")
                    .html(`${data.direccion_b}`)
                    .parent().removeClass('d-none');

            $(".lblCiudad").html(`${data.ciudad} ${data.estado} ${data.codigo_postal}`).parent().removeClass("d-none");

            if( (data.adicional).length > 0 )
                $(".lblExtra")
                    .html(`${data.adicional}`)
                    .parent().removeClass('d-none');

            // Pintar los conceptos
            let filas           = "",
                importeTotal    = 0,
                objDescuento    = null;
                
            data                = result.allData.invoiceData;

            $("#tblConceptos").html("");            

            // Se recore el contenido del array de conceptos
            $.each( JSON.parse(data.detalles), function(index, item){
                filas += `
                    <tr>
                        <td>${index +1}</td>
                        <td>${item.concepto}</td>
                        <td class="text-end">${formatter.format(item.precio)}</td>
                        <td class="text-end">${item.cantidad}</td>
                        <td class="text-end">${formatter.format(parseFloat(item.precio) * parseFloat(item.cantidad))}</td>
                    </tr>
                `;

                importeTotal += parseFloat(item.precio) * parseFloat(item.cantidad);
            });

            // Validacion para mostrar los descuentos que tiene aplicado            
            objDescuento = (data.cupon != "") ? JSON.parse(data.cupon) : {};
            if('cupon' in objDescuento){
                let fDescuento = 0;
                if(objDescuento.tipo == 1){
                    fDescuento = parseFloat(objDescuento.importe) * importeTotal;
                }else{
                    fDescuento = parseFloat(objDescuento.importe);
                }

                $(".filaDescuento").removeClass("d-none");
                $(".lblDescuento").html(formatter.format(fDescuento));
                $(".labelMontoDescuento").html(`Discount ${objDescuento.valor}`);
            }else{
                $(".filaDescuento").addClass("d-none");
            }

            // Dibujar todo el contenido
            $("#tblConceptos").append(filas);
            $(".lblTotal").html(formatter.format(data.importe));

            // Activar evento para descargar el pdf
            $("#downLoadPdf").click( function(){
                let element = $(".myInvoice").html(),
                    opt     = {
                        margin:       1,
                        filename:     `My invoice ${pad(currentInvoiceId, 5)}`,
                        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };

                html2pdf(element, opt);
            });

            // Si la factura ya esta pagada o fue un reembolso no se muestra ni inica el boton de paypay
            if(data.estatus == 1){
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
                                    "_method":"invoicePaymen",
                                    "invoiceId": currentInvoiceId,
                                    "payload": JSON.stringify(orderData)
                                };

                                $.post("../core/controllers/invoice.php", objData, function(result) {
                                    // Se recarga la pagina para actualizar el estatus de la factura
                                    location.reload();
                                });
                            }else{
                                alert("Payment was not processed correctly, please try again.");
                            }
                        });
                    }
                }).render('#paypal-button-container');
            } else {
                // Se oculta los controles de paypal
                $("#paypal-button-container").addClass("d-none");

                // Se muestra una fotografia de bajo del boton de descarga pdf
                $("#imgLateral").removeClass("d-none");
            }
        });
    }

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
</script>
</body>
</html>