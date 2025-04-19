<?php


setcookie('auth_id' , 0 , [
	'expires' => time() - (3600 * 24),
	'path' => '/',
]);


header('location: ../');
exit();