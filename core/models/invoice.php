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

		public function getInvoice(){
			$pdo = new Conexion();
			$cmd = '
				SELECT 
					id,
					client_id, 
					(select concat(nombre, " ", apellido) from client where id = client_id) AS clientName,
					detalles, 
					importe, 
					fecha, 
					estatus
				FROM invoice
				WHERE activo = 1;
			';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function deleteInvoice($invoiceId){
			$pdo = new Conexion();
			$cmd = '
				UPDATE invoice SET activo = 0 WHERE id =:invoiceId;
			';

			$parametros = array(
				':invoiceId' => $invoiceId
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}
	}