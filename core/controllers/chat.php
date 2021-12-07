<?php
	session_start();
	require_once '../models/chat.php';

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		parse_str(file_get_contents("php://input"), $put_vars);

		// Instanciamos el modelo
		$chatModel = new Chatmodel();

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
		} else if($put_vars['_method'] == 'POST'){
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
		} else if($put_vars['_method'] == 'saludarIniciar'){
			$origin = array(
				'name' 	=> $put_vars['name'],
				'mail' 	=> $put_vars['email'],
				'phone'	=> $put_vars['phone'],
				'ip' 	=> $put_vars['ip'],
				'date' 	=> $put_vars['_time']
			);

			$message = '
				<figure class="text-end">
					<blockquote class="blockquote">
						<p class="small">'.$put_vars["message"].'.</p>
					</blockquote>
					<figcaption class="blockquote-footer">
						'. date('H:i:s') .' | technical support
					</figcaption>
				</figure>
			';

			$data = array(
				'origin' 	=> $origin,
				'message'	=> $message
			);

			// Se ejecuta el metodo para crear el chat
			$chatId = $chatModel->insertChat($data);

			// Termina transaccion, esperrar 2 segundos para lanzar resultado
			sleep(2);
			header('HTTP/1.1 200 Ok');
			exit($chatId);
		} else if($put_vars['_method'] == 'responseChat'){
			$message = '
				<div class="alert text-white" role="alert">
                    <figure class="mb-0">
                        <blockquote class="blockquote">
                            <p class="small">'. $put_vars['message'] .'</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0">
                            '. date('H:i:s') .' | '. $put_vars['chatIp'] .'
                        </figcaption>
                    </figure>
                </div>
			';

			$data = array(
				'message'	=> $message,
				'chatId'	=> $put_vars['chatId']
			);

			// Se ejecuta el metodo para crear el chat
			$chatModel->responseChat($data);

			// Se termina la transaccion
			header('HTTP/1.1 200 Ok');	
			exit();
		} else if($put_vars['_method'] == 'loadLog'){
			// Se ejecuta el metodo para obtener el chat
			$data = $chatModel->loadChatLog( intval( $put_vars['chatId'] ) );

			// Se termina la transaccion
			header('HTTP/1.1 200 Ok');
			header("Content-Type: application/json; charset=UTF-8");
			exit(json_encode($data));
		} else if($put_vars['_method'] == 'closeChat'){
			// Se ejecuta el metodo para cerrar el chat
			$data = $chatModel->closeChat( intval( $put_vars['chatId'] ) );

			// Se termina la transaccion
			header('HTTP/1.1 200 Ok');
			exit();
		} else if($put_vars['_method'] == 'dejarMensaje'){
			$origin = array(
				'name' 	=> $put_vars['name'],
				'mail' 	=> $put_vars['email'],
				'phone'	=> $put_vars['phone'],
				'ip' 	=> $put_vars['ip'],
				'date' 	=> $put_vars['_time']
			);

			$message = '
				<div class="alert text-white" role="alert">
                    <figure class="mb-0">
                        <blockquote class="blockquote">
                            <p class="small">'. $put_vars['message'] .'</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0">
                            '. date('H:i:s') .' | '. $put_vars['chatIp'] .'
                        </figcaption>
                    </figure>
                </div>
			';

			$data = array(
				'origin' 	=> $origin,
				'message'	=> $message
			);

			// Se ejecuta el metodo para crear el chat
			$chatId = $chatModel->insertChat($data);

			// Termina transaccion, esperrar 2 segundos para lanzar resultado
			sleep(2);
			header('HTTP/1.1 200 Ok');
			exit($chatId);
		}
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);

	exit( json_encode($response) );