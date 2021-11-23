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
    });

    

    function changePageLang(argument) {
        console.log(argument);
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>