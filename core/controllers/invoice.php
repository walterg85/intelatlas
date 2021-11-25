<?php
	session_start();
	
	require_once '../models/invoice.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 			= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$invoiceModel 	= new Invoicemodel();
		$response 		= array(
			'codeResponse' => 0
		);

		if($vars['_method'] == 'POST'){
			$invoiceData = array(
				'clienteId' => $vars['clienteSeleccionado'],
				'conceptos' => $vars['arrayConcepto'],
				'importe'	=> $vars['importeTotal'],
				'estatus'	=> $vars['estatus'],
				'cupon'		=> $vars['cupon']
			);

			if($vars['invoiceId'] == 0){
				$tmpResponse = $invoiceModel->register($invoiceData);
			}else{
				$invoiceData['invoiceId'] 	= $vars['invoiceId'];
				$tmpResponse 				= $invoiceModel->updates($invoiceData);
			}

			if($tmpResponse){
				$response = array(
					'codeResponse' => 200
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'GET'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $invoiceModel->getInvoice()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == '_GetClient'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $invoiceModel->getInvoiceClient( $vars['clientId'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'Delete'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $invoiceModel->deleteInvoice( $vars['invoiceId'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'generatePdf'){
			$data 		= $invoiceModel->getInvoiceId( $vars['invoiceId'] );
			$htmlBoddy 	= "<h1>No found data</h1>";

			if($data){
				$statusInvoice 	= "";

				if($data['invoiceData']['estatus'] == "1")
					$statusInvoice = '<text style="color:red;">Debt</text>';

				if($data['invoiceData']['estatus'] == "2")
					$statusInvoice = '<text style="color:green;">Paid out</text>';

				if($data['invoiceData']['estatus'] == "3")
					$statusInvoice = '<text style="color:orange;">Refound</text>';

				$htmlBoddy 		= '
					<!DOCTYPE html>
					<html>
					<head>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1">
					</head>
					<body>
						<div>
							<img style="float: left;" src="https://cdn.dribbble.com/users/27903/screenshots/5370954/v_2x.png" width="200"/>
							<div style="float: right;">
								<h1 style="text-align: right;">My invoice #'. str_pad($data['invoiceData']['id'], 5, "0", STR_PAD_LEFT) .'</h1>
								<p style="text-align: right; margin-bottom: 0px;">'. $data['invoiceData']['fecha'] .'</p>
								<p style="text-align: right; margin-top: 0px;">'. $statusInvoice .'</p>
							</div>
						</div>

						<div style="clear: left;"></div>

						<table>
							<tbody>
								<tr>
									<td width="30%">&#8226; '. $data['clientData']['nombre'] .' '. $data['clientData']['apellido'] .'</td>
								</tr>
								<tr>
									<td width="30%">&#8226; '. $data['clientData']['direccion_a'] .'</td>
								</tr>
								<tr>
									<td width="30%">&#8226; '. $data['clientData']['direccion_b'] .'</td>
								</tr>
								<tr>
									<td width="30%">&#8226; '. $data['clientData']['telefono'] .'</td>
								</tr>
								<tr>
									<td width="30%">&#8226; '. $data['clientData']['ciudad'] .' '. $data['clientData']['estado'] .' '. $data['clientData']['codigo_postal'] .'</td>
								</tr>
								<tr>
									<td width="30%">&#8226; '. $data['clientData']['adicional'] .'</td>
								</tr>
							</tbody>
						</table>

						<hr>
				';

				$conceptos 	= json_decode($data['invoiceData']['detalles']);
				$filas		= '';
				$total 		= 0;
				$grantotal	= 0;

				foreach ($conceptos as $key => $item) {
					$total = $item->cantidad * $item->precio;
					$filas .= '
						<tr>
							<td>'. ($key + 1) .'</td>
							<td>'. $item->concepto .'</td>
							<td style="text-align: center;">$ '. $item->precio .'</td>
							<td style="text-align: center;">'. $item->cantidad .'</td>
							<td style="text-align: center;">$ '. $total .'</td>
						</tr>
					';

					$grantotal += $total;
				}

				$htmlBoddy .= '
						<table id="conceptos" style="width: 100%; border: 1px solid #d7d7d7;">
							<thead>
								<tr style="background-color: #d7d7d7;">
									<th>#</th>
									<th>Concept</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								'. $filas .'
							</tbody>
						</table>

						<hr>

						<h1 style="text-align: right; color: red; font-weight: 600;">Total $'. $grantotal .'</h1>
					</body>
					</html>
				';
			}

			exit($htmlBoddy);
		}
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);
	exit( json_encode($response) );