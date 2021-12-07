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
			if($put_vars['_action'] == 'getList'){
				// Se ejecuta el metodo para obtener la lista de chats
				$data = $chatModel->loadChatList();

				header('HTTP/1.1 200 OK');
				header("Content-Type: application/json; charset=UTF-8");
				exit(json_encode($data));
			}else if($put_vars['_action'] == 'getChat'){
				// Se ejecuta el metodo para obtener el chat
				$data = $chatModel->loadChatLogAdmin( intval( $put_vars['_chatid'] ) );

				header('HTTP/1.1 200 OK');
				header("Content-Type: application/json; charset=UTF-8");
				exit(json_encode($data));
			}
		}else if($put_vars['_method'] == 'POST'){
			if ($put_vars['_action'] == 'closeChat') {
				$message = '
					<figure class="text-end">
						<blockquote class="blockquote">
						<p class="small text-danger">Technical support decided to end the chat because it marked the issue as resolved.</p>
						</blockquote>
						<figcaption class="blockquote-footer">
							'. $put_vars["_time"] .' | Technical support
						</figcaption>
					</figure>
				';

				// Se ejecuta el metodo para cerrar el chat
				$data = $chatModel->closeChat( intval( $put_vars['_chatid'] ), $message );

				// Se termina la transaccion
				header('HTTP/1.1 200 Ok');
				exit();
			}else if($put_vars['_action'] == 'responseChat'){
				$message 	= '
					<figure class="text-end">
						<blockquote class="blockquote">
							<p class="small">'. stripslashes(htmlspecialchars($put_vars["message"])) .'</p>
						</blockquote>
						<figcaption class="blockquote-footer">
							'. $put_vars["_time"] .' | Technical support
						</figcaption>
					</figure>
				';

				$data = array(
					'message'	=> $message,
					'chatId'	=> $put_vars['_chatid']
				);

				// Se ejecuta el metodo para contestar el chat
				$chatModel->responseChatAdmin($data);

				// Se termina la transaccion
				header('HTTP/1.1 200 Ok');	
				exit();
			}else if ($put_vars['_action'] == 'moveChat') {
				// Se ejecuta el metodo para cerrar el chat
				$chatModel->moveChat( intval( $put_vars['_chatid'] ) );

				// Se termina la transaccion
				header('HTTP/1.1 200 Ok');
				exit();
			}else if($put_vars['_action'] == 'sendChat'){
				$message = '
					<figure class="text-end">
						<blockquote class="blockquote">
						<p class="small text-danger">Technical support decided to end the chat because it marked the issue as resolved.</p>
						</blockquote>
						<figcaption class="blockquote-footer">
							'. $put_vars["_time"] .' | Technical support
						</figcaption>
					</figure>
				';

				// Se ejecuta el metodo para cerrar el chat
				$data = $chatModel->closeChat( intval( $put_vars['_chatid'] ), $message );

				// Se termina la transaccion
				header('HTTP/1.1 200 Ok');
				exit();

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
				$mail->Subject = 'Chat de soporte finalizado';
				$mail->isHTML(true);
				$mail->Body = 'Se finalizo el chat, se adjunta para su revisión';
				$mail->addAttachment( $put_vars['_file'] );

				$mail->Send()
				*/
				
			}
		}
	}

	function getChatsLogs($dir){
		$result = array();
		$cdir   = scandir($dir);

		foreach ($cdir as $key => $value){
			if (!in_array($value,array(".",".."))){
				if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
					$result[] = $dir . $value;
			}
		}

		return $result;
	}

	header('HTTP/1.1 400 Bad Request');
	header("Content-Type: application/json; charset=UTF-8");

	$response = array(
		'codeResponse' => 400,
		'message' => 'Bad Request'
	);
	exit( json_encode($response) );