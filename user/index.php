<?php 

// Get User Data

require '../database/execute.php';
if(!isset($_GET['user'])){
    header('location: /');
    exit();
}

$id = $_GET['user'];


$user = DB::run('SELECT `username` , `bio` , `photo` , `id`
                 FROM `users` WHERE `user_id` = :id' , ['id' => $id])['results'][0];

if ($user['id'] === $_COOKIE['auth_id']){
    header('location: /profile');
    exit();
}

if (!$user){

    header('location: /');
    
    exit();
}

$books = DB::run('
        SELECT `title` , `book` ,
                `cover` , b.id as `book_id` ,
                
                 `descreption` , c.name AS `category`
                                
                 FROM `books` b INNER JOIN 
                
                 `categories` c ON b.category_id = c.id
                                
                 WHERE author = :id LIMIT 20

' , ['id' => $id])['results'];


// print_r($user);
// die();

?>

<!DOCTYPE html>
<html lang="ar" >
<head>
    <?php include('../_includes/head.php')?>
    <link rel="stylesheet" type="text/css" href="../assets/css/profile.css">
    <title>
            <?=substr($user['username'], 0 , strpos($user['username'] , ' ')) 
            ?? $user['username'] ?> Profile
    </title>
</head>
<body>

    <?php include('../_includes/mainHeader.php')?>
    
    <div class="container py-4">

        <section class="profile-section text-center mb-5">
            <img src="<?=$user['photo'] ? "../storage/users/" . $user['photo'] : '../assets/images/person.jpg'?>" class="profile-pic img-thumbnail" alt="Profile Photo">
            
            <div class="mt-3">
                <h1 class="profile-name"><?=$user['username']?></h1>
                <p class="profile-bio mx-auto mb-4">
                   <?=$user['bio'] ?? 'No Bio'?>
                </p>
                
            </div>
        </section>
        
        <section class="books-section mt-5 ">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title heading mx-auto text-center fs-1 my-2 text-secondary fw-bold">Books</h2>
            </div>
            
            <div class="books m-auto border-top p-3">
                        <?=count($books) === 0 ? '<h2 class="no-books w-100 text-center mx-auto mt-5 text-secondary fs-1 fw-bold">No Books To Show</h2>':''?>
                <div class="books-content w-100">
        
                        <!-- Loop TO Display Books -->
                        <?php foreach($books as $book): ?>          

                        <div class="book ">
                        
                            <div class="book-cover"><img src="<?='/storage/covers/'.$book['cover']?>"></div>

                            <div class="book-info  w-100 mb-2">
                                <h2 class="book-title  px-3  h4 my-2 text-center"><?=substr($book['title'], 0 ,90)?></h2>
        
                                <span class="author w-100  px-3 d-block  my-2" >~ <?=$user['username']?></span>

                                
                                <p class="descreption"><?=$book['descreption']?>...</p>
                            
                            </div>
                            <div class="book-acts p-2 atcs d-flex gap-2 w-100">
                                <a class="btn btn-light d-block w-100" href="/books?book=<?=$book['book_id']?>">View</a>
                            </div>
                    </div>

                <?php endforeach?>
                   
                </div>
                
            </div>
        </section>
    </div>


</body>
</html>