<?php 

require '../database/execute.php';


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){


	$title = trim($_POST['title']??'');

	$descreption = trim($_POST['descreption']??'');
	
	$category = $_POST['category']?? 0 ;
 	
 	$cover = $_FILES['cover'];
 	
 	$book = $_FILES['book'];

 	$filesUploaded = false;
 	
 	$bookName = '';
 	
 	$coverName = '';

 	// Uploading Files

 	$booksPath = '../storage/books/';

 	$coversPath = '../storage/covers/';

 	// If File Is Large You Must Change upload_max_filesize In php.ini
 	if ($cover['size'] > 0 && $book['size'] > 0){


 		$coverTemp = $cover['tmp_name'];
 		$currentCoverName = $cover['name'];

 		$ext = pathinfo($currentCoverName , PATHINFO_EXTENSION);

 		$coverName = uniqid('book_cover') . '.' . $ext;
 		$fullCoverPath = $coversPath . $coverName;
 		
		$bookTemp = $book['tmp_name'];

 		$bookName = uniqid('book') . '.' . 'pdf';

 		$fullBookPath = $booksPath . $bookName;
 		
 		

 		if (move_uploaded_file($bookTemp , $fullBookPath) &&
 			move_uploaded_file($coverTemp , $fullCoverPath)){

 			$filesUploaded = true;

 		}


 		if ($filesUploaded){

 			// Insert Database Record

 			$id = $_COOKIE['auth_id'];

 			$user = DB::run('SELECT `user_id` FROM `users` 
 							WHERE `id` = :id ' , 
 				['id' => $id])['results'][0];

 			$author = $user['user_id'];

 			$query = "INSERT INTO `books` 
 					(`title` , `descreption` , `cover` , `book` , `author` , `category_id`) 
 					VALUES 
 					(:title , :descreption , :cover , :book , :author , :category)";

 			$params = [
 					  ':title' => $title , 
 					  ':descreption'   => $descreption ,
 					  ':cover'  => $coverName,
 					  ':book'   => $bookName ,
 					  ':author' => $author ,
 					  ':category' => $category ,
 					];

 				try{
 					
 					$insert = DB::run($query , $params);
 				
 				}catch(\Exception $e){

 					$_SESSION['error'] = 'Somthing Went Wrong ';

	 				header('location: ../book');
	 				exit();
 				}

 			if (!$insert){
 				$_SESSION['error'] = 'Somthing Went Wrong ';

 				header('location: ../book');
 				exit();
 			}else{
 				header('location: ../profile');
 				exit();
 			}




 		}

 		return;
 	};



 		$_SESSION['error'] = 'Invalid Cover Or Book File ';

 		header('location: ../book');
 		exit();


}