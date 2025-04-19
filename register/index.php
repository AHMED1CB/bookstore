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
<body 
	class="bg-dark text-light ">

	<?php include '../_includes/staticHeader.php';?>

	<?=isset($_SESSION['errors']['auth']) ? 
				'<div class="alert w-75 mx-auto my-2 fixed-top fw-bold alert-danger" role="alert">
						'.$_SESSION['errors']['auth'].'
				</div>'

											: ''?>

	<main class="form container w-75 mt-5">

		
		<h4 class="heading text-center mb-4">Create Account</h4>

		<form action="/handle/register.php" method="POST">
		  
		  <div class="collection d-flex w-100 gap-2 flex-column flex-md-row">
		  	
			<div class="mb-3 w-100 w-md-50">
		 
		    <label for="username" class="form-label">Username</label>
		 	
		 	<bold class="error text-danger">
		 		<?=isset($_SESSION['errors']['username']) ? 
		 		$_SESSION['errors']['username'] : ''?>
		    </bold>
		    <input type="text" required name="username" placeholder="Username" class="form-control" id="username" aria-describedby="
		    emailHelp">
		  
		  
		  </div>

		  <div class="mb-3 w-100 w-md-50">
		 	
		    <label for="email" class="form-label">Email address</label>
		 	
		 		<bold class="error text-danger">
		 			<?=isset($_SESSION['errors']['email']) ? 
		 					 $_SESSION['errors']['email']  : '' ?>
		 		</bold>
		    <input required type="email" name="email" placeholder="Email" class="form-control" id="email" aria-describedby="
		    emailHelp">
		  
		  
		  </div>
		  </div>
		 
		  <div class="mb-3">
		 
		    <label for="password" class="form-label">Password</label>
		 
		 	<bold class="error text-danger" >
		 			<?=isset($_SESSION['errors']['password']) ?
		 					 $_SESSION['errors']['password']  : '' ?>
		 
		 	</bold>
		    <input  type="password" name="password"  required placeholder="Password" class="form-control" id="password">
		 
		  </div>
		 
		   <div class="mb-3">
		 
		    <label for="psconfirm" class="form-label">Password Confirmation</label>
		 	
		 	<bold class="error text-danger">
		 		<?=isset($_SESSION['errors']['password_confirm']) ?
		 				 $_SESSION['errors']['password_confirm']  : '' ?>
		 	</bold>
		 
		    <input  required type="password" name="password_confirm"  placeholder="Password Confirmation" class="form-control" id="psconfirm">
		 
		  </div>

		  <a class="register mb-3 d-block text-decoration-underline" href="/login">
		  		Already Have an Account? Login
		  </a>

		  <button type="submit" class="btn btn-light w-100">Login</button>
		</form>
	</main>

</body>
</html>