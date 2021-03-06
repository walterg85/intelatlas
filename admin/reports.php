<?php
    @session_start();
    ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom seccionHeader">
    <h1 class="h2 lblNamePage">Reports</h1>
</div>

<div class="row row-cols-1 row-cols-md-2 g-4 mb-3 secseccionBody">
    <div class="col">
        <div class="card">
            <h5 class="card-header">
                <texto class="labelUno">Total sales in</texto> <texto id="anioActual"></texto>
            </h5>
            <div class="card-body">
                <h6><texto class="labelTres">Total sales:</texto> <texto id="anioActualSales"></texto></h6>
                <h6><texto class="labelCuatro">Total in debt:</texto> <texto id="anioActualDebt"></texto></h6>
                <h6><texto class="labelCinco">Total received:</texto> <texto id="anioActualReceived"></texto></h6>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <h5 class="card-header">
                <texto class="labelUno">Total sales in</texto> <texto id="mesActual"></texto>
            </h5>
            <div class="card-body">
                <h6><texto class="labelTres">Total sales:</texto> <texto id="mesActualSales"></texto></h6>
                <h6><texto class="labelCuatro">Total in debt</texto> <texto id="mesActualDebt"></texto></h6>
                <h6><texto class="labelCinco">Total received:</texto> <texto id="mesActualReceived"></texto></h6>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <h5 class="card-header">
                <texto class="labelDos">Total sales in the current week</texto> <texto id="semanaActual"></texto>
            </h5>
            <div class="card-body">
                <h6><texto class="labelTres">Total sales:</texto> <texto id="semanaActualSales"></texto></h6>
                <h6><texto class="labelCuatro">Total in debt:</texto> <texto id="semanaActualDebt"></texto></h6>
                <h6><texto class="labelCinco">Total received:</texto> <texto id="semanaActualReceived"></texto></h6>
            </div>
        </div>
    </div>
</div>

