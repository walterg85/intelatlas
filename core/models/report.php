<?php
	class Reportmodel {
		public function __construct() {
	        require_once '../dbConnection.php';
	    }

	    public function getResumen($data){
	    	$pdo = new Conexion();

	    	// Año actual
	    	$cmd = '
	    		SELECT
	    			(SELECT SUM(amount) FROM `order` WHERE status > 0 AND order_date BETWEEN :inicio AND :fin) AS venta_total,
	    			(SELECT SUM(importe) FROM `invoice` WHERE estatus IN(1,2) AND activo = 1 AND fecha BETWEEN :inicio AND :fin) AS venta_factura,
	    			(SELECT SUM(importe) FROM `invoice` WHERE estatus IN(1) AND activo = 1 AND fecha BETWEEN :inicio AND :fin) AS adeudos;
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
	    	$parametros = array(
	    		':inicio' 	=> $data['anioPasado'].'-01-01 00:00:00',
	    		':fin' 		=> $data['anioPasado'].'-12-31 23:59:59'
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			$result['anioPasado'] = $sql->fetch();

			// Mes actual

	    	$parametros = array(
	    		':inicio' 	=> $data['anioActual'].'-'. $data['mesActual'] .'-01 00:00:00',
	    		':fin' 		=> $data['anioActual'].'-'. $data['mesActual'] .'-'. $data['ultimoDiaMes'] .' 23:59:59'
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			$result['mesActual'] = $sql->fetch();

			// Semana actual
	    	$parametros = array(
	    		':inicio' 	=> $data['anioActual'].'-'. $data['mesActual'] .'-'. $data['primerDiaSemana'] .' 00:00:00',
	    		':fin' 		=> $data['anioActual'].'-'. $data['mesActual'] .'-'. $data['ultimoDiaSemana'] .' 23:59:59'
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			$result['semanaActual'] = $sql->fetch();

			return $result;
	    }

	    public function getResumenMonth($data){
	    	$pdo = new Conexion();

	    	$cmd = '
	    		SELECT
		    		(SELECT SUM(amount) FROM `order` WHERE status > 0 AND order_date LIKE :fecha) AS total_venta,
		    		(SELECT SUM(importe) FROM `invoice` WHERE estatus IN(1,2) AND activo = 1 AND fecha LIKE :fecha) AS venta_factura;
	    	';

	    	$parametros = array(
	    		':fecha' => $data . '%'
	    	);

	    	$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
	    }
	}