<?php
	class Productmodel
	{
		public function __construct()
	    {
	        require_once '../dbConnection.php';
	    }

		public function register($data) {
			$pdo = new Conexion();
			$cmd = '
				INSERT INTO product
						(name, descriptions, price, sale_price, optional_name, optional_description, create_date, dimensions, active, alternatives)
				VALUES
					(:name, :descriptions, :price, :sale_price, :optional_name, :optional_description, now(), :dimensions, 1, :alternatives)
			';

			$parametros = array(
				':name' 				=> $data['inputName'],
				':descriptions' 		=> $data['inputDescription'],
				':price' 				=> $data['inputPrice'],
				':sale_price' 			=> $data['inputSalePrice'],
				':optional_name'		=> $data['inputNameSp'],
				':optional_description' => $data['inputDescriptionSp'],
				':dimensions'			=> $data['dimensions'],
				':alternatives'			=> $data['inputAlternative']
			);

			try{
				$sql = $pdo->prepare($cmd);
				$sql->execute($parametros);
				return [TRUE, $pdo->lastInsertId()];
			} catch (PDOException $e) {
		        return [FALSE, $e->getCode()];
		    }
		}

		public function updateThumbnails($productId, $thumbnails, $images) {
			$pdo = new Conexion();
			$cmd = 'UPDATE product SET thumbnail =:thumbnail, images =:images WHERE id =:productId';

			$parametros = array(
				':thumbnail' => $thumbnails,
				':productId' => $productId,
				':images'	 => $images
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function insertCategory($productId, $categoryId) {
			$pdo = new Conexion();
			$cmd = '
				DELETE FROM product_category WHERE product_id =:product_id;
				INSERT INTO  product_category (category_id, product_id) VALUES (:category_id, :product_id);
			';

			$parametros = array(
				':category_id' => $categoryId,
				':product_id' => $productId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function getProduct($limite, $categoria) {
			$pdo = new Conexion();
			$strLimite = '';
			$strWhere  = '';

			if($limite > 0)
				$strLimite = 'LIMIT 0, ' . $limite;

			if($categoria != "")
				$strWhere = ' AND p.id in (select pc.product_id from product_category AS pc where pc.category_id = (select id from category where name = "'.$categoria.'"))';


			$cmd = '
				SELECT
					p.id, 
					p.name,
					p.optional_name,
					p.descriptions, 
					p.optional_description,
					p.price,
					p.sale_price, 
					p.thumbnail, 
					p.images, 
					p.create_date,
					p.dimensions,
					p.alternatives
				FROM 
					product AS p
				WHERE p.active = 1 '.$strWhere.'
				ORDER BY p.id DESC
				'. $strLimite .'
			';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getCategories($productId) {
			$pdo = new Conexion();

			$parametros = array(
				':product_id' => $productId
			);

			$cmd = 'SELECT id, name FROM category WHERE id = ( select category_id from product_category where product_id =:product_id )';
			
			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);
			$sql->setFetchMode(PDO::FETCH_OBJ);

			return $sql->fetch();
		}

		public function deleteProduct($productId) {
			$pdo 	= new Conexion();
			$cmd 	= 'UPDATE product SET active = 0 WHERE id =:productId';

			$parametros = array(
				':productId' => $productId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return TRUE;
		}

		public function updates($data) {
			$pdo = new Conexion();
			$cmd = '
				UPDATE product SET
					name =:name, 
					optional_name =:optional_name,
					descriptions =:descriptions, 
					optional_description =:optional_description,
					price =:price, 
					sale_price =:sale_price,
					dimensions =:dimensions,
					alternatives =:alternatives
				WHERE id =:productId
			';

			$parametros = array(
				':name' 				=> $data['inputName'],
				':descriptions' 		=> $data['inputDescription'],
				':price' 				=> $data['inputPrice'],
				':sale_price' 			=> $data['inputSalePrice'],
				':optional_name'		=> $data['inputNameSp'],
				':optional_description' => $data['inputDescriptionSp'],
				'productId'				=> $data['productId'],
				':dimensions'			=>  $data['dimensions'],
				':alternatives'			=> $data['inputAlternative']
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return [ TRUE, $data['productId'] ];
		}

		public function getProductId($productId) {
			$pdo = new Conexion();

			$cmd = '
				SELECT
					id, 
					name,
					optional_name,
					descriptions, 
					optional_description,
					price,
					sale_price, 
					thumbnail, 
					images, 
					create_date,
					dimensions,
					alternatives
				FROM 
					product
				WHERE active = 1 AND id =:id
			';

			$parametros = array(
				':id' => $productId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getProductCat($categoryId) {
			$pdo = new Conexion();

			$cmd = '
				SELECT
					id, 
					name,
					optional_name,
					descriptions, 
					optional_description,
					price,
					sale_price, 
					thumbnail, 
					images, 
					create_date,
					dimensions,
					alternatives
				FROM 
					product
				WHERE active = 1
					AND id IN (SELECT product_id FROM product_category WHERE category_id =:categoryId)
				ORDER BY id DESC
			';

			$parametros = array(
				':categoryId' => $categoryId
			);

			$sql = $pdo->prepare($cmd);
			$sql->execute($parametros);

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function search($query) {
			$pdo = new Conexion();

			$cmd = '
				SELECT
					id, 
					name,
					optional_name,
					descriptions, 
					optional_description,
					price,
					sale_price, 
					thumbnail, 
					images, 
					create_date,
					dimensions,
					alternatives
				FROM 
					product
				WHERE active = 1
					AND name LIKE "%'. str_replace(' ', '%', $query) .'%"
				ORDER BY id DESC
			';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getCarouselData(){
			$pdo = new Conexion();
			$indexes = '';

			$cmd = 'SELECT value FROM setting WHERE parameter = "prodcarousel"';
			$sql = $pdo->prepare($cmd);
			$sql->execute();
			$dato = $sql->fetch(PDO::FETCH_ASSOC);

			if($dato){
				$tmp = json_decode($dato['value']);

				foreach ($tmp as $key => $value) {
					$indexes .= $value .', ';
				}

				$indexes = substr($indexes, 0, -2);				
			}

			$cmd = '
				SELECT
					id, 
					name,
					optional_name,
					descriptions, 
					optional_description,
					price,
					sale_price, 
					thumbnail, 
					images, 
					create_date,
					dimensions,
					alternatives
				FROM 
					product
				WHERE id in ('.$indexes.')
			';

			$sql = $pdo->prepare($cmd);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}