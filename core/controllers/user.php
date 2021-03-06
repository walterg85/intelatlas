<?php
	session_start();
	
	require_once '../models/user.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 		= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$userModel 	= new Usersmodel();

		if($vars['_method'] == 'VALIDATE'){
			$tmpResponse = $userModel->login($vars['uname']);

			if($tmpResponse){
				if (password_verify($vars['password'], $tmpResponse->password)){
					unset($tmpResponse->password);

					$headers = array('alg' => 'HS256', 'typ' => 'JWT');
					$payload = array('username' => $vars['uname'], 'exp' => (time() + 86400));
					$tmpResponse->token = generate_jwt($headers, $payload);

					$response = array(
						'codeResponse' 	=> 200,
						'data' 			=> $tmpResponse,
						'message' 		=> 'Welcome'
					);

					$_SESSION['isLoged'] 				= TRUE;
					$_SESSION['authData'] 				= $tmpResponse;
					$_SESSION['authData']->isDefault 	= 0;

					if($vars['password'] == '12345')
						$_SESSION['authData']->isDefault = 1;
				}
			} else {
				$response = array(
					'codeResponse'	=> 0,
					'message' 		=> 'Username or password incorrect'
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'initDefault'){
			$usData = array(
				'owner' 	=> 'admin',
				'email' 	=> '',
				'password' 	=> encryptPass('12345'),
				'type' 		=> 1
			);

			$setData = array(
				'shipingCost' 	=> '4.99',
				'shipingFree' 	=> '75.00',
				'tax' 			=> '8.0',
				'paypalid'		=> 'ATTvB3Pjt7K6c0Pm7km72twwH3GI-3FnaqZvgwWbqfRU-RmndDwSuRXN21dFmc0-hpDxQC4P3MP_wC2H',
				'chat'			=> 1
			);

			$tmpResponse = $userModel->initDefault($usData, $setData);
			if($tmpResponse){
				$response = array(
					'codeResponse' 	=> 200,
					'message' 		=> 'Application started.'
				);
			}else{
				$response = array(
					'codeResponse' 	=> 0,
					'message' 		=> 'Application not started'
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'suscribe') {
			$userModel->suscribe($vars['email']);

			$response = array(
				'codeResponse' => 200
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == '_ValidateClient'){
			$tmpResponse = $userModel->loginClient($vars['username']);

			if($tmpResponse && password_verify($vars['userpassword'], $tmpResponse->contrase??a)){
					unset($tmpResponse->contrase??a);

					$response = array(
						'codeResponse' 	=> 200,
						'data' 			=> $tmpResponse,
						'message' 		=> 'Welcome'
					);

					$_SESSION['intelatlasClientLoged']	= TRUE;
					$_SESSION['intelatlasClientData']	= $tmpResponse;
			} else {
				$response = array(
					'codeResponse'	=> 0,
					'message' 		=> 'Username or password incorrect'
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'createUser'){
			$data = array(
				'owner'		=> $vars['owner'],
				'email' 	=> '',
				'password'	=> encryptPass($vars['password']),
				'type'		=> 2,
				'roles'		=> $vars['roles']
			);

			$userModel->createUser($data);

			header('HTTP/1.1 200 Ok');			
			exit();
		} else if($vars['_method'] == 'getUser'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $userModel->getUser()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'deleteUser'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $userModel->deleteUser($vars['userId'])
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'updateUser'){
			$data = array(
				'owner'		=> $vars['owner'],
				'password'	=> (strlen($vars['password']) > 0) ? encryptPass($vars['password']) : '',
				'roles'		=> $vars['roles'],
				'userId'	=> $vars['userId']
			);

			$userModel->updateUser($data);

			header('HTTP/1.1 200 Ok');			
			exit();
		} else if($vars['_method'] == 'solicitarPermiso'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $userModel->solicitarPermiso( $_SESSION['authData']->id )
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		}
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