<?php
session_start();

require '../database/execute.php';

$book_id = trim($_GET['book'] , '');

$user_id = trim($_COOKIE['auth_id'] , '');

if (!$user_id or !$book_id){
	header('location: ../profile');
	exit();
}

$userVId = DB::run('SELECT `user_id` FROM `users` 
					WHERE `id` = :id ' , ['id' => $user_id])['results'][0]; 

$getBook = DB::run('SELECT id FROM `books` 
					WHERE id = :bId AND author = :aId' ,
 				  [':bId' => $book_id,':aId' => $userVId['user_id']]);


if ($getBook['rowCount'] !== 0 ){

	DB::run('DELETE FROM `books` WHERE id = :id' , ['id' => $book_id]);

	header('location: ../profile');
	exit();
}else{

	$_SESSION['error'] = "Unable To Delete Book";

	header('location: ../profile');
	exit();

}

