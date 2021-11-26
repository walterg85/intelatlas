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
				$payload 		= json_decode($data['invoiceData']['payload']);
				$infoPay		= "";

				if($data['invoiceData']['estatus'] == "1")
					$statusInvoice = '<text style="color:red;">Debt</text>';

				if($data['invoiceData']['estatus'] == "2")
					$statusInvoice = '<text style="color:green;">Paid out</text>';

				if($data['invoiceData']['estatus'] == "3")
					$statusInvoice = '<text style="color:orange;">Refound</text>';

				if($payload){
					if($payload->purchase_units){
						$infoPay .= '<p style="text-align: left; margin-bottom: 0px;"><text style="font-weight: 500;">Payment date:</text> '. $payload->create_time .'</p>';
						$infoPay .= '<p style="text-align: left; margin-bottom: 0px; margin-top: 0px;"><text style="font-weight: 500;">Paypal Id:</text> '. $payload->purchase_units[0]->payments->captures[0]->id .'</p>';
						$infoPay .= '<p style="text-align: left; margin-bottom: 0px; margin-top: 0px;"><text style="font-weight: 500;">Payer name:</text> '. $payload->payer->name->given_name .' '. $payload->payer->name->surname .'</p>';
						$infoPay .= '<p style="text-align: left; margin-bottom: 0px; margin-top: 0px;"><text style="font-weight: 500;">Payer e-mail:</text> '. $payload->payer->email_address .'</p>';
					}
				}

				$htmlBoddy 		= '
					<!DOCTYPE html>
					<html>
					<head>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1">
					</head>
					<body>
						<div id="dvHeader" style="width: 98%;">
                            <div style="float: left;">
                                <img src="../assets/img/logo.png?v='. rand(0,100) .'" width="160">
                            </div>
                            <div style="float: right;">
                                <h1 style="text-align: right;">My invoice #'. str_pad($data['invoiceData']['id'], 5, "0", STR_PAD_LEFT) .'</h1>
                                <p style="text-align: right; margin-bottom: 0px;">'. $data['invoiceData']['fecha'] .'</p>
                                <p style="text-align: right; margin-top: 0px;">'. $statusInvoice .'</p>
                            </div>
                            <p style="float: none;"></p>
                        </div>

						<table style="width: 98%;">
							<tbody>
								<tr>
									<td width="50%">&#8226; '. $data['clientData']['nombre'] .' '. $data['clientData']['apellido'] .'</td>
									<td width="50%" rowspan="6" style="vertical-align: top;">'. $infoPay .'</td>
								</tr>
								<tr>
									<td width="50%">&#8226; '. $data['clientData']['direccion_a'] .'</td>
								</tr>
								<tr>
									<td width="50%">&#8226; '. $data['clientData']['direccion_b'] .'</td>
								</tr>
								<tr>
									<td width="50%">&#8226; '. $data['clientData']['telefono'] .'</td>
								</tr>
								<tr>
									<td width="50%">&#8226; '. $data['clientData']['ciudad'] .' '. $data['clientData']['estado'] .' '. $data['clientData']['codigo_postal'] .'</td>
								</tr>
								<tr>
									<td width="50%">&#8226; '. $data['clientData']['adicional'] .'</td>
								</tr>
							</tbody>
						</table>

						<hr>
				';

				$conceptos 	= json_decode($data['invoiceData']['detalles']);
				$filas		= '';
				$total 		= 0;
				$totalReal  = 0;

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

					$totalReal += $total;
				}

				$cupon = json_decode($data['invoiceData']['cupon']);
				$filaCupon = "";

				if($cupon){
					if($cupon->valor){
						$totalDescuento = 0;
						if($cupon->tipo == 1){
							$totalDescuento = $totalReal * $cupon->importe;
							$filaCupon = '<p style="text-align: right;">(Discount '. $cupon->valor.') $'. $totalDescuento .'</p>';
						}else{
							$filaCupon = '<p style="text-align: right;">(Discount '. $cupon->valor.')</p>';
						}
					}					
				}

				$htmlBoddy .= '
						<table id="conceptos" style="width: 98%; border: 1px solid #d7d7d7;">
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

						'. $filaCupon .'
						<h1 style="text-align: right; color: red; font-weight: 600; width: 98%;">Total $'. $data['invoiceData']['importe'] .'</h1>
					</body>
					</html>
				';
			}

			$response = array(
				'htmlBoddy' => $htmlBoddy,
				'importeTotal' => $data['invoiceData']['importe'],
				'allData' => $data
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			exit(json_encode($response));
		} else if($vars['_method'] == 'invoicePaymen'){
			$invoiceData = array(
				'invoiceId' => $vars['invoiceId'],
				'payload'	=> $vars['payload']
			);

			$invoiceModel->invoicePaymen($invoiceData);

			if($tmpResponse){
				$response = array(
					'codeResponse' => 200
				);
			}

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