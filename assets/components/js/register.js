$(function(){
	var pass_danger=$('#pass_danger');
	var pass1=$('#pass1');
	var pass2=$('#pass2');
	var name_field=$('#name');
	var login=$('#login_id');
	var sub=$('#submit');
	var email_emp=$('#email_emp');
	var pass1_emp=$('#pass1_emp');
	var pass2_emp=$('#pass2_emp');
	var name_emp=$('#name_emp');
	var pass_pat=$('#pass_pat');
	var em_pat=$('#em_pat');

//Password Tooltip	 
	// pass1.tooltip(); // done in main js file
	name_field.focus();
	sub.removeClass('disabled');
// Empty name check
	name_field.focusin(function(){
		name_emp.addClass("hidden");
	});

// unique name	test
	name_field.keyup(function(){
		if(name_field.val()!==""){
			$.ajax({
				url: '/assets/components/php/process-register.php',
				type: 'POST',
				dataType: 'json',
				data: {uname: name_field.val()},
				cache: false,
				success: function(data){
					if(data.present===true){
						name_field.parent().parent().removeClass('has-success');
						name_field.parent().parent().addClass('has-error');
						name_field.siblings('.glyphicon').removeClass('glyphicon-ok');
						name_field.siblings('.glyphicon').addClass('glyphicon-remove');
					}else{
						name_field.parent().parent().removeClass('has-error');
						name_field.parent().parent().addClass('has-success');
						name_field.siblings('.glyphicon').removeClass('glyphicon-remove');
						name_field.siblings('.glyphicon').addClass('glyphicon-ok');
					}
				},
				error: function(){
					alert('error during name check');
				}
			});
		}else{
			name_field.parent().parent().removeClass('has-success');
			name_field.parent().parent().removeClass('has-error');
			name_field.siblings('.glyphicon').removeClass('glyphicon-ok');
			name_field.siblings('.glyphicon').removeClass('glyphicon-remove');
		}
	});

//Valid Email id check	
	login.focusin(function(){
		em_pat.addClass("hidden");
		email_emp.addClass("hidden");
	});
	login.focusout(function(){
		if(login.val()!=""){
			if(!(/[\w]+@[\w]{3,}[.][\w]{3,}/.test(login.val()))){
				em_pat.removeClass("hidden");
			}
		}
	});

//Password pattern check
	pass1.focusin(function(){
		pass_pat.addClass("hidden");
		pass1_emp.addClass("hidden");
	});
	pass1.focusout(function(){
		if(pass1.val()!==""){
			if(!(/((?=.*\d)+(?=.*[a-z])+(?=.*[A-Z])+(?=.*[!@#$%><?^&*+-])+){8,20}/.test(pass1.val()))){
				pass_pat.removeClass("hidden");
			}
		}
	});

//Repeat Password match 
	pass2.focusin(function(){
		pass_danger.addClass("hidden");
		pass2_emp.addClass("hidden");
	});
	pass2.focusout(function(){
		if(pass1.val()!=="" && pass2.val()!==""){
			if(pass1.val()!=pass2.val()){
				pass_danger.removeClass("hidden");
			}
		}
	});

// submit check
	sub.click(function(){
		if(name_field.val()===""){
			name_emp.removeClass("hidden");
			return false;
		}
		if(login.val()===""){
			email_emp.removeClass("hidden");
			return false;
		}
		if(login.val()!=="" && !(/[\w]+@[\w]{3,}[.][\w]{3,}/.test(login.val()))){
			em_pat.removeClass("hidden");
			return false;
		}
		if(pass1.val()===""){
			pass1_emp.removeClass("hidden");
			return false;
		}
		if(pass1.val()!=="" && !(/((?=.*\d)+(?=.*[a-z])+(?=.*[A-Z])+(?=.*[!@#$%><?^&*+-])+){8,20}/.test(pass1.val()))){
			pass_pat.removeClass("hidden");
			return false;
		}
		if(pass2.val()===""){
			pass2_emp.removeClass("hidden");
			return false;
		}
		if(pass2.val()!=="" && pass1.val()!==pass2.val()){
			pass_danger.removeClass("hidden");
			return false;
		}
		return true;
	});

});