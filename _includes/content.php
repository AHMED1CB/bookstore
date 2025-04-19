<?php 

require('database/execute.php');

$filters = [];

$params = [];

$allFilters = ['author' => 'author' , 'category_id' => 'category' ];

$titleTxt = 'Books';

foreach($allFilters as $filter => $name){
	
	// Check If Any Filter Exists And Apply It On Query

	if(isset($_GET[$filter])){

		$validatedValue = preg_replace('/[^0-9]/', '', $_GET[$filter]);
		

		if (!empty($validatedValue)){
			
			$titleTxt = "Filter Results";

			$filters[0] = 'WHERE ';

			$filters[] =  " b.$filter = $validatedValue";
			
			$filters[] = ' AND';
			
			$params[":$filter"] = $_GET[$filter];

		}


	}

}


$filters = array_splice($filters, 0 , -1);

$getBooks = DB::run('
		SELECT b.* ,
		 		 u.user_id as `author_id`, 
		 		 
		 		 c.name AS `category`,
		 		 
		 		 u.username as `author` 
				 
				 FROM `books` b 
				 
				 INNER JOIN  `categories` c ON b.category_id = c.id
				 
				 INNER JOIN `users` u ON b.author = u.user_id '.implode('', $filters).' LIMIT 80');



$books = $getBooks['results'];

$categories = DB::run('SELECT * FROM `categories` LIMIT 10')['results'];

$authors = DB::run('SELECT `user_id` as `vid` , `id` , `username` FROM `users` LIMIT 10')['results'];



// For Check
// print_r($authors);
// die();


?>


<section class="books-section">

	<div class="container">
		
			<form class="search" action="/search" method="GET">
				<input class="search-input form-control" required name="q" placeholder="Search in Books" />
				<button class="btn"><img src="/assets/images/search.svg"></button>
			</form>


		<h2 class="section-title heading my-3 mx-auto  text-center fs-1 my-2 text-secondary fw-bold">
			<?=$titleTxt?> (<?=count($books) // Count Books?>)
		</h2>
		<main class="books  w-100  p-2 ">
			<div class="content d-flex  w-100 h-100  gap-5">
				

				<div class="books-content   w-100 w-lg-75">

					<!-- Start Loop To Display Books -->

					<?php foreach($books as $book): ?>			

						<div class="book ">
						
							<div class="book-cover">
								<!-- Book Cover Is Required So We Dont Need To Check -->
								<img src="<?='/storage/covers/'.$book['cover']?>">
							</div>

							<div class="book-info w-100 mb-2">
								
								<h2 class="book-title  px-3  h4 my-2 text-center">
										<?=substr(htmlspecialchars($book['title']), 0 , 40)?>		
								</h2>

		
								<a href="/user/?user=<?=$book['author_id']?>" 
									class="author text-decoration-underline 
									       w-100 px-3 d-block my-2" >
										
										<?=htmlspecialchars($book['author'])?>
									</a>
									
								
								<p class="descreption">
									<?=substr(htmlspecialchars($book['descreption']), 0 , 90)?>...
								</p>
							
							</div>
							<div class="book-acts atcs p-2">
								<a class="btn btn-light d-block" 
								 href="/books?book=<?=$book['id']?>">
								 	View
								</a>
							</div>
					</div>

				<?php endforeach?>

				</div>

			<div  class="filters d-none d-lg-flex flex-column flex-start h-100">
				

			<div class="categories-filters mt-2 w-100 ">

				<ul class="list-group w-100 h-100">
				
				  <li class="list-group-item text-center fs-5 fw-bold bg-light text-dark" 
				  	aria-current="true">Categories</li>

					<!-- Display Categories -->
					
					<?php foreach ($categories as $category):?>
				  			<li class="list-group-item bg-dark">
				  				<!-- Category Filter -->
				  				<a class="filter-category w-100 d-block"
				  				   href="?category_id=<?=$category['id']?>">
				  					
				  					<?=substr($category['name'], 0 , 40)?>
				  				
				  				</a>
				  			</li>
					<?php endforeach;?>
				</ul>
			</div>
			
			<div class="authors-filters mt-4 w-100 ">
				<ul class="list-group w-100 h-100">
				
				  <li class="list-group-item text-center fs-5 fw-bold bg-light text-dark" 
				  		aria-current="true">Authors</li>
					
					<?php foreach ($authors as $author):?>
				  	
				  			<li class="list-group-item bg-dark">
				  	
				  				<a class="filter-author w-100 d-block"
				  				   href="?author=<?=$author['vid']?>">
				  					
				  					<?=htmlspecialchars(substr($author['username'] , 0  , 40))?>
				  					
				  					<!-- Show (You) Word If Author Is The Current User -->

				  					<?=(isset($_COOKIE['auth_id']) &&
				  						$author['id'] == $_COOKIE['auth_id']) ?
				  						 ' (You)' : ''?>
				  				</a>
				  			</li>
					<?php endforeach;?>
				</ul>
			</div>

			</div>
			</div>

		</main>

	</div>
	
</section>