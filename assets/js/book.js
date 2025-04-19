$(document).ready(() => {

	let coverInput = $('#bk_c');
	let pdfInput = $('#bk_f');


	let coverLable = $('[for=bk_c]')[0];
	let pdfLable = $('[for=bk_f]')[0];

	let currentCover = $('#cover-img')[0];

	let modalTitle = $('#fileErrorModal');
	let modalBody = $('.modal-body');



	function showMessage(title , body){
		$(modalTitle).html(title)
		$(modalBody).html(body)
		$('#my_modal').modal('show');
	}


	coverInput.on('change' , (event) =>{
		let file = event.target.files[0];

		if (file){

		if (file.type.startsWith('image/')){

			coverLable.innerHTML = file.name.slice(0,30)

			let reader = new FileReader();

			reader.onload = (e) => {

				currentCover.src = e.target.result;

				currentCover.parentElement.classList.remove('d-none')

			}

			reader.readAsDataURL(file)
		}else{

				showMessage('Invalid Image' , 'Book Cover Must Be An Image');

			return false;
		}

		}else{
		

			showMessage('Warning' , 'You Delete Book Cover Image');

			currentCover.src = '';
			currentCover.parentElement.classList.add('d-none')
			$(coverLable).html('Book Cover')

		}


	} )



	$(pdfInput).on('change' , (event) =>{
		let file = event.target.files[0];
		
		if (file){

			if(file.type === 'application/pdf'){

				pdfLable.innerHTML = file.name.slice(0 , 30)

			}else{
				showMessage('Invalid PDF' , 'File Must Be PDF');
				$('#my_modal').modal('show');
			}
		
		}else{
				pdfLable.innerHTML = '';	
				showMessage('Warning' , 'You Delete Current Selectd PDF File ');

		}


	} )



	// Validation

	let uploadForm = $('#uploadForm');

	let title = $('#bk_t')[0];
	let desc = $('#bk_d')[0];
	let category = $('#bk_cat')[0];

	$(uploadForm).on('submit' , (event)  =>{

		if (!title.value || !desc.value || !category.value){
			showMessage('Invalid Data' , 'Please Fill All Inputs To Submit')
			event.preventDefault();
		}

	})


})