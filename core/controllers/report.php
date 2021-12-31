<?php
	session_start();
	
	require_once '../models/report.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 			= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$reportmodel 	= new Reportmodel();

		if($vars['_method'] == 'getResumen') {
			$data = array(
				'anioActual'		=> $vars['anioActual'],
				'anioPasado'		=> $vars['anioPasado'],
				'mesActual'			=> $vars['mesActual'],
				'ultimoDiaMes'		=> $vars['ultimoDiaMes'],
				'primerDiaSemana'	=> $vars['primerDiaSemana'],
				'ultimoDiaSemana'	=> $vars['ultimoDiaSemana']
			);

			$resumenMeses = [];
			for ($i=1; $i < 13; $i++) { 
				$result = $reportmodel->getResumenMonth( $data['anioActual'] . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) );

				$venta = ($result->total_venta) ? $result->total_venta : 0;
				$factura = ($result->venta_factura) ? $result->venta_factura : 0;

				$resumenMeses[] = number_format((float) $venta + $factura , 2, '.', '');
			}

			$resumenDias = [];
			for ($i=1; $i <= $vars['ultimoDiaMes']; $i++) {
				$result = $reportmodel->getResumenDay( $data['anioActual'] . '-' . $vars['mesActual'] . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) );

				$venta = ($result->total_venta) ? $result->total_venta : 0;
				$factura = ($result->venta_factura) ? $result->venta_factura : 0;

				$resumenDias[] = number_format((float) $venta + $factura , 2, '.', '');
			}

			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $reportmodel->getResumen( $data ),
				'dataMes'		=> $resumenMeses,
				'dataDia'		=> $resumenDias
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		}
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);
	exit( json_encode($response) );