<div class="row secseccionBody">
    <div class="col-6">
        <p class="lead mb-0 chartA">Total sales in the current year</p>
        <canvas class="my-4 w-100" id="myChartA"></canvas>
    </div>
    <div class="col-6">
        <p class="lead mb-0 chartB">Total sales in the current month</p>
        <canvas class="my-4 w-100" id="myChartB"></canvas>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 g-4 mb-3 secseccionBody">
    <div class="col">
        <div class="card">
            <h5 class="card-header">
                <texto class="labelUno">Total sales in</texto> <texto id="anioPasado"></texto>
            </h5>
            <div class="card-body">
                <h6><texto class="labelTres">Total sales:</texto> <texto id="anioPasadoSales"></texto></h6>
                <h6><texto class="labelCuatro">Total in debt:</texto> <texto id="anioPasadoDebt"></texto></h6>
                <h6><texto class="labelCinco">Total received:</texto> <texto id="anioPasadoReceived"></texto></h6>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script type="text/javascript">
    var anioActual      = 0,
        anioPasado      = 0,
        mesActual       = 0,
        semanaActual    = 0,
        arrMes          = {
            "en": ["January","February","March","April","May","June","July", "August","September","October","November","December"],
            "es": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
        },
        currentDate     = new Date(),
        formatter       = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        });

    Date.prototype.getWeekNumber = function () {
        let d = new Date(+this);
        d.setHours(0, 0, 0, 0);
        d.setDate(d.getDate() + 4 - (d.getDay() || 7));
        return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
    }

    $(document).ready(function(){
        currentPage = "Reports";
    });

    function changePageLang(myLang){
        anioActual  = currentDate.getFullYear();
        anioPasado  = anioActual -1;
        mesActual   = currentDate.getMonth();

        $("#anioPasado").html(anioPasado);
        $("#anioActual").html(anioActual);
        $("#mesActual").html(arrMes[lang][mesActual]);

        getResumen();

        $(".lblNamePage").html(myLang.lblNamePage);
        $(".chartA").html(myLang.chartA);
        $(".chartB").html(myLang.chartB);
        $(".labelUno").html(myLang.labelUno);
        $(".labelDos").html(myLang.labelDos);
        $(".labelTres").html(myLang.labelTres);
        $(".labelCuatro").html(myLang.labelCuatro);
        $(".labelCinco").html(myLang.labelCinco);
    }

    function getResumen(){
        let ultimoDiaMes    = new Date(anioActual, currentDate.getMonth() + 1, 0),
            semanaActual    = new Date().getWeekNumber(),
            primerDiaSemana = new Date(anioActual, 0, (semanaActual - 1) * 7 + 1),
            _Data           = {
                "_method": "getResumen",
                "anioPasado": anioPasado,
                "anioActual": anioActual,
                "mesActual": pad(mesActual + 1, 2),
                "ultimoDiaMes": ultimoDiaMes.getDate(),
                "primerDiaSemana": primerDiaSemana.getDate(),
                "ultimoDiaSemana": currentDate.getDate()
            };

        $.post("../core/controllers/report.php", _Data, function(result){
            let data = result.data;

            // Vaciar resultados para el mes actual
            let venta_paypal    = (data.anioActual.venta_total) ? parseFloat(data.anioActual.venta_total) : 0,
                venta_facturas  = (data.anioActual.venta_factura) ? parseFloat(data.anioActual.venta_factura) : 0,
                adeudos         = (data.anioActual.adeudos) ? parseFloat(data.anioActual.adeudos) : 0;

            $("#anioActualSales").html(formatter.format( venta_paypal + venta_facturas ));
            $("#anioActualDebt").html(formatter.format( adeudos ));
            $("#anioActualReceived").html(formatter.format( (venta_paypal + venta_facturas) - adeudos ));

            // Vaciar resultados para el a??o anterior
            venta_paypal    = (data.anioPasado.venta_total) ? parseFloat(data.anioPasado.venta_total) : 0,
            venta_facturas  = (data.anioPasado.venta_factura) ? parseFloat(data.anioPasado.venta_factura) : 0,
            adeudos         = (data.anioPasado.adeudos) ? parseFloat(data.anioPasado.adeudos) : 0;

            $("#anioPasadoSales").html(formatter.format( venta_paypal + venta_facturas ));
            $("#anioPasadoDebt").html(formatter.format( adeudos ));
            $("#anioPasadoReceived").html(formatter.format( (venta_paypal + venta_facturas) - adeudos ));

            // Vaciar resultados para el mes actual
            venta_paypal    = (data.mesActual.venta_total) ? parseFloat(data.mesActual.venta_total) : 0,
            venta_facturas  = (data.mesActual.venta_factura) ? parseFloat(data.mesActual.venta_factura) : 0,
            adeudos         = (data.mesActual.adeudos) ? parseFloat(data.mesActual.adeudos) : 0;

            $("#mesActualSales").html(formatter.format( venta_paypal + venta_facturas ));
            $("#mesActualDebt").html(formatter.format( adeudos ));
            $("#mesActualReceived").html(formatter.format( (venta_paypal + venta_facturas) - adeudos ));

            // Vaciar resultados para la semana actual
            venta_paypal    = (data.semanaActual.venta_total) ? parseFloat(data.semanaActual.venta_total) : 0,
            venta_facturas  = (data.semanaActual.venta_factura) ? parseFloat(data.semanaActual.venta_factura) : 0,
            adeudos         = (data.semanaActual.adeudos) ? parseFloat(data.semanaActual.adeudos) : 0;

            $("#semanaActualSales").html(formatter.format( venta_paypal + venta_facturas ));
            $("#semanaActualDebt").html(formatter.format( adeudos ));
            $("#semanaActualReceived").html(formatter.format( (venta_paypal + venta_facturas) - adeudos ));

            // Imprimir grafica
            printChart(result.dataMes, result.dataDia, ultimoDiaMes.getDate());
        });
    }

    function printChart(dataYear, dataDays, lastDay){
        // Graphs year
        let canvaA   = document.getElementById('myChartA'),
            myChartA = new Chart(canvaA, {
                type: 'line',
                data: {
                    labels: arrMes[lang],
                    datasets: [{
                        data: dataYear,
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });

        // Graphs days
        let labelDays = [];

        for (let i = 1; i < (lastDay + 1); i++) {
            labelDays.push(pad(i,2));
        }


        let canvaB   = document.getElementById('myChartB'),
            myChartB = new Chart(canvaB, {
                type: 'line',
                data: {
                    labels: labelDays,
                    datasets: [{
                        data: dataDays,
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });
    }

    // Metodo para validar los permisos dentro de la pagina
    function verificarPermisos(permisos){
        if(permisos.reportes == 0){
            $(".secseccionBody, .seccionHeader").remove();
            $(".contenedorPrincipal").html("<p class='lead my-3'>you currently do not have permission to access this resource</p>");
        }
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>