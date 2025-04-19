$(document).ready(() => {

	let editBtn = $('.edit-btn')
	let editContainer = $('.profile-edit-container');
	let cancel = $('.btn-cancel')


	let modalTitle = $('#fileErrorModal');
	let modalBody = $('.modal-body');


	editBtn.click(() => {
		$(editContainer).fadeToggle()
	})

	cancel.click(() => {
		$(editContainer).fadeToggle()
	})


	//  Change Photo

	let inputFile = $('#photo_changer');

	let currentImage = $('#profile_photo')
	let updatedImage = null;
	let oldSrc = currentImage[0].src
	$(inputFile).on('change' , (e) => {

		let file = e.target.files[0];

		if (file && file.type.startsWith('image/')){

			updatedImage = file;

			let reader = new FileReader();

			reader.onload = (v) => {

				currentImage[0].src = v.target.result;
			}
			reader.readAsDataURL(file);
		}else{
			showMessage('Warning' , 'You Didn\'t Select Any Image To Profile Photo');
			updatedImage = null;
			currentImage[0].src = oldSrc
		}



	})


	// Changing Data 
	
	let username = $('input#username');
	
	let bio = $('textarea#bio');

	let formEdit = $('#edit_profile_form');
	
	$(formEdit).on('submit' , (event) => {

		event.preventDefault();

		let data = new FormData();
		
		data.append('username' , username[0].value)

		data.append('bio' , bio[0].value);

		if(updatedImage){

			data.append('photo' , updatedImage)
		
		}
			$.ajax({
			  url: '/handle/profile.php',
			  method: 'POST', 
			  data: data,
			  processData: false,
			  contentType: false,
			  success: function(response) {
			    response = JSON.parse(response).data;

			    $('.profile-name').text(response.username);

			    $('.profile-bio').text(response.bio)



			    $('.profile-section img')[0].src = currentImage[0].src;

			    editContainer.fadeToggle();

			  },
			  error: function(xhr, status, error) {
			    console.error(staus);
			  }
			});


	})

	function showMessage(title , body){
		$(modalTitle).html(title)
		$(modalBody).html(body)
		$('#my_modal').modal('show');
	}


})


