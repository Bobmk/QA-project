$(function(){

//user panel dropdown
	// $('.dropdown-toggle').dropdown();

// popovers
	$('[data-toggle="tooltip"]').tooltip();

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

});