<?php

require_once('connection.php');


class DB{


	public static function run($sql , $params = []){

		global $connection;

		$query = $connection->prepare($sql);

		if ($query->execute($params)){
			$results = $query->fetchAll(PDO::FETCH_ASSOC);
			return [
				'rowCount' => $query->rowCount(),
				'results' => $results ,
			];
		}	

		



	}

};