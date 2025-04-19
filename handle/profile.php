<?php

// Api To Edit Profile

require '../database/execute.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_COOKIE['auth_id'])){

	$username = trim($_REQUEST['username'] ?? '');

	$bio = trim($_REQUEST['bio'] ?? '');

	$queury = "UPDATE `users` SET ";

	$data = ['username' => $username , 'bio' => $bio];
	
	$params = [];

	foreach ($data as $colName => $colValue) {
				
		if ($colValue){
			$queury .= "$colName = :$colName ,";
			$params[$colName] = $colValue;
		}

	}


	if (isset($_FILES['photo'])){
		
		$file = $_FILES['photo'];

		$dir = '../storage/users/';

		$ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

		$name = uniqid('user_photo') . '.' .$ext;
		
		$fullPath = $dir.$name;


		if(move_uploaded_file($file['tmp_name'], $fullPath)){
			$queury .= '`photo` = :photo ,';
			$params[':photo'] = $name;
		}

	}

	if ($queury[-1] == ','){
		$queury = substr($queury, 0 , -1);
	}
	
	$queury .= 'WHERE `id` = :id';

	$params[':id'] = $_COOKIE['auth_id'];


	// Execute Query

	$updateData = DB::run($queury , $params);

	if ($updateData){
		
		echo (json_encode(['message' => 'User Updated Successfully' , "data" => $data]));

	}


}
