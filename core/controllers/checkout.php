<?php
	session_start();
	
	require_once '../models/checkout.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 			= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$checkoutModel 	= new Checkoutmodel();

		if($vars['_method'] == '_POST'){
			$orderData = array(
				'customer_id' 		=> ( isset($_SESSION['isLoged']) ) ? $_SESSION['authData']->id : 0,
				'amount' 			=> $vars['amount'],
				'ship_price' 		=> $vars['ship_price'],
				'shipping_address'	=> $vars['shipping_address'],
				'payment_data' 		=> $vars['payment_data'],
				'coupon' 			=> $vars['coupon']
			);

			$order = $checkoutModel->createOrder($orderData);
			if($order){
				$checkoutModel->createOrderDetail( json_decode($vars['order'], TRUE), $order );

				if (isset($_SESSION['intelatlasClientLoged'])){
					$pDigitales = json_decode( $vars['productosDigitales'] );
					foreach ($pDigitales as $key => $value) {
						$valores = array(
							'clienteId' 	=> $_SESSION['intelatlasClientData']->id,
							'productoId' 	=> $value,
							'orderId' 		=> $order
						);
						$checkoutModel->setProductoDigital( $valores );
					}
				}

				$response = array(
					'codeResponse'	=> 200,
					'message' 		=> 'Registered order',
					'id' 			=> $order
				);
			}else{
				$response = array(
					'codeResponse'	=> 0,
					'message' 		=> 'order not registered'
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == '_GET') {
			$tmpData = $checkoutModel->getOrder( $vars['currentOrderId'] );
			$detail = [];
			foreach ($tmpData['detail'] as $key => $producto) {
				if($producto['esdigital'] == 1){
					$headers = array('alg' => 'HS256', 'typ' => 'JWT');
					$payload = array('producto' => $producto['name'], 'exp' => (time() + 300));
					$producto['linkto'] = generate_jwt($headers, $payload);
				}

				$detail[] = $producto;
			}

			$tmpData['detail'] = $detail;

			$response = array(
				'codeResponse'	=> 200,
				'data' 			=> $tmpData
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'GetCoupon') {
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $checkoutModel->GetCoupon( $vars['code'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'GetOrders') {
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $checkoutModel->GetOrders()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'getDetailOrder') {
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $checkoutModel->getDetailOrder($vars['orderId'])
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'cancelOrder') {
			$checkoutModel->cancelOrder($vars['orderId']);

			$response = array(
				'codeResponse' => 200
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'setTracking') {
			$checkoutModel->setTracking($vars['orderId'], $vars['tracking']);

			$response = array(
				'codeResponse' => 200
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'finalizeOrder') {
			$checkoutModel->finalizeOrder($vars['orderId']);

			$response = array(
				'codeResponse' => 200
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