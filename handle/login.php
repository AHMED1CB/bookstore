<?php 

require '../database/execute.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

	$email = trim($_POST['email'] ?? '');

	$password = trim($_POST['password'] ?? '');

	$errors = [];

	// Validation 
	
	if (!filter_var($email , FILTER_VALIDATE_EMAIL)){
	
		$errors['email'] = "Invalid Email";
	
	}


	if (strlen($password) < 8){
	
		$errors['password'] = "Password Must Be At Least 8 Characters";
	
	}

	


	if (empty($errors)){
	
	$attemp = DB::run('SELECT `id` FROM `users` 
					   WHERE `email` = :email AND `password` = :pass' , 
		['email' => $email , 'pass' => md5($password)]);


	if ($attemp['rowCount'] > 0){

		$id = $attemp['results'][0]['id'];

		$time =  time() + (24 * 3600);


		setCookie('auth_id' , $id, [
		
			'path' => '/',

			'expires' => time() + (24 * 3600),
			
			'httponly' => True, // Make inaccessible to JavaScript	!! Important

		]);


		header('location: /');

		exit();

	}else{

		$errors['auth'] = "Invalid Data Or User Not Registerd";
		
		$_SESSION['errors'] = $errors;

		header('location: /login');
		
		exit();		


	}

	}else{

		$_SESSION['errors'] = $errors;

		header('location: /register');
		exit();
	}




}