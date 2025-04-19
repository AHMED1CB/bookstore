<!DOCTYPE html>
<html>
<head>
	<?php 
		require('../_includes/head.php');
		
		require('../database/execute.php');
		
		session_start();
		
		session_destroy();

		if(!isset($_COOKIE['auth_id'])){
			header('location: /');
			exit();
		}



		$categories = DB::run('SELECT * FROM `categories` LIMIT 10')['results'];

		// print_r($categories);

		// die();
	?>
	<title>Bookhunter - Upload Book</title>
</head>
<body>

	<?php include('../_includes/mainHeader.php')?>



	<main class="upload-book ">
	
	<?=isset($_SESSION['error'])  ?
		 '<div class="alert my-3 alert-danger w-75 fw-bold m-auto">'.
				$_SESSION["error"]
		 .'</div>' : ""?>
	
		
		<h2 class="heading section-title m-auto mb-5 text-secondary fw-bold">
			Upload A New Book
		</h2>

		<div class="container">
			
			<form enctype="multipart/form-data"
				  class="form-data" action="/handle/book.php" 
				  method="POST" id="uploadForm">
				
				<div class="input-col mb-3">
					<label for="bk_t" class="fs-5 mb-2 px-2">Book Title</label>
					<input name="title" id="bk_t" type="text" required 
						   class="book-title fs-5 form-control bg-dark text-light" 
						   placeholder="Book Title" accept="image/*" />
				</div>


				<div class="input-col mb-3">
					<label for="bk_d" class="fs-5 mb-2 px-2">Book Desception</label>
					<textarea name="descreption" id="bk_d" type="text" required 
							 class="book-title fs-5 form-control bg-dark text-light" 
							 placeholder="Book Descreption" /></textarea>
				</div>

				<div class="inputs-col mb-3">
					<label for="bk_cat" class="fs-5 mb-2 px-2">Book Category</label>
					
					<select name="category" required id="bk_cat" 
							class="form-select form-select-lg bg-dark text-light">
							
						<option  
							value="<?=$categories[0]['id']?>">
								<?=$categories[0]['name']?>
									
							</option>

						<!-- Loop To Display Categories -->

						<?php foreach (array_slice($categories,1) as $category):?>

						<option  value="<?=$category['id']?>"><?=$category['name']?></option>

						<?php endforeach;?>

					</select>
				</div>


				<div class="coverImage w-25 m-auto d-none">
					<img class="w-100 rounded-3" src="" id="cover-img">
				</div>

				<div class="input-col mb-3 d-flex gap-3">
					<label for="bk_c" class="fs-5 my-3  w-50 p-2 rounded-3 input-file">
						Book Cover
					</label>

					<label for="bk_f" class="fs-5 my-3  w-50 p-2 rounded-3 input-file">
						Book PDF File 
					</label>
				</div>

				<div class="inputs-col mb-3">
					<input name="cover" id="bk_c" 
						   accept="image/*" type="file" 
						   required class="d-none"/>
					
					<input id="bk_f" name="book"
							accept="application/pdf" type="file"
							required class="d-none" />
				</div>

				<button class="btn-save btn text-light d-block  my-3 fs-5">
					Upload
				</button>

			</form>

		</div>

	</main>


	
<div class="modal fade " id="my_modal" data-bs-backdrop="static" 	data-bs-keyboard="false" tabindex="-1" 
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


<script src="../assets/js/book.js"></script>

</body>
</html>