<?php
    @session_start();
    ob_start();
?>

<style type="text/css">
    .cursor-pointer{
        cursor: pointer !important;
    }
</style>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Leads</h1>
    <button type="button" class="btnPanelDetalle d-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDetail">Show details</button>
</div>

<table class="table table-striped align-middle" id="leadsList"></table>

<!-- Panel lateral para ver los detalles del prospecto -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDetail" aria-labelledby="offcanvasWithBackdropLabel2"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel2">Leads details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-8 mb-3">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td><i class="bi bi-person-fill h4 text-secondary me-2"></i> <texto class="lbl lblNombre"></texto></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-at  h5 text-secondary me-2"></i> <texto class="lbl lblEmail"></texto></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-telephone-fill h5 text-secondary me-2"></i> <texto class="lbl lblTelefono"></texto></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-house-door-fill h5 text-secondary me-2"></i> <texto class="lbl lblDireccion1"></texto></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-house-door-fill h5 text-secondary me-2"></i> <texto class="lbl lblDireccion2"></texto></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-pin-map-fill h5 text-secondary me-2"></i> <texto class="lbl lblCiudad"></texto></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>      
    </div>
</div>

<script type="text/javascript">
    var dataTableLead = null,
        formatter       = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });

    $(document).ready(function(){
        currentPage = "Leads";

        loadLeads();
    });

    function loadLeads(){
        let objData = {
            "_method":"_Getleads"
        };

        if (dataTableLead != null)
            dataTableLead.destroy();

        $.post("../core/controllers/client.php", objData, function(result) {
            let mypaging =  false;

            if( (result.data).length > 20 )
                mypaging = true;

            dataTableLead = $("#leadsList").DataTable({
                data: result.data,
                order: [[ 0, "desc" ]],
                columns: [
                    {
                        data: 'id',
                        width: "20px",
                        render: function(data, type, row){
                            return pad(data, 5);
                        }
                    },
                    {
                        data: 'nombre',
                        class: 'fw-bolder',
                        render: function(data, type, row){
                            return `<text class="btnDetailLead cursor-pointer">${data}</text>`;
                        }
                    },
                    {
                        data: 'apellido'
                    },
                    {
                        data: 'telefono'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: null,
                        orderable: false,
                        class: "text-center",
                        width: "200px",
                        render: function ( data, type, row ){
                            return `
                                <a href="javascript:void(0);" class="btn btn-outline-danger btnDeleteLead" title="Delete"><i class="bi bi-trash"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-warning btnModifyLead" title="Modify"><i class="bi bi-pencil"></i></a>
                            `;
                        }
                    }
                ],
                "fnDrawCallback":function(oSettings){
                    $("#leadsList thead").remove();

                    $(".btnDeleteLead").unbind().click(function(){
                        let data = getData($(this), dataTableLead),
                            buton = $(this);

                        if (confirm(`You want to delete this lead (${data.nombre})?`)){
                            buton.attr("disabled","disabled");
                            buton.html('<i class="bi bi-clock-history"></i>');

                            let objData = {
                                "_method":"Delete",
                                "clientId": data.id
                            };

                            $.post("../core/controllers/client.php", objData, function(result) {
                                buton.removeAttr("disabled");
                                buton.html('<i class="bi bi-trash"></i>');

                                loadLeads();
                            });

                        }
                    });

                    $(".btnDetailLead").unbind().click(function(){
                        let data = getData($(this), dataTableLead);

                        $(".lblNombre").html(`${data.nombre} ${data.apellido}`);
                        $(".lblEmail").html(`${data.email}`);
                        $(".lblTelefono").html(`${data.telefono}`);
                        $(".lblDireccion1").html(`${data.direccion_a}`);
                        $(".lblDireccion2").html(`${data.direccion_b}`);
                        $(".lblCiudad").html(`${data.ciudad} ${data.estado} ${data.codigo_postal}`);

                        $(".btnPanelDetalle").click();
                    });
                },
                searching: false,
                pageLength: 20,
                info: false,
                lengthChange: false,
                paging: mypaging
            });
        });
    }

    function changePageLang(myLang) {
        $(".lblNamePage").html(myLang.pageTitle);
        $("#offcanvasWithBackdropLabel2").html(myLang.panel2);

        $(".labelName").html(myLang.labelName);
        $(".labelLastname").html(myLang.labelLastname);
        $(".labelMail").html(myLang.labelMail);
        $(".labelPhone").html(myLang.labelPhone);
        $(".labelAddress").html(myLang.labelAddress);
        $(".labelAddress2").html(myLang.labelAddress2);
        $(".labelCity").html(myLang.labelCity);
        $(".labelState").html(myLang.labelState);
        $(".labelZip").html(myLang.labelZip);
        $(".labelOtionalInfo").html(myLang.labelOtionalInfo);
    }    
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>