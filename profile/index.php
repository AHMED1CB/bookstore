<?php 

session_start();

// To Show Errors First Time Only

session_destroy();

require '../database/execute.php';
// Get User Data

$id = $_COOKIE['auth_id'];

$user = DB::run('SELECT `username` , `bio` , `photo` , `user_id`
                 FROM `users` WHERE `id` = :id' , ['id' => $id])['results'][0];


if (!$user){
    // Delete Cookie

    setCookie('auth_id' , 0 , [
        'expires' => time() - (3600 * 3) 
    ]);
    
    header('location: /login');
    exit();
}

$books = DB::run('
        SELECT LEFT(`title` , 40) as title ,
                 `book` ,
                `cover` , b.id as `book_id` ,
                
                 LEFT(descreption , 90) as descreption , c.name AS `category`
                                
                 FROM `books` b INNER JOIN 
                
                 `categories` c ON b.category_id = c.id
                                
                 WHERE author = :id LIMIT 20

' , ['id' => $user['user_id']])['results'];


// print_r($user);
// die();

?>

<!DOCTYPE html>
<html>
<head>
    <?php include('../_includes/head.php')?>
    <link rel="stylesheet" type="text/css" href="../assets/css/profile.css">
    <title><?=substr($user['username'], 0 , strpos($user['username'] , ' ')) 
            ?? $user['username'] ?> Profile</title>
</head>
<body>

    <?php include('../_includes/mainHeader.php')?>
    

        <?=
        isset($_SESSION['error']) ?
            '<div class="atert alert-danger fixed-top p-3 fw-bold " style="z-index:878765">
                '.$_SESSION['error'].
            '</div>' :''?>

    <div class="container py-4">

        <section class="profile-section text-center mb-5">
            <img src="<?=$user['photo'] ? "../storage/users/" . $user['photo'] : '../assets/images/person.jpg'?>" class="profile-pic img-thumbnail" alt="Profile Photo">
            
            <div class="mt-3">
                <h1 class="profile-name"><?=htmlspecialchars($user['username'])?></h1>
                <p class="profile-bio mx-auto mb-4">
                   <?=htmlspecialchars($user['bio']) ?? 'No Bio'?>
                </p>
                
                
                <button class="edit-btn btn btn-primary px-4">
                    Edit Profile
                </button>
            </div>
        </section>
        
        <section class="books-content mt-5 ">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title heading mx-auto text-center fs-1 my-2 text-secondary fw-bold">Books</h2>
            </div>
            
            <div class="books m-auto border-top p-3">
                        <?=count($books) === 0 ? '
                        <h2 class="no-books w-100 
                                    text-center mx-auto mt-5 text-secondary fs-1 fw-bold">
                            No Books To Show
                           </h2>
                         ':''?>
        
                <div class="books-content w-100">
        
                        <!-- Loop TO Display Books -->
                        
                        <?php foreach($books as $book): ?>          

                        <div class="book ">
                        
                            <div class="book-cover">
                                <img src="<?='/storage/covers/'.$book['cover']?>">
                            </div>

                            <div class="book-info  w-100 mb-2">
                                <h2 class="book-title  px-3  h4 my-2 text-center">
                                    <?=substr(htmlspecialchars($book['title']), 0 ,90)?>    
                                </h2>
        
                                <span class="author w-100  px-3 d-block  my-2" >
                                    <?=htmlspecialchars($user['username'])?>
                                </span>

                                
                                <p class="descreption"><?=$book['descreption']?>...</p>
                            
                            </div>
                            <div class="book-acts p-2 atcs d-flex gap-2 w-100">
                                <a class="btn btn-light d-block w-50" 
                                   href="/books?book=<?=$book['book_id']?>">
                                    View
                                </a>

                                <a class="btn btn-danger d-block w-50" 
                                    href="/handle/delete.php?book=<?=$book['book_id']?>">
                                    Delete
                                </a>
                            </div>
                    </div>

                <?php endforeach?>
                   
                </div>
                
            </div>
        </section>
    </div>


     <div class="profile-edit-container fixed-top" style="display:none">
        <div class="profile-edit-header">
            <h2>Edit Profile</h2>
        </div>
        
        <div class="position-relative ">
            <img src="<?=$user['photo'] ?
                 "../storage/users/" . $user['photo'] : 
                 '../assets/images/person.jpg'?>" 
            class="profile-pic-edit"
            id="profile_photo" alt="Profile Photo">
            
            <label class="edit-pic-btn" 
                   for="photo_changer"><img src="../assets/images/camera.svg"></label>

            <input required accept="image/*" type="file" name="photo" class="d-none" id="photo_changer">
        </div>
        
        <div class="profile-edit-body">
            <form id="edit_profile_form">
                    <div class="col">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" required class="form-control" id="username" value="<?=$user['username']?>">
                    </div>
                   
                
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea required class="form-control" id="bio" rows="3"><?=$user['bio']?? 'No Bio'?></textarea>
                </div>
                
                <div class="divider"></div>
                
                
                
                <button type="submit" class="btn btn-save">Save</button>
                <button type="button" class="btn btn-cancel">Cancel</button>
                
            </form>
        </div>
    </div>


<div class="modal fade " id="my_modal" data-bs-backdrop="static"    data-bs-keyboard="false" tabindex="-1" 
    aria-labelledby="fileErrorModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header">
            <h1  class="modal-title fs-5" id="fileErrorModal">
                <!-- By Javascript -->
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- By Javascript -->
          </div>
        </div>
      </div>
    </div>


    <script src="../assets/js/profile.js"></script>

</body>
</html>