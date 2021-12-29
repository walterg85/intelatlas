<?php
	class Clientmodel{
		public function __construct(){
	        require_once '../dbConnection.php';
	    }

	    public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO client
						(nombre, apellido, direccion_a, direccion_b, telefono, ciudad, estado, codigo_postal, adicional, registro, estatus, email, leads, contraseña)
				VALUES
					(:nombre, :apellido, :direccion_a, :direccion_b, :telefono, :ciudad, :estado, :codigo_postal, :adicional, now(), 1, :email, :leads, :password)
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
				':leads'			=> $data['inputLeads'],
				':password'			=> $data['password']
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

		public function translate($clientId, $passw){
			$pdo = new Conexion();
			$cmd = '
				UPDATE client SET leads = 0, contraseña =:passw WHERE id =:clientId;
			';

			$parametros = array(
				':clientId' => $clientId,
				':passw' => $passw
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function addNotes($clientId, $nota){
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO client_notes
						(client_id, nota, date_registered)
				VALUES
					(:client_id, :nota, now())
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
				SELECT id, nota, date_registered FROM client_notes WHERE client_id =:client_id;
			';

			$parametros = array(
				':client_id'	=> $clientId
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function deleteNotes($id){
			$pdo = new Conexion();
			$cmd = '
				DELETE FROM client_notes WHERE id =:id;
			';

			$parametros = array(
				':id'	=> $id
			);
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function getClientId($usId) {
			$pdo = new Conexion();
			$cmd = 'SELECT id, email, nombre, apellido, direccion_a, direccion_b, telefono, ciudad, estado, codigo_postal, adicional FROM client WHERE id=:id';

			$parametros = array(
				':id' => $usId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}

		public function updatePasswordConfig($usId, $password){
			$pdo = new Conexion();
			$cmd = '
				UPDATE client SET contraseña =:pass WHERE id =:id
			';

			$parametros = array(
				':id' 		=> $usId,
				':pass'		=> $password
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function validarEmail($email){
			$pdo = new Conexion();
			$cmd = 'SELECT count(id) AS existe FROM client WHERE email=:email';

			$parametros = array(
				':email' => $email
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch()->existe;
		}

		// Metodo para buscaar un usuario especifico
        public function getTorestore($email){
            $pdo = new Conexion();
            $cmd = 'SELECT COUNT(id) AS existe, id FROM client WHERE email =:email AND estatus = 1';

            $parametros = array(
                ':email' => $email
            );

            $sql = $pdo->prepare($cmd);
            $sql->execute($parametros);
            $sql->setFetchMode(PDO::FETCH_OBJ);

            return $sql->fetch();
        }

        // Metodo para actulizar contraseña
        public function updatePassword($data){
            $pdo = new Conexion();
            $cmd = 'UPDATE client SET contraseña =:password WHERE id =:clientId ';

            $parametros = array(
                ':password'	=> $data['password'],
                ':clientId'	=> $data['clientId']
            );

            $sql = $pdo->prepare($cmd);
            $sql->execute($parametros);

            return TRUE;
        }
	}