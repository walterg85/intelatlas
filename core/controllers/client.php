<?php
	session_start();
	
	require_once '../models/client.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 			= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$clientModel 	= new Clientmodel();
		$response 		= array(
			'codeResponse' => 0
		);
		$message = '';

		if($vars['_method'] == 'POST'){
			$clientData = array(
				'inputName' 	=> $vars['inputName'],
				'inputLastname' => $vars['inputLastname'],
				'inputAddress'	=> $vars['inputAddress'],
				'inputAddress2'	=> $vars['inputAddress2'],
				'inputEmail'	=> $vars['inputEmail'],
				'inputPhone'	=> $vars['inputPhone'],
				'inputCity'		=> $vars['inputCity'],
				'inputState'	=> $vars['inputState'],
				'inputZip'		=> $vars['inputZip'],
				'inputInfo'		=> $vars['inputInfo'],
				'inputLeads'	=> $vars['leads'],
				'password'		=> ''
			);

			if($vars['clientId'] == 0){
				if($vars['leads'] == 0){
					$password 	= generateRandomPass(8);
					$clientData['password'] = encryptPass($password);
				}
				
				$tmpResponse = $clientModel->register($clientData);

				if($vars['leads'] == 0){
					// Se bypasea por que no tengo activo el mailserver, se debe activar ya en hosting
					$to      	= $vars['inputEmail'];				
					$subject 	= 'Account registration in intelatlas';
					$message 	= '
						You have been registered in intelatlas as a client, to access the user account area, 
						you must use your email '. $vars["inputEmail"] .', and use the following password: '. $password .', 
						for your security it is necessary to change it later.
					';
					// $headers = 'From: webmaster@clubtres.com'       . "\r\n" .
					            'Reply-To: webmaster@clubtres.com' . "\r\n" .
					            'X-Mailer: PHP/' . phpversion();
					// mail($to, $subject, $message, $headers);
				}
			}else{
				$clientData['clientId'] 	= $vars['clientId'];				
				$tmpResponse 				= $clientModel->updates($clientData);
				$_SESSION['intelatlasClientData'] = $clientModel->getClientId($vars['clientId']);
			}

			if($tmpResponse){
				$response = array(
					'codeResponse' => 200,
					'message' => $message
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == '_GET'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->getClient()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == '_Getleads'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->getLeads()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'Delete'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->deleteClient( $vars['clientId'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'translate'){
			$password 	= generateRandomPass(8);
			$strPass    = encryptPass($password);
			
			// Se bypasea por que no tengo activo el mailserver, se debe activar ya en hosting
			$to      	= $vars['email'];				
			$subject 	= 'Account registration in intelatlas';
			$message 	= '
				You have been registered in intelatlas as a client, to access the user account area, 
				you must use your email '. $vars["email"] .', and use the following password: '. $password .', 
				for your security it is necessary to change it later.
			';
			// $headers = 'From: webmaster@clubtres.com'       . "\r\n" .
			            'Reply-To: webmaster@clubtres.com' . "\r\n" .
			            'X-Mailer: PHP/' . phpversion();
			// mail($to, $subject, $message, $headers);

			$response 	= array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->translate( $vars['clientId'], $strPass ),
				'message'		=> $message
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'addNotes'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->addNotes( $vars['idCliente'], $vars['note'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'getNotes'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->getNotes( $vars['idCliente'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'deleteNotes'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $clientModel->deleteNotes( $vars['id'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'updatePasswordConfig'){
			$clientModel->updatePasswordConfig( $_SESSION['intelatlasClientData']->id, encryptPass($vars['newPassword']) );

			$response = array(
				'codeResponse' 	=> 200
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'validarEmail'){
			$response = array(
				'codeResponse' 	=> 200,
				'existe' 		=> $clientModel->validarEmail( $vars['email'] )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == '_RestorePassword'){
			$data = $clientModel->getTorestore($vars['email']);

			// Generar token para recuperacion de contraseña
			// Al tiempo actual se le suman 900 Segundos (15 min), para que al paso de ello no sea valido el token
			$headers = array('alg' => 'HS256', 'typ' => 'JWT');
			$payload = array('usEmail' => $vars['email'], 'exp' => (time() + 900));
			$token = generate_jwt($headers, $payload);
			//==============================================

			if($data->existe > 0){
				//Se bypasea por que no tengo activo el mailserver, se debe activar ya en hosting
				// $to      = $vars['email'];
				//    $subject = 'Restore de password';
				//    $message = '
				//    	Recover your account and reset your password in the following link: http://localhost/clubtres/user/recoverypassword.php?restore='. $data->id .'&token='. $token.'
				//    ';
				//    $headers = 'From: webmaster@clubtres.com'       . "\r\n" .
				//               'Reply-To: webmaster@clubtres.com' . "\r\n" .
				//               'X-Mailer: PHP/' . phpversion();
				//    mail($to, $subject, $message, $headers);

				// Esto es solo para completar el proceso sin interuppciones, se debe borrar
				$data->url = 'http://localhost/intelatlas/account.php?restore='. $data->id .'&token='. $token;
			}
			
			$response = array(
				'codeResponse' 	=> 200,
				'data'			=> $data
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'updatePassword'){
			$bearer_token 	= get_bearer_token();
			$is_jwt_valid 	= is_jwt_valid($bearer_token);

			if($is_jwt_valid){
				$newPassword 	= encryptPass($vars['newPassword']);

				$usData = array(
					'clientId' 	=> $vars['clientId'],
					'password'	=> $newPassword
				);
				
				$clientModel->updatePassword($usData);

				$response = array(
					'codeResponse' 	=> 200
				);			

				header('HTTP/1.1 200 Ok');
				header("Content-Type: application/json; charset=UTF-8");
				exit(json_encode($response));
			} else{
				header('HTTP/1.1 200 Ok');
				header("Content-Type: application/json; charset=UTF-8");

				$response = array(
					'codeResponse' => 401,
					'message' => 'Unauthorized'
				);

				exit( json_encode($response) );
			}
		}
	}

	function generateRandomPass($length = 10) {
	    $characters 		= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength 	= strlen($characters);
	    $randomString 		= '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    return $randomString;
	}

	function encryptPass($strPassword) {
		$options = [
		    'cost' => 12
		];

		return password_hash($strPassword, PASSWORD_BCRYPT, $options);
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);
	exit( json_encode($response) );