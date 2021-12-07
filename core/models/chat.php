<?php
	class Chatmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

	    public function insertChat($data){
	    	$pdo = new Conexion();

	    	$cmd = '
				INSERT INTO chat
					(message, origin, unread, registered, estatus)
				VALUES
					(:message, :origin, 1, NOW(), 1)
			';

			$parametros = array(
				':message'	=> $data['message'],
				':origin'	=> json_encode($data['origin'])
			);
			
			try {
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);

				return $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return 0;
		    }
	    }

	    public function responseChat($data){
	    	$pdo = new Conexion();

	    	$cmd = '
				UPDATE chat
				SET message = CONCAT(message, :message), unread = (unread + 1)
				WHERE id =:id
			';

			$parametros = array(
				':message'	=> $data['message'],
				':id'	=> $data['chatId']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return 0;
	    }

	    // Metodo para cargar el log completo de un chat
		public function loadChatLog($chatId){
			$pdo = new Conexion();

			$cmd = '
				SELECT message, estatus
				FROM chat
				WHERE estatus = 1
				AND id = ' . $chatId;

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetch(PDO::FETCH_ASSOC);
		}

		// Metodo para cerrar un chat lado usuario
		public function closeChat($chatId){
			$pdo = new Conexion();

			$cmd = '
				UPDATE chat SET estatus = 0 WHERE id = ' . $chatId;

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return TRUE;
		}

		// Metodo para listar todos los chats 
		public function loadChatList(){
			$pdo = new Conexion();

			$cmd = '
				SELECT id, origin, unread, registered,  estatus
				FROM chat
				WHERE estatus in(0, 1)
			';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		// Metodo para cargar el log completo de un chat de lado administrador
		public function loadChatLogAdmin($chatId){
			$pdo = new Conexion();
			$parametros = array(
				':id' => $chatId
			);

			$cmd = '
				UPDATE chat SET unread = 0 WHERE id =:id;
			';		

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			$cmd = '
				SELECT message, estatus FROM chat WHERE id =:id;
			';

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $sql->fetch(PDO::FETCH_ASSOC);
		}

		// Metodo para responder el chat lado administardor
		public function responseChatAdmin($data){
	    	$pdo = new Conexion();

	    	$cmd = '
				UPDATE chat
				SET message = CONCAT(message, :message)
				WHERE id =:id
			';

			$parametros = array(
				':message'	=> $data['message'],
				':id'	=> $data['chatId']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return 0;
	    }
	}