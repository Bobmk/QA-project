$(function(){
	var goBack=$('#goBack');
//user panel dropdown
	// $('.dropdown-toggle').dropdown();

// popovers
	$('[data-toggle="tooltip"]').tooltip();

// Previous page click
	goBack.click(function(){
		history.back();
	});

// Back to top button
	var toTop=$('#toTop');
	toTop.hide();

	$(window).scroll(function(){
		if($(window).scrollTop()>300){
			toTop.fadeIn();
		}else{
			toTop.fadeOut();
		}
	});

	toTop.click(function(){
		$('html, body').animate({
			scrollTop: 0
		}, 800);
	});

// prevent form submission on empty field
	var search_form=$('#search_form'),
		term=$('#term');

	search_form.submit(function(event){
		if(term.val()===""){
			event.preventDefault();
		}
	});

});