<!DOCTYPE html>
<html>
<head>
	<?php include('_includes/head.php')?>

	<title>BookHunter Book Store</title>

</head>
<body>

	<!-- Header -->

	<?php 
		// Check Auth (Basic)

		$isAuth = isset($_COOKIE['auth_id']);
		if ($isAuth){
		
			include('_includes/mainHeader.php');
		
		}else{
			include('_includes/staticHeader.php');
		}


	?>


	<!-- End Header -->

	<!-- Content --> 
		<?php include('_includes/content.php') ?>
	<!-- End Content -->




</body>
</html>