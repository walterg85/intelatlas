<?php
	class Clientmodel{
		public function __construct(){
	        require_once '../dbConnection.php';
	    }

	    public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO client
						(nombre, apellido, direccion_a, direccion_b, telefono, ciudad, estado, codigo_postal, adicional, registro, estatus, email, leads)
				VALUES
					(:nombre, :apellido, :direccion_a, :direccion_b, :telefono, :ciudad, :estado, :codigo_postal, :adicional, now(), 1, :email, :leads)
			';

			$parametros = array(
				':nombre' 			=> $data['inputName'],
				':apellido' 		=> $data['inputLastname'],
				':direccion_a' 		=> $data['inputAddress'],
				':direccion_b' 		=> $data['inputAddress2'],
				':telefono'			=> $data['inputPhone'],
				':email'			=> $data['inputEmail'],
				':ciudad' 			=> $data['inputCity'],
				':estado'			=> $data['inputState'],
				':codigo_postal'	=> $data['inputZip'],
				':adicional'		=> $data['inputInfo'],
				':leads'			=> $data['inputLeads']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return FALSE;
		    }
		}

		public function updates($data) {
			$pdo = new Conexion();
			$cmd = '
				UPDATE
					client
				SET nombre =:nombre, apellido =:apellido, direccion_a =:direccion_a, direccion_b =:direccion_b, telefono =:telefono, ciudad =:ciudad, estado =:estado, codigo_postal =:codigo_postal, adicional =:adicional, email =:email, leads =:leads
				WHERE id =:clientId;
			';

			$parametros = array(
				':nombre' 			=> $data['inputName'],
				':apellido' 		=> $data['inputLastname'],
				':direccion_a' 		=> $data['inputAddress'],
				':direccion_b' 		=> $data['inputAddress2'],
				':telefono'			=> $data['inputPhone'],
				':email'			=> $data['inputEmail'],
				':ciudad' 			=> $data['inputCity'],
				':estado'			=> $data['inputState'],
				':codigo_postal'	=> $data['inputZip'],
				':adicional'		=> $data['inputInfo'],
				':clientId'			=> $data['clientId'],
				':leads'			=> $data['inputLeads']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			return TRUE;
		}

		public function getClient(){
			$pdo = new Conexion();
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
					email,
					leads
				FROM 
					client
				WHERE estatus = 1 AND leads = 0;
			';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getLeads(){
			$pdo = new Conexion();
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
					email,
					leads
				FROM 
					client
				WHERE estatus = 1 AND leads = 1;
			';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function deleteClient($clientId){
			$pdo = new Conexion();
			$cmd = '
				UPDATE client SET estatus = 0 WHERE id =:clientId;
			';

			$parametros = array(
				':clientId' => $clientId
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function translate($clientId){
			$pdo = new Conexion();
			$cmd = '
				UPDATE client SET leads = 0 WHERE id =:clientId;
			';

			$parametros = array(
				':clientId' => $clientId
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function addNotes($clientId, $nota){
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO client_notes
						(client_id, nota)
				VALUES
					(:client_id, :nota)
			';

			$parametros = array(
				':client_id'	=> $clientId,
				':nota'			=> $nota
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return $pdo->lastInsertId();
			} catch (PDOException $e) {
		        return FALSE;
		    }
		}

		public function getNotes($clientId){
			$pdo = new Conexion();
			$cmd = '
				SELECT id, nota FROM client_notes WHERE client_id =:client_id;
			';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}