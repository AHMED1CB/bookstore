$(document).ready(() => {

	let nav = $('.nav-links ul');

	let toggler = $('.toggler')

	$(toggler).click(() => {
		$(nav).slideToggle()
	})

})