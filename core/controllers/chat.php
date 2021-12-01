<?php
	session_start();

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		parse_str(file_get_contents("php://input"), $put_vars);

		$directorio = dirname(__FILE__, 1) . "/logs";
		if( !is_dir($directorio) )
			mkdir($directorio, 0777, true);

		if($put_vars['_method'] == 'GET'){
			$remote  = ($_SERVER['REMOTE_ADDR'] == '::1') ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
			$logFile = 'logs/log_' . $remote .'.html';

			if(file_exists($logFile) && filesize($logFile) > 0){
				echo file_get_contents($logFile);
				header('HTTP/1.1 200 OK');
			}else{
				header('HTTP/1.1 400 Bad Request');
				echo $remote;
			}

			exit();
		}else if($put_vars['_method'] == 'POST'){
			if($put_vars['_action'] == 'closeChat'){
				$remote  = ($_SERVER['REMOTE_ADDR'] == '::1') ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
				$email   = (strlen($put_vars['email']) > 0) ? $put_vars['email'] : 'No email';
				$name    = (strlen($put_vars['name']) > 0) ? $put_vars['name'] : 'User ' . rand(0, 100);
				

				$message = '
					<input type="hidden" id="inputClose" value="'. $put_vars["_time"] .'" />
					<div class="alert alert-info" role="alert">
						<h6 class="alert-heading">'. $name .'</h6>
						<p class="text-danger"><b>The client has decided to close the chat.</b></p>
						<hr class="m-0">
						<p class="mb-0 small">'. $put_vars["_time"] .' | '. $email .'</p>
					</div>
				';

				file_put_contents('logs/log_' . $remote .'.html', $message, FILE_APPEND | LOCK_EX);
				header('HTTP/1.1 200 OK');
				exit();
			}else{
				$remote  = ($_SERVER['REMOTE_ADDR'] == '::1') ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
				$email   = (strlen($put_vars['email']) > 0) ? $put_vars['email'] : 'No email';
				$name    = (strlen($put_vars['name']) > 0) ? $put_vars['name'] : 'User ' . rand(0, 100);
				$round   = $put_vars['round'];
				

				$message = '
					<div class="alert alert-info" role="alert">
						<h6 class="alert-heading">'. $name .'</h6>
						<p>'. stripslashes(htmlspecialchars($put_vars["message"])) .'.</p>
						<hr class="m-0">
						<p class="mb-0 small">'. $put_vars["_time"] .' | '. $email .'</p>
					</div>
				';

				if($round == 1 || $round == 0)
					$message .= '
						<input type="hidden" id="inputName" value="'. $name .'" />
						<input type="hidden" id="inputMail" value="'. $email .'" />
						<input type="hidden" id="inputQuestion" value="'. stripslashes(htmlspecialchars($put_vars["message"])) .'" />
						<input type="hidden" id="inputDate" value="'. $put_vars["_time"] .'" />

						<figure class="text-end">
							<blockquote class="blockquote">
							<p class="small">I am a virtual assistant, In a moment an agent will take your case, do not hesitate to continue writing.</p>
							</blockquote>
							<figcaption class="blockquote-footer">
								'. $put_vars["_time"] .' | Virtual assistant
							</figcaption>
						</figure>
					';

				file_put_contents('logs/log_' . $remote .'.html', $message, FILE_APPEND | LOCK_EX);

				/*Habilitarlo cuando se tenga el host on line
				require_once "PHPMailer/Exception.php";
				require_once "PHPMailer/PHPMailer.php";
				require_once "PHPMailer/SMTP.php";
							
				$mail = new PHPMailer\PHPMailer\PHPMailer();
				$mail->isSMTP();
				$mail->Host         = 'smtp...';
				$mail->SMTPAuth     = true;
				$mail->Username     = 'Correo saliente';
				$mail->Password     = 'Contraseña';
				$mail->SMTPSecure   = 'tls';
				$mail->Port         = 587;
				$mail->CharSet      = "UTF-8";
				$mail->setFrom('@mail.com', 'Nombre');

				$mail->addAddress('quien_recibe@mail.com');
				$mail->Subject = 'Nueco chat de soporte';
				$mail->isHTML(true);
				$mail->Body = 'Hay un nuevo chat de soporte que debes de atender';

				$mail->Send()
				*/

				header('HTTP/1.1 200 OK');
				exit();
			}
		}
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);

	exit( json_encode($response) );