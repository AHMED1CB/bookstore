<?php

$searchQuery =  strtolower(trim($_GET['q'] ?? ''));




require '../database/execute.php';

$getBooks = DB::run('
		SELECT b.* , 
			u.username as author ,
			u.id as author_id,
			c.name as category

				 FROM `books` b
				 INNER JOIN 
				 categories c ON b.category_id = c.id
				 INNER JOIN users u  ON b.author = u.id
				 WHERE title LIKE :search OR descreption LIKE :search

				 LIMIT 80' ,
				  [':search' => '%'.$searchQuery.'%']);
	


$books = $getBooks['results'];





$categories = DB::run('SELECT * FROM `categories` LIMIT 10')['results'];

$authors = DB::run('SELECT  id , username FROM `users` LIMIT 10')['results'];

?>


<!DOCTYPE html>
<html>
<head>
	<?php include('../_includes/head.php')?>
	<title>Search Results</title>
</head>
<body>

	<?php 

		$isAuth = isset($_COOKIE['auth_id']);

		if ($isAuth){
		
			include('../_includes/mainHeader.php');
		
		}else{
			include('../_includes/staticHeader.php');
		}

		?>

<section class="books-section">

	<div class="container">
		
			<form class="search" action="/search" method="GET">
				<input class="search-input form-control" required name="q" placeholder="Search in Books" value="<?=trim($_GET['q'] ?? '')?>" />
				<button class="btn"><img src="/assets/images/search.svg"></button>
			</form>


		<h2 class="section-title heading my-3 mx-auto  text-center fs-1 my-2 text-secondary fw-bold">
			Search Results (<?=count($books)?>)
		</h2>
		<main class="books  w-100  p-2 ">
			<div class="content d-flex  w-100 h-100  gap-5">
				

				<div class="books-content   w-100 ">
						<!-- Start Loop To Display Books -->


					<?php foreach($books as $book): ?>			

						<div class="book ">
						
							<div class="book-cover"><img src="<?='/storage/covers/'.$book['cover']?>"></div>

							<div class="book-info   w-100 mb-2">
								<h2 class="book-title  px-3  h4 my-2 text-center"><?=$book['title']?></h2>

		
								<a href="/user/?user=<?=$book['author_id']?>" class="author text-decoration-underline w-100  px-3 d-block  my-2" >
										<?=$book['author']?>
										
									</a>
									
								
								<p class="descreption"><?=$book['descreption']?>...</p>
							
							</div>
							<div class="book-acts atcs p-2">
								<a class="btn btn-light d-block" href="/books?book=<?=$book['id']?>">View</a>
							</div>
					</div>

				<?php endforeach?>

				</div>

			</div>

		</main>

	</div>
	
</section>

</body>
</html>