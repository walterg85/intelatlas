<?php
	class Usersmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

	    public function initDefault($usData, $setData){
	    	$pdo = new Conexion();

	    	$cmd = '
	    		DELETE FROM user WHERE owner = "admin";
	    		DELETE FROM setting WHERE parameter in("shipingCost", "shipingFree", "tax", "paypalid", "chat");
	    		DELETE FROM category WHERE name = "Uncategorized";
	    	';

	    	$sql = $pdo->prepare($cmd);
			$sql->execute();

			$this->createUser($usData);

			$cmd = '
				INSERT INTO setting (parameter, value) 
				VALUES ("shipingCost", :shipingCost), ("shipingFree", :shipingFree), ("tax", :tax), ("paypalid", :paypalid), ("chat", :chat);

				INSERT INTO category (name, description, active) VALUES ("Uncategorized", "Sin categoria", 1);
	    	';

			$parametros = array(
				':shipingCost' 	=> $setData['shipingCost'],
				':shipingFree' 	=> $setData['shipingFree'],
				':tax' 			=> $setData['tax'],
				':paypalid' 	=> $setData['paypalid'],
				':chat' 		=> $setData['chat']
			);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
	    }

		public function createUser($userData) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO user
					(owner, email, password, type, register_date, oauth_provider, active, roles)
				VALUES
					(:owner, :email, :password, :type, now(), "system", 1, :roles)
			';

			$parametros = array(
				':owner' => $userData['owner'],
				':email' => $userData['email'],
				':password' => $userData['password'],
				':type' => $userData['type'],
				':roles' => ($userData['roles']) ? $userData['roles'] : ''
			);
			
			try {
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);

				return [TRUE, $pdo->lastInsertId()];
			} catch (PDOException $e) {
		        return [FALSE, $e->getCode()];
		    }
		}

		public function login($uname) {
			$pdo = new Conexion();
			$cmd = 'SELECT id, email, password, type, owner FROM user WHERE owner =:uname AND active = 1';

			$parametros = array(
				':uname' => $uname
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}

		public function suscribe($email){
			$pdo = new Conexion();

			$cmd = '
				INSERT INTO subscribers
					(fecha_suscribe, email, estatus)
				VALUES
					(now(), :email, 1)
			';

			$parametros = array(
				':email' => $email
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function loginClient($uname) {
			$pdo = new Conexion();
			$cmd = 'SELECT id, email, contraseña, nombre, apellido, direccion_a, direccion_b, telefono, ciudad, estado, codigo_postal, adicional FROM client WHERE email =:uname AND estatus = 1 AND leads = 0';

			$parametros = array(
				':uname' => $uname
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}

		public function getUser() {
			$pdo = new Conexion();
			$cmd = 'SELECT id, owner, roles FROM user WHERE type = 2 AND active = 1';

			$sql = $pdo->prepare($cmd);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetchAll();
		}

		public function deleteUser($userId) {
			$pdo = new Conexion();
			$cmd = 'DELETE FROM user WHERE id =:id';

			$parametros = array(
				':id' => $userId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function updateUser($userData) {
			$pdo = new Conexion();

			$update = ( strlen($userData['password']) > 0 ) ? ', password ="'. $userData['password'] .'"' : '';
			$cmd = '
				UPDATE user SET owner =:owner, roles =:roles'. $update .' WHERE id =:userId
			';

			$parametros = array(
				':owner' => $userData['owner'],
				':roles' => $userData['roles'],
				':userId' => $userData['userId']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function solicitarPermiso($userId) {
			$pdo = new Conexion();
			$cmd = 'SELECT roles, type FROM user WHERE id =:id';
			$parametros = array(
				':id' => $userId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}
	}