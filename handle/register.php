<?php 

session_start();

require '../database/execute.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST'){



	$username = trim($_POST['username'] ?? '');

	$email = trim($_POST['email'] ?? '');
	
	$password = trim($_POST['password'] ?? '');
	
	$password_confirm = trim($_POST['password_confirm'] ?? '');

	$errors = [];

	// Validation 

	if (empty($username)){
		$errors['username'] = "Invalid Username";
	}

	if (!filter_var($email , FILTER_VALIDATE_EMAIL)){
		$errors['email'] = "Invalid Email";
	}

	if (strlen($password) < 8){
		$errors['password'] = "Password Must Be At Least 8 Characters";
	}

	if ($password_confirm != $password){
		$errors['password_confirm'] = "Password Confirmation Doesn’t Match";
	}

	
	if (empty($errors)){
	
	$checkRegister = DB::run('SELECT `username` FROM `users` 
							  WHERE `email` = :email' , ['email' => $email]);


	if ($checkRegister['rowCount'] > 0){

		$errors['auth'] = "User With this Email Already Registerd";
		
		$_SESSION['errors'] = $errors;
		
		header('location: /register');
		
		exit();		
	
	}else{

		// Create User Record In Database
		$id = sha1(uniqid('user'));
		$register = DB::run('
			
			INSERT INTO `users` (`id`,`username` , `email` , `password`) 
			
			VALUES (:id , :username , :email , :password) ',[
				':id' => $id ,
				
				':username' => $username ,
				':email' => $email ,
				
				':password' => md5($password) // Can Use Sha1 To Make Password Hashed Too
			]);


		if ($register){

			header('location: /login');
			
			exit();
		}

	}

	}else{

		$_SESSION['errors'] = $errors;

		header('location: /register');

		exit();
	}




}