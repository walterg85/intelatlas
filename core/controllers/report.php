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
				'anioActual'	=> $vars['anioActual'],
				'anioPasado'	=> $vars['anioPasado'],
				'mesActual'		=> $vars['mesActual'],
				'ultimoDiaMes'	=> $vars['ultimoDiaMes']
			);

			$response = array(
				'codeResponse' 	=> 200,
				'data' 			=> $reportmodel->getResumen( $data )
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