<!DOCTYPE html>
<html>
<head>
	<?php 

	if (isset($_COOKIE['auth_id'])){
		header('location: /profile');
		exit();
	}

	session_start();

	session_destroy();

	require('../_includes/head.php')
	?>

	<title>BookHunter - Login</title>
</head>
<body class="bg-dark text-light ">
	
	<?php include '../_includes/staticHeader.php';?> 


	<?=isset($_SESSION['errors']['auth']) ?
		 '<div class="alert w-75 mx-auto my-2 fixed-top fw-bold alert-danger" role="alert">
		 		'.$_SESSION['errors']['auth'].'
		 </div>' 
		 : ''?>

	<main class="form container w-75 mt-5">
		<h4 class="heading text-center mb-4">Login To BookHunter</h4>
		<form action="/handle/login.php" method="POST">
		  
		  <div class="mb-3">
		 
		    <label for="email" class="form-label">Email address</label>
		 <bold class="error text-danger">
		 			<?=isset($_SESSION['errors']['email']) ?
		 					 $_SESSION['errors']['email']  : '' ?>
		 		</bold>
		    <input type="email" 
		    	required name="email"
		    	placeholder="Email" class="form-control" id="email">
		  
		  
		  </div>
		 
		  <div class="mb-3">
		 
		    <label for="password" class="form-label">Password</label>
		 
		    <input required  type="password"
		    	 name="password" placeholder="Password"
		    	 class="form-control" id="password">
		 
		  </div>
		 
		  <a class="register mb-3 d-block text-decoration-underline" href="/register">
		  Dont Have an Account? Register
		</a>

		  <button type="submit" class="btn btn-light w-100">Login</button>
		</form>
	</main>

</body>
</html>