<?php
    @session_start();
    ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Reports</h1>
</div>

<div class="row row-cols-1 row-cols-md-2 g-4">
    <div class="col">
        <div class="card">
            <h5 class="card-header">
                Total sales in <texto id="anioPasado"></texto>
            </h5>
            <div class="card-body">
                <h6>Total sales: <texto id="anioPasadoSales"></texto></h6>
                <h6>Total in debt <texto id="anioPasadoDebt"></texto></h6>
                <h6>Total received <texto id="anioPasadoReceived"></texto></h6>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <h5 class="card-header">
                Total sales in <texto id="anioActual"></texto>
            </h5>
            <div class="card-body">
                <h6>Total sales: <texto id="anioActualSales"></texto></h6>
                <h6>Total in debt <texto id="anioActualDebt"></texto></h6>
                <h6>Total received <texto id="anioActualReceived"></texto></h6>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <h5 class="card-header">
                Total sales in <texto id="mesActual"></texto>
            </h5>
            <div class="card-body">
                <h6>Total sales: <texto id="mesActualSales"></texto></h6>
                <h6>Total in debt <texto id="mesActualDebt"></texto></h6>
                <h6>Total received <texto id="mesActualReceived"></texto></h6>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <h5 class="card-header">
                Total sales in the current week <texto id="semanaActual"></texto>
            </h5>
            <div class="card-body">
                <h6>Total sales: <texto id="semanaActualSales"></texto></h6>
                <h6>Total in debt <texto id="semanaActualDebt"></texto></h6>
                <h6>Total received <texto id="semanaActualReceived"></texto></h6>
            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    var anioActual = 0,
        anioPasado = 0,
        mesActual = 0,
        semanaActual = 0,
        arrMes = {
            "en": ["January","February","March","April","May","June","July", "August","September","October","November","December"],
            "es": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
        },
        currentDate = new Date(),
        formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });

    $(document).ready(function(){
    });

    function changePageLang(){
        anioActual = currentDate.getFullYear();
        anioPasado = anioActual -1;

        mesActual = currentDate.getMonth();

        $("#anioPasado").html(anioPasado);
        $("#anioActual").html(anioActual);
        $("#mesActual").html(arrMes[lang][mesActual]);

        getResumen();
    }

    function getResumen(){
        let _Data = {
            "_method": "getResumen",
            "anioPasado": anioPasado,
            "anioActual": anioActual
        };

        $.post("../core/controllers/report.php", _Data, function(result){
            let data = result.data;

            if(data.anioPasado.venta_total){
                $("#anioPasadoSales").html(formatter.format(data.anioPasado.venta_total));
                $("#anioPasadoDebt").html("$0.00");
                $("#anioPasadoReceived").html("$0.00");
            }else{
                $("#anioPasadoSales").html("$0.00");
                $("#anioPasadoDebt").html("$0.00");
                $("#anioPasadoReceived").html("$0.00");
            }

            if(data.anioActual.venta_total){
                $("#anioActualSales").html(formatter.format(data.anioActual.venta_total));
                $("#anioActualDebt").html("$0.00");
                $("#anioActualReceived").html("$0.00");
            }else{
                $("#anioActualSales").html("$0.00");
                $("#anioActualDebt").html("$0.00");
                $("#anioActualReceived").html("$0.00");
            }

            
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>