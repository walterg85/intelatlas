<?php
	class Invoicemodel{
		public function __construct(){
	        require_once '../dbConnection.php';
	    }

	    public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO invoice
						(client_id, detalles, importe, fecha, estatus, activo)
				VALUES
					(:client_id, :detalles, :importe, now(), 1, 1)
			';

			$parametros = array(
				':client_id' 			=> $data['clienteId'],
				':detalles' 		=> $data['conceptos'],
				':importe' 		=> $data['importe']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return FALSE;
		    }
		}
	}