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
	}