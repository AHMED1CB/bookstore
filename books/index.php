<?php 

include '../database/execute.php';


$getBook = DB::run("
        SELECT b.* , c.name  as `category`, u.username as `author`, u.user_id as author_id

        FROM books b 
            INNER JOIN categories c ON c.id = b.category_id
            INNER JOIN users u ON u.user_id = b.author
            WHERE b.id = :id
    " , [':id' => trim($_GET['book'] ?? '0')]);



if ($getBook['rowCount'] > 0){
    $book = $getBook['results'][0];
}else{
    header('location: ../');
    exit();
}


$file_size = filesize('../storage/books/'  . $book['book']);


function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

?>

<!DOCTYPE html>
<html >
<head>

    <?php include('../_includes/head.php')?>
    <link rel="stylesheet" type="text/css" href="../assets/css/book.css">
    <title>Bookhunter - Book</title>    
</head>
<body>


    <?php 
        // Check Auth

        $isAuth = isset($_COOKIE['auth_id']);

        if ($isAuth){
        
            include('../_includes/mainHeader.php');
        
        }else{
            include('../_includes/staticHeader.php');
        }


    ?>


    <div class="book-page">
        <div class="book-header">
            <h1>Book Preview</h1>
        </div>
        
        <div class="book-content">
            <div class="book-cover-container">
                <!-- Book Cover Is Required So We Dont Need To Check -->
                <img src="<?='../storage/covers/'. $book['cover']?>" alt="Cover" class="book-cover">
            </div>
            
            <div class="book-details">
                <h2 class="book-title"><?=substr(htmlspecialchars($book['title']), 0 , 40)?></h2>
                
                <a class="book-author mb-34 d-block" href="/user/?user=<?=$book['author_id']?>" style="color: var(--secondary) !important;"><?=htmlspecialchars($book['author'])?></a>
                
                <div class="book-meta">
                    <div class="meta-item">
                        <span>cartegory: <?=$book['category']?> </span>
                    </div>
                    <div class="meta-item">
                        <span>size: <?=formatSizeUnits($file_size)?> </span>
                    </div>
                    <div class="meta-item">
                        <span>date: <?=$book['created_at']?> </span>
                    </div>
                </div>
                
                <div class="book-description my-5">
                    <p>
                        <?=htmlspecialchars($book['descreption'])?>
                    </p>
                </div>
                
                <div class="book-actions">
                    <a class="btn btn-download btn-lg" download="<?=substr($book['title'], 0 , 12)?>" href="../storage/books/<?=$book['book']?>">
                        Download
                    </a>
                    <a class="btn btn-preview btn-lg" href="../storage/books/<?=$book['book']?>" 
                    target="_blank">
                        Preview
                    </a>
                </div>
            </div>
        </div>
        
   
</body>
</html>