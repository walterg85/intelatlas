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
    <button type="button" class="btnPanelNotes d-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotes">Show notes</button>
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

<!-- Panel lateral para ver o agregar notas del prospecto -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotes" aria-labelledby="offcanvasWithBackdropLabel3"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel3">Leads notes</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Leave a notes here" id="txtNotes" style="height: 100px"></textarea>
            <label for="txtNotes">Leave a notes here</label>
        </div>
        <div class="row justify-content-end mb-3">
            <div class="col-3 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-success" id="btnAddNote" data-clientid="0">Add note</button>
            </div>
        </div>

        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th class="labelControl1" scope="col">Note</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="tblNotes"></tbody>
        </table>
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

        $("#btnAddNote").click( function(){
            if($("#txtNotes").val() != ""){
                let strNote = $("#txtNotes").val(),
                    idCliente = $("#btnAddNote").data("clientid"),
                    objData = {
                        "_method":"addNotes",
                        "note": strNote,
                        "idCliente": idCliente
                    };

                $.post("../core/controllers/client.php", objData, function(result){
                    fnMostrarNotas(idCliente);
                    $("#txtNotes").val("");
                });
            }
        });
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
                                <a href="javascript:void(0);" class="btn btn-outline-warning btnModifyLead" title="Modify"><i class="bi bi-arrow-left-right"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btnNotas" title="Add note"><i class="bi bi-list-check"></i></a>
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

                    $(".btnModifyLead").unbind().click(function(){
                        let data = getData($(this), dataTableLead),
                            buton = $(this);

                        if (confirm(`You want to change this lead (${data.nombre}) to client?`)){
                            buton.attr("disabled","disabled");
                            buton.html('<i class="bi bi-clock-history"></i>');

                            let objData = {
                                "_method":"translate",
                                "clientId": data.id
                            };

                            $.post("../core/controllers/client.php", objData, function(result) {
                                buton.removeAttr("disabled");
                                buton.html('<i class="bi bi-arrow-left-right"></i>');

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

                    $(".btnNotas").unbind().click(function(){
                        let data = getData($(this), dataTableLead);
                        $("#btnAddNote").attr("data-clientid", data.id);

                        $(".btnPanelNotes").click();
                        fnMostrarNotas(data.id);
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

    function fnMostrarNotas(idCliente){
        let objData = {
                "_method":"getNotes",
                "idCliente": idCliente
            };

        $.post("../core/controllers/client.php", objData, function(result){
            let filas = "";

            $("#tblNotes").html("");

            // Se recore el contenido del array de notas
            $.each( result.data, function(index, item){
                filas += `
                    <tr>
                        <td>${index +1}</td>
                        <td>${item.nota}</td>
                        <td class="text-center">
                            <a href="javascript:void(0);" data-id="${item.id}" class="btn btn-outline-danger btn-sm btnDeleteNote me-2" title="Delete"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                `;
            });

            $("#tblNotes").append(filas);

            $(".btnDeleteNote").unbind().click( function(){
                let objData = {
                    "_method":"deleteNotes",
                    "id": $(this).data("id")
                };

                $.post("../core/controllers/client.php", objData, function(result){
                    fnMostrarNotas(idCliente);
                });
            });
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>