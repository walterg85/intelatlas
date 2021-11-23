<?php
	class Clientmodel{
		public function __construct(){
	        require_once '../dbConnection.php';
	    }

	    public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO client
						(nombre, apellido, direccion_a, direccion_b, telefono, ciudad, estado, codigo_postal, adicional, registro, estatus)
				VALUES
					(:nombre, :apellido, :direccion_a, :direccion_b, :telefono, :ciudad, :estado, :codigo_postal, :adicional, now(), 1)
			';

			$parametros = array(
				':nombre' 			=> $data['inputName'],
				':apellido' 		=> $data['inputLastname'],
				':direccion_a' 		=> $data['inputAddress'],
				':direccion_b' 		=> $data['inputAddress2'],
				':telefono'			=> $data['inputPhone'],
				':ciudad' 			=> $data['inputCity'],
				':estado'			=>  $data['inputState'],
				':codigo_postal'	=>  $data['inputZip'],
				':adicional'		=>  $data['inputInfo']
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
				SET nombre =:nombre, apellido =:apellido, direccion_a =:direccion_a, direccion_b =:direccion_b, telefono =:telefono, ciudad =:ciudad, estado =:estado, codigo_postal =:codigo_postal, adicional =:adicional
				WHERE id =:clientId;
			';

			$parametros = array(
				':nombre' 			=> $data['inputName'],
				':apellido' 		=> $data['inputLastname'],
				':direccion_a' 		=> $data['inputAddress'],
				':direccion_b' 		=> $data['inputAddress2'],
				':telefono'			=> $data['inputPhone'],
				':ciudad' 			=> $data['inputCity'],
				':estado'			=> $data['inputState'],
				':codigo_postal'	=> $data['inputZip'],
				':adicional'		=> $data['inputInfo'],
				':clientId'			=> $data['clientId']
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
					registro
				FROM 
					client
				WHERE estatus = 1;
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
	}