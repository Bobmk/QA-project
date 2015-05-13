$(function(){
	var submit=$('#submit'),
	log_form=$('#log_form'),
	password=$('#password'),
	login=$('#login'),
	msg=$('#msg');

	login.focus();
	submit.removeClass("disabled");
//login button active
	// var interval=setInterval(function(){
	// 	if(submit.hasClass("disabled")){
	// 		if(login.val()!=="" && password.val()!==""){
	// 			submit.removeClass("disabled");
	// 		}
	// 	}else{
	// 		if(login.val()==="" || password.val()===""){
	// 			submit.addClass("disabled");
	// 		}
	// 	}
	// },10);

//checking empty on form submission
	log_form.submit(function(event){
		if(password.val()==="")
			event.preventDefault();
		else if(login.val()==="")
			event.preventDefault();
	});

//message box deletion if it is present
	login.focusin(function(){
		msg.remove();
	});
	password.focusin(function(){
		msg.remove();
	});	
});
