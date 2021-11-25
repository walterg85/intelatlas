<?php
    @session_start();
    ob_start();
?>

<style type="text/css">
    .cursor-pointer{
        cursor: pointer !important;
    }

    a.disabled {
      pointer-events: none;
      cursor: default;
    }
</style>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Invoices</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-secondary btnPanel" data-bs-toggle="offcanvas" data-bs-target="#offcanvasInvoice"><i class="bi bi-plus-lg"></i> Add new invoice</button>
        </div>
    </div>
</div>

<table class="table table-striped align-middle" id="invoiceList"></table>

<!-- Panel lateral para agregar nueva factura -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasInvoice" aria-labelledby="offcanvasWithBackdropLabel"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Invoice details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="addInvoiceForm" class="needs-validation" novalidate>
            <input type="hidden" name="invoiceId" id="invoiceId" value="0">
            <input type="hidden" name="estatus" id="estatus" value="1">

            <div class="row">
                <div class="col-6 mb-3">
                    <label for="clientList" class="form-label labelControl1">Client</label>
                    <input class="form-control" list="datalistOptions" id="clientList" placeholder="Type to search...">
                    <datalist id="datalistOptions"></datalist>

                    <div class="mt-3 pnlAdmon d-none">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button type="button" id="btnDeleteInvoice" data-invoiceid="0" class="btn btn-outline-secondary">Delete</button>
                            <button type="button" class="btn btn-outline-secondary" id="btnPrintInvoice">Print</button>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Status
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item btnChangeStatus" data-estatus="1" href="javascript:void(0);" id="opc1">Debt</a></li>
                                    <li><a class="dropdown-item btnChangeStatus" data-estatus="2" href="javascript:void(0);" id="opc2">Paid out</a></li>
                                    <li><a class="dropdown-item btnChangeStatus" data-estatus="3" href="javascript:void(0);" id="opc3">Reversal</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><i class="bi bi-person-fill h4 text-secondary"></i> <texto class="lbl lblNombre"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-at  h5 text-secondary"></i> <texto class="lbl lblEmail"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone-fill h5 text-secondary"></i> <texto class="lbl lblTelefono"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-house-door-fill h5 text-secondary"></i> <texto class="lbl lblDireccion1"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-house-door-fill h5 text-secondary"></i> <texto class="lbl lblDireccion2"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-pin-map-fill h5 text-secondary"></i> <texto class="lbl lblCiudad"></texto></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="inputConcepto" class="form-label labelControl2">Concept</label>
                    <input type="text" id="inputConcepto" name="inputConcepto" class="form-control" autocomplete="off" maxlength="250" required>
                </div>
                <div class="col-2 mb-3">
                    <label for="inputPrecio" class="form-label labelControl3">Price</label>
                    <input type="number" id="inputPrecio" name="inputPrecio" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col-2 mb-3">
                    <label for="inputQuantity" class="form-label labelControl4">Quantity</label>
                    <input type="number" id="inputQuantity" name="inputQuantity" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col-2 mb-3 d-flex align-items-end justify-content-center">
                    <button class="btn btn-success btn-lg" type="button" id="addConcepto">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>

            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th class="labelControl2" scope="col">Concept</th>
                        <th class="labelControl3" scope="col">Price</th>
                        <th class="labelControl4" scope="col">Quantity</th>
                        <th class="labelControl6" scope="col">Amount</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tblConceptos"></tbody>
            </table>

            <div class="row">
                <div class="col">
                    <table class="table w-50 float-end">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Coupon Code" id="inputCode" autocomplete="off">
                                        <button class="btn btn-outline-secondary" type="button" id="applyCoupon">
                                            Apply coupon
                                        </button>
                                    </div>                            
                                </td>
                            </tr>
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

            <div class="d-grid gap-2 my-5">
                <button class="btn btn-success btn-lg" type="button" id="addFactura">
                    <i class="bi bi-check2"></i> Save information
                </button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    var myOffcanvas         = document.getElementById('offcanvasInvoice'),
        dataTableInvoice    = null,
        clienteSeleccionado = 0,
        arrayConcepto       = [],
        importeTotal        = 0,
        objDescuento        = {},
        formatter           = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });

    $(document).ready(function(){
        currentPage = "Invoice";

        // Funcion para resetear el formulario despues de su ultimo uso
        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            $("#invoiceId").val("0");
            $("#estatus").val("1");
            $("#addInvoiceForm")[0].reset();
            $("#addInvoiceForm").removeClass("was-validated");
            $("#tblConceptos").html("");
            $(".lblTotal").html("$0.00");
            $(".lbl ").html("");
            importeTotal = 0;
            arrayConcepto = [];
            $(".pnlAdmon").addClass("d-none");
            $(".filaDescuento").addClass("d-none");
            objDescuento = {};
            $("#clientList, #inputConcepto, #inputPrecio, #inputQuantity, #addConcepto, #inputCode, #applyCoupon").removeAttr("disabled", "disabled");
        });

        // Acciones para los botones principales
        $("#addConcepto").click( addConcept);
        $("#addFactura").click( addFactura);
        $("#btnDeleteInvoice").click( deleteInvoice);
        $("#applyCoupon").click( applyCoupon);

        // Metodo para cambiar el estatus de una factura
        $(".btnChangeStatus").click( function(){
            let estatus = $(this).data("estatus");
            $("#estatus").val(estatus);
        });

        // Cargar clientes
        loadClients();

        // Cargar facturas
        loadInvoices();
    });

    // Metodo para cargar los clientes al inputSearch
    function loadClients(){
        let objData = {
            "_method":"_GET"
        };

        $.post("../core/controllers/client.php", objData, function(result) {
            $("#datalistOptions").html("");
            let options = "";
            $.each( result.data, function(index, item){
                options += `<option data-client="${JSON.stringify(item).replace(/"/g, "'")}" value="${item.nombre.toUpperCase()} ${item.apellido.toUpperCase()}">`;
            });

            $("#datalistOptions").html(options);

            $("input").on('change', function () {
                if(this.value != "" && this.id == "clientList" && $('datalist').find('option[value="'+this.value+'"]')){
                    let option  = $('datalist').find('option[value="'+this.value+'"]'),
                        data    = JSON.parse(option.data("client").replace(/'/g, '"'));

                    $(".lblNombre").html(`${data.nombre} ${data.apellido}`);
                    $(".lblEmail").html(`${data.email}`);
                    $(".lblTelefono").html(`${data.telefono}`);
                    $(".lblDireccion1").html(`${data.direccion_a}`);
                    $(".lblDireccion2").html(`${data.direccion_b}`);
                    $(".lblCiudad").html(`${data.ciudad} ${data.estado} ${data.codigo_postal}`);

                    clienteSeleccionado = data.id;
                }                
            });
        });
    }

    // Metodo para listar todas las facturas
    function loadInvoices(){
        let objData = {
            "_method":"GET"
        };

        if (dataTableInvoice != null)
            dataTableInvoice.destroy();

        $.post("../core/controllers/invoice.php", objData, function(result){
            let mypaging =  false;

            if( (result.data).length > 20 )
                mypaging = true;

            dataTableInvoice = $("#invoiceList").DataTable({
                data: result.data,
                order: [[ 1, "desc" ]],
                columns: [
                    {
                        data: null,
                        orderable: false,
                        class: "text-center botonesOpcion",
                        render: function ( data, type, row )
                        {
                            return `
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btnPublicInvoice" title="View invoice"><i class="bi bi-eye-fill"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btnDownloadPdf" title="View pdf"><i class="bi bi-file-earmark-pdf"></i></a>
                            `;
                        }
                    },
                    {
                        data: 'id',
                        class: 'fw-bolder',
                        render: function(data, type, row){
                            return `<text class="btnEditInvoice cursor-pointer">#${pad(data, 5)}</text>`;
                        }
                    },
                    {
                        data: 'fecha'
                    },
                    {
                        data: 'clientName'
                    },
                    {
                        data: 'estatus',
                        render: function(data, type, row){
                            return (data == 1) ? '<text class="text-danger">Debt</text>' : (data == 2) ? '<text class="text-success">Paid out</text>' : '<text class="text-warning">Refound</text>';
                        }
                    },
                    {
                        data: 'importe',
                        class: 'text-danger',
                        render: function(data, type, row){
                            return formatter.format(data);
                        }
                    }
                ],
                "fnDrawCallback":function(oSettings){
                    $("#invoiceList thead").remove();

                    $(".btnEditInvoice").unbind().click(function(){
                        let data = getData($(this), dataTableInvoice);

                        clienteSeleccionado = data.client_id;
                        arrayConcepto       = JSON.parse(data.detalles);
                        objDescuento        = (data.cupon) ? JSON.parse(data.cupon) : {};
                        importeTotal        = data.importe;

                        $("#clientList")
                            .val(data.clientName.toUpperCase())
                            .trigger('change');

                        $("#btnDeleteInvoice").data("invoiceid", data.id);
                        $("#estatus").val(data.estatus);
                        $("#invoiceId").val(data.id);

                        if(data.estatus == 2){
                            $("#clientList, #inputConcepto, #inputPrecio, #inputQuantity, #addConcepto, #inputCode, #applyCoupon").attr("disabled", "disabled");
                        }

                        $(".pnlAdmon").removeClass("d-none");
                        listarConceptos(data.estatus);

                        $(".btnPanel").click();
                    });

                    $(".btnDownloadPdf").unbind().click( function(){
                        let objData = {
                                "_method":"generatePdf"
                            };

                        $.post("../core/controllers/invoice.php", objData, function(result){
                            console.log(result);
                        });
                    });

                    $("#invoiceList tbody tr").find(".botonesOpcion").css("width", "110px");
                },
                searching: false,
                pageLength: 20,
                info: false,
                lengthChange: false,
                paging: mypaging
            });
        });
    }

    // Metodo para agregar nuevos conceptos al areglo
    function addConcept(){
        let concepto    = $("#inputConcepto").val(),
            precio      = $("#inputPrecio").val(),
            cantidad    = $("#inputQuantity").val();

        if(concepto.trim() != "" && precio.trim() != "" && cantidad.trim() != ""){
            let objItm = {
                concepto:concepto,
                precio:precio,
                cantidad:cantidad
            };

            arrayConcepto.push(objItm);
            listarConceptos(0);           

            $("#inputConcepto").val("");
            $("#inputPrecio").val("");
            $("#inputQuantity").val("");
            $("#inputConcepto").focus();
        }
    }

    // Metodo para almacenar la factura en base de datos
    function addFactura(){
        // se bloqueda el boton para evitar doble accion
        $("#addFactura").attr("disabled","disabled");
        $("#addFactura").html('<i class="bi bi-clock-history"></i> Saving...');

        let form        = $("#addInvoiceForm")[0],
            formData    = new FormData(form);

        formData.append("_method", "POST");
        formData.append("clienteSeleccionado", clienteSeleccionado);
        formData.append("arrayConcepto", JSON.stringify(arrayConcepto));
        formData.append("importeTotal", importeTotal);
        formData.append("cupon", JSON.stringify(objDescuento));

        var request = new XMLHttpRequest();
        request.open("POST", "../core/controllers/invoice.php");
        request.send(formData);
        
        $("#addFactura").removeAttr("disabled");
        $("#addFactura").html('<i class="bi bi-check2"></i> Save information');

        $(".btnPanel").click();
        loadInvoices();
    }

    // Metodo para eliminar una factura
    function deleteInvoice(){
        let invoiceId   = $(this).data("invoiceid"),
            buton       = $(this);

        if (confirm(`You want to delete this invoice (#${pad(invoiceId,5)})?`)){
            buton.attr("disabled","disabled");
            buton.html('<i class="bi bi-clock-history"></i>');

            let objData = {
                "_method":"Delete",
                "invoiceId": invoiceId
            };

            $.post("../core/controllers/invoice.php", objData, function(result) {
                buton.removeAttr("disabled");
                buton.html('Delete');

                loadInvoices();
                $(".btnPanel").click();
            });

        }
    }

    // Metodo para dibujar en la tabla los conceptos agregados
    function listarConceptos(estadoInvoice){
        let filas = "";

        $("#tblConceptos").html("");
        importeTotal = 0;

        // Se recore el contenido del array de conceptos
        $.each(arrayConcepto, function(index, item){
            filas += `
                <tr>
                    <td>${index +1}</td>
                    <td>${item.concepto}</td>
                    <td class="text-end">${formatter.format(item.precio)}</td>
                    <td class="text-end">${item.cantidad}</td>
                    <td class="text-end">${formatter.format(parseFloat(item.precio) * parseFloat(item.cantidad))}</td>
                    <td class="text-center">
                        <a href="javascript:void(0);" data-index="${index}" class="btn btn-outline-danger btn-sm btnDeleteCocept me-2 ${(estadoInvoice == 2) ? 'disabled' : ''}" title="Delete"><i class="bi bi-trash"></i></a>
                        <a href="javascript:void(0);" data-index="${index}" class="btn btn-outline-warning btn-sm btnModifyConcept ${(estadoInvoice == 2) ? 'disabled' : ''}" title="Modify"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
            `;

            importeTotal += parseFloat(item.precio) * parseFloat(item.cantidad);
        });

        if('cupon' in objDescuento){
            let fDescuento = 0;
            if(objDescuento.tipo == 1){
                fDescuento = parseFloat(objDescuento.importe) * importeTotal;
            }else{
                fDescuento = parseFloat(objDescuento.importe);
            }
            
            importeTotal = importeTotal - fDescuento;

            $(".filaDescuento").removeClass("d-none");
            $(".lblDescuento").html(formatter.format(fDescuento));
            $(".labelMontoDescuento").html(`Discount ${objDescuento.valor}`);
        }else{
            $(".filaDescuento").addClass("d-none");
        }

        // Se agrega el contenido del HTML en el body de la tabla contenedora
        $("#tblConceptos").append(filas);
        $(".lblTotal").html(formatter.format(importeTotal));

        // Accion del boton para eliminar un elemento del array y redibujar la tabla
        $(".btnDeleteCocept").unbind().click( function(){
            let index = $(this).data("index");
            arrayConcepto.splice(index, 1);
            listarConceptos(0);
        });

        // Accion para setear los valores de un elemento del array, eliminarlo para poder coregirlos y redibujar la tabla
        $(".btnModifyConcept").unbind().click( function(){
            let index = $(this).data("index"),
                concepto = arrayConcepto[index];

            $("#inputConcepto").val(concepto.concepto);
            $("#inputPrecio").val(concepto.precio);
            $("#inputQuantity").val(concepto.cantidad);

            arrayConcepto.splice(index, 1);
            listarConceptos(0);
        });
    }

    // Metodo para cambiar de idioma la pagina
    function changePageLang(myLang) {
        $(".lblNamePage").html(myLang.pageTitle);
        $(".btnPanel").html(`<i class="bi bi-plus-lg"></i> ${myLang.buton1}`);
        $("#offcanvasWithBackdropLabel").html(myLang.panel1);
        $("#addFactura").html(`<i class="bi bi-check2"></i> ${myLang.buton2}`);
        $(".labelControl1").html(myLang.labelControl1);
        $(".labelControl2").html(myLang.labelControl2);
        $(".labelControl3").html(myLang.labelControl3);
        $(".labelControl4").html(myLang.labelControl4);
        $("#clientList").attr("placeholder", myLang.labelControl5);
        $(".labelControl6").html(myLang.labelControl6);
        $("#inputCode").attr("placeholder", myLang.labelControl7);

        $("#btnDeleteInvoice").html(myLang.buton3);
        $("#btnGroupDrop1").html(myLang.buton4);
        $("#btnPrintInvoice").html(myLang.buton5);
        $("#applyCoupon").html(myLang.buton6);

        $("#opc1").html(myLang.opc1);
        $("#opc2").html(myLang.opc2);
        $("#opc3").html(myLang.opc3);
    }

    // Metodo para aplicar cupon de descuento
    function applyCoupon(){
        let objData = {
            "_method":"GetCoupon",
            "code": $("#inputCode").val()
        };

        $.post("../core/controllers/checkout.php", objData, function(result) {
            if(result.data){
                let codigo = result.data;

                objDescuento.cupon =  $("#inputCode").val();
                objDescuento.id    = codigo.id;
                objDescuento.tipo  = codigo.tipo;

                if(codigo.tipo == 1){
                    objDescuento.importe    = parseFloat( codigo.valor / 100).toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
                    objDescuento.valor      = `${codigo.valor}%`;
                }else{
                    objDescuento.importe    = parseFloat( codigo.valor );
                    objDescuento.valor      = formatter.format(codigo.valor);
                }                    
            }else{
                objDescuento = {};
                $("#inputCode").val("");
                alert("This coupon does not exist.");
            }

            listarConceptos(0);
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>