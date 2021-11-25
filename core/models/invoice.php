<?php
	class Invoicemodel{
		public function __construct(){
	        require_once '../dbConnection.php';
	    }

	    public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO invoice
						(client_id, detalles, importe, fecha, estatus, activo, cupon)
				VALUES
					(:client_id, :detalles, :importe, now(), 1, 1, :cupon)
			';

			$parametros = array(
				':client_id' 	=> $data['clienteId'],
				':detalles' 	=> $data['conceptos'],
				':importe' 		=> $data['importe'],
				':cupon' 		=> $data['cupon']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return FALSE;
		    }
		}

		public function updates($data){
			$pdo = new Conexion();
			$cmd = '
				UPDATE invoice
				SET client_id =:client_id, detalles =:detalles, importe =:importe, estatus =:estatus, cupon =:cupon
				WHERE id =:invoiceId
			';

			$parametros = array(
				':invoiceId' 	=> $data['invoiceId'],
				':client_id' 	=> $data['clienteId'],
				':detalles' 	=> $data['conceptos'],
				':importe' 		=> $data['importe'],
				':estatus' 		=> $data['estatus'],
				':cupon' 		=> $data['cupon']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
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
					estatus,
					cupon
				FROM invoice
				WHERE activo = 1;
			';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getInvoiceClient($clientId){
			$pdo = new Conexion();
			$cmd = '
				SELECT 
					id,
					client_id, 
					(select concat(nombre, " ", apellido) from client where id = client_id) AS clientName,
					detalles, 
					importe, 
					fecha, 
					estatus,
					cupon
				FROM invoice
				WHERE activo = 1 AND client_id =:client_id;
			';

			$parametros = array(
				'client_id' => $clientId
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getInvoiceId($invoiceId){
			$pdo = new Conexion();
			$cmd = '
				SELECT 
					id,
					client_id,
					detalles, 
					importe, 
					fecha, 
					estatus,
					cupon
				FROM invoice
				WHERE id =:invoiceId;
			';

			$parametros = array(
				'invoiceId' => $invoiceId
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			$invoiceData = $sql->fetch(PDO::FETCH_ASSOC);
			$data = [];
			if($invoiceData){
				$data['invoiceData'] = $invoiceData;

				$cmd = '
					SELECT
						id,
						nombre, 
						apellido, 
						direccion_a, 
						direccion_b, 
						telefono, 
						ciudad, 
						estado, 
						codigo_postal, 
						adicional, 
						registro,
						email
					FROM 
						client
					WHERE id =:clientId;
				';

				$parametros = array(
					'clientId' => $invoiceData['client_id']
				);
				
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);

				$data['clientData'] = $sql->fetch(PDO::FETCH_ASSOC);
			}			

			return $data;
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