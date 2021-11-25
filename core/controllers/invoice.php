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
			require_once(dirname(__FILE__).'/../utils/html2pdf/html2pdf.class.php');

			$content = "<h1>Generado factura</h1>";
			$rutaPDF = "miFactura.pdf";

			try{
	            $html2pdf = new HTML2PDF('P', 'letter', 'es', true, 'UTF-8', 3); //Configura la hoja
	            $html2pdf->pdf->SetDisplayMode('fullpage'); //Ver otros parámetros para SetDisplaMode
	            $html2pdf->writeHTML($content); //Se escribe el contenido 
	            $html2pdf->Output($rutaPDF, "F");
	            //$html2pdf->Output('factura.pdf'); //Nombre default del PDF
	        }
	        catch(HTML2PDF_exception $e) {
	            return $e;
	            echo $e;
	            exit;
	        }

	        exit("ok");
		}
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);
	exit( json_encode($response) );