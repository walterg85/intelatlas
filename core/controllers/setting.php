<?php
	session_start();
	
	require_once '../models/setting.php';
	require_once '../utils/jwt.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$vars 			= ($_POST) ? $_POST : json_decode(file_get_contents("php://input"), TRUE);
		$settingsModel 	= new Settingsmodel();

		if($vars['_method'] == 'Get'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $settingsModel->get()
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'updateData'){
			$newPassword = ($vars['password'] == '') ? '' : encryptPass($vars['password']);

			$usData = array(
				'owner' 	=> $vars['owner'],
				'email' 	=> $vars['email'],
				'password' 	=> $newPassword
			);

			$setData = array(
				'shipingCost' 	=> $vars['shipingCost'],
				'shipingFree' 	=> $vars['shipingFree'],
				'tax' 			=> $vars['tax'],
				'paypalid'		=> $vars['paypalid'],
				'prodcarousel'	=> $vars['prodcarousel']
			);

			$tmpResponse = $settingsModel->updateData($usData, $setData);
			if($tmpResponse){
				$response = array(
					'codeResponse'	=> 200,
					'message' 		=> 'Updated information.'
				);

				$_SESSION['authData']->isDefault 	= (password_verify('12345', $tmpResponse->password)) ? 1 : 0;
				$_SESSION['authData']->email 		= $vars['email'];

				$folder = "assets/img";
				if (!empty($_FILES['settingPhoto'])){
					$filename = $_FILES['settingPhoto']['name'];
					$tempname = $_FILES['settingPhoto']['tmp_name'];
					       
					move_uploaded_file($tempname, "../../{$folder}/{$filename}");
				}
			}else{
				$response = array(
					'codeResponse' 	=> 0,
					'message' 		=> 'Outdated information'
				);
			}

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'getUnique'){
			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $settingsModel->getUnique($vars['parametro'])
			);

			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");			
			exit(json_encode($response));
		} else if($vars['_method'] == 'updateUniqueSetting'){
			$settingsModel->updateUniqueSetting($vars['parametro'], $vars['value']);

			header('HTTP/1.1 200 Ok');			
			exit();
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
		'codeResponse'	=> 400,
		'message' 		=> 'Bad Request'
	);
	exit( json_encode($response) );