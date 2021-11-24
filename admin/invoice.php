<?php
    @session_start();
    ob_start();
?>

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
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Add a new invoice</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="addClientForm" class="needs-validation" novalidate>
            <input type="hidden" name="invoiceId" id="invoiceId" value="0">

            <div class="row">
                <div class="col-6 mb-3">
                    <label for="clientList" class="form-label">Client</label>
                    <input class="form-control" list="datalistOptions" id="clientList" placeholder="Type to search...">
                    <datalist id="datalistOptions"></datalist>                    
                </div>
                <div class="col-6">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><i class="bi bi-person-fill h4 text-secondary"></i> <texto class="lblNombre"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone-fill h5 text-secondary"></i> <texto class="lblTelefono"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-house-door-fill h5 text-secondary"></i> <texto class="lblDireccion1"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-house-door-fill h5 text-secondary"></i> <texto class="lblDireccion2"></texto></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-pin-map-fill h5 text-secondary"></i> <texto class="lblCiudad"></texto></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col mb-3 pnlAdmon d-none">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-secondary">Delete</button>
                        <button type="button" class="btn btn-secondary">Print</button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Status
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#">Debt</a></li>
                                <li><a class="dropdown-item" href="#">Paid out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="inputConcepto" class="form-label labelCancepto">Concept</label>
                    <input type="text" id="inputConcepto" name="inputConcepto" class="form-control" autocomplete="off" maxlength="250" required>
                </div>
                <div class="col-2 mb-3">
                    <label for="inputPrecio" class="form-label labelPrecio">Price</label>
                    <input type="text" id="inputPrecio" name="inputPrecio" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col-2 mb-3">
                    <label for="inputQuantity" class="form-label labelQuantity">Quantity</label>
                    <input type="text" id="inputQuantity" name="inputQuantity" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col-2 mb-3 d-flex align-items-end justify-content-center">
                    <button class="btn btn-success btn-lg" type="button" id="addClient">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>

            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Concept</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody id="tblConceptos"></tbody>
            </table>

            <table class="table w-50 float-end">
                <tbody>
                    <tr>
                        <td class="text-end h4 text-dark">Total</td>
                        <td class="lblTotal text-end text-danger h3">$0.00</td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>


<script type="text/javascript">
    var myOffcanvas     = document.getElementById('offcanvasInvoice'),
        dataTableClient = null;

    $(document).ready(function(){
        currentPage = "Invoice";

        myOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            $("#invoiceId").val("0");
            $("#addInvoiceForm")[0].reset();
            $("#addInvoiceForm").removeClass("was-validated");
        });

        loadClients();
    });

    function loadClients(){
        let objData = {
            "_method":"_GET"
        };

        if (dataTableClient != null)
            dataTableClient.destroy();

        $.post("../core/controllers/client.php", objData, function(result) {
            $("#datalistOptions").html("");
            let options = "";
            $.each( result.data, function(index, item){
                options += `<option data-client="${JSON.stringify(item).replace(/"/g, "'")}" value="${item.nombre.toUpperCase()} ${item.apellido.toUpperCase()}">`;
            });

            $("#datalistOptions").html(options);

            $("input").on('input', function () {
                if(this.value != "" && $('datalist').find('option[value="'+this.value+'"]')){
                    let option  = $('datalist').find('option[value="'+this.value+'"]'),
                        data    = JSON.parse(option.data("client").replace(/'/g, '"'));

                    $(".lblNombre").html(`${data.nombre} ${data.apellido}`);
                    $(".lblTelefono").html(`${data.telefono}`);
                    $(".lblDireccion1").html(`${data.direccion_a}`);
                    $(".lblDireccion2").html(`${data.direccion_b}`);
                    $(".lblCiudad").html(`${data.ciudad} ${data.estado} ${data.codigo_postal}`);
                }                
            });

        });
    }

    

    function changePageLang(argument) {
        console.log(argument);
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>