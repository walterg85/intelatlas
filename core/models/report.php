<?php
	class Reportmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

	    public function getResumen($data){
	    	$pdo = new Conexion();

	    	// Año actual
	    	$cmd = '
	    		SELECT SUM(amount) AS venta_total FROM `order` WHERE order_date BETWEEN :inicio AND :fin
	    	';

	    	$parametros = array(
	    		':inicio' 	=> $data['anioActual'].'-01-01 00:00:00',
	    		':fin' 		=> $data['anioActual'].'-12-31 23:59:59'
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			$result['anioActual'] = $sql->fetch();

			// Año pasado
			$cmd = '
	    		SELECT SUM(amount) AS venta_total FROM `order` WHERE order_date BETWEEN :inicio AND :fin
	    	';

	    	$parametros = array(
	    		':inicio' 	=> $data['anioPasado'].'-01-01 00:00:00',
	    		':fin' 		=> $data['anioPasado'].'-12-31 23:59:59'
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			$result['anioPasado'] = $sql->fetch();

			return $result;
	    }
	}