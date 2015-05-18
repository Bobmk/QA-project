$(function(){
	var uname=$('#uname'),
		 cpass=$('#cpass'),
		 npass=$('#npass'),
		 rnpass=$('#rnpass'),
		 nuname=$('#nuname'),
		 submit=$('#submit'),
		 uid=$('#uid'),
		 prof_form=$('#prof_form'),
		 pass_err=$('#pass_err'),
		 pass_pat=$('#pass_pat'),
		 pass_diff=$('#pass_diff'),
		 pass_empty=$('#pass_empty'),
		 name_emp=$('#name_emp'),
		 not_uniq=$('#not_uniq'),
		 pass_wrong=$('#pass_wrong'),
		 pass_match=$('#pass_match');


// New password tooltip
	npass.tooltip();

// name check
	nuname.focusin(function(){
		not_uniq.addClass('hidden');
		name_emp.addClass('hidden');
	});
	nuname.focusout(function(){
		if(nuname.val()===""){
			name_emp.removeClass('hidden');
		}
		if(nuname.siblings('.glyphicon').hasClass('glyphicon-remove')){
			not_uniq.removeClass('hidden');
		}
	});

// unique name	test
	nuname.keyup(function(){
		if(nuname.val()!=="" && nuname.val()!==uname.val()){
			$.ajax({
				url: '/assets/components/php/process-register.php',
				type: 'POST',
				dataType: 'json',
				data: {uname: nuname.val()},
				cache: false,
				success: function(data){
					if(data.present===true){
						nuname.parent().parent().removeClass('has-success');
						nuname.parent().parent().addClass('has-error');
						nuname.siblings('.glyphicon').removeClass('glyphicon-ok');
						nuname.siblings('.glyphicon').addClass('glyphicon-remove');
					}else{
						nuname.parent().parent().removeClass('has-error');
						nuname.parent().parent().addClass('has-success');
						nuname.siblings('.glyphicon').removeClass('glyphicon-remove');
						nuname.siblings('.glyphicon').addClass('glyphicon-ok');
					}
				},
				error: function(){
					// alert('error during name check');
				}
			});
		}else{
			nuname.parent().parent().removeClass('has-success');
			nuname.parent().parent().removeClass('has-error');
			nuname.siblings('.glyphicon').removeClass('glyphicon-ok');
			nuname.siblings('.glyphicon').removeClass('glyphicon-remove');
		}
	});

	var pass_correct=false;
// Match current password using AJAX
	cpass.on('focusin keypress',function(){
		pass_err.addClass("hidden");
		pass_diff.addClass("hidden");
		pass_wrong.addClass("hidden");
	});
	cpass.keyup(function(){
		if(cpass.val()!==""){
			if(npass.val()!=="" && npass.val()===cpass.val()){
				pass_diff.removeClass("hidden");
			}
			var check={
				id: uid.val(),
				pass: cpass.val()
			};
			$.ajax({
				url: '/assets/components/php/process-profile.php',
				type: 'POST',
				dataType: 'json',
				data: check,
				cache: false,
				success: function(data){
					if(data.checked===true){
						pass_correct=true;
						// alert("pass match");
					}else{
						// alert("not match");
					}
					// alert(data);
				},
				error: function(){
					// alert("error during pass check");
				}
			});
		}
	});

// password pattern check
	npass.on('focusin keypress',function(){
		pass_pat.addClass("hidden");
		pass_diff.addClass("hidden");
		pass_empty.addClass("hidden");
	});
	npass.focusout(function(){
		if(npass.val()!==""){
			if(cpass.val()!=="" && cpass.val()===npass.val()){
				pass_diff.removeClass("hidden");
			}
			var st=/((?=.*\d)+(?=.*[a-z])+(?=.*[A-Z])+(?=.*[!@#$%><?^&*+-])+){8,20}/.test(npass.val());
			if(st===false){
				pass_pat.removeClass("hidden");
			}
		}
	});

// new password match
	rnpass.on('focusin keypress',function(){
		pass_match.addClass("hidden");
	});
	rnpass.focusout(function(){
		if(rnpass.val()!=="" && npass.val()!==""){
			if(rnpass.val()!==npass.val()){
				pass_match.removeClass("hidden");
			}
		}
	});

// Submit enable/disable
	submit.click(function(){
		if(nuname.val()===""){
			name_emp.removeClass('hidden');
			return false;
		}
		if(nuname.siblings('.glyphicon').hasClass('glyphicon-remove')){
			not_uniq.removeClass('hidden');
			return false;
		}
		if(cpass.val() && !pass_correct){
			pass_wrong.removeClass("hidden");
			return false;
		}
		if(npass.val()!==""){
			if(!(/((?=.*\d)+(?=.*[a-z])+(?=.*[A-Z])+(?=.*[!@#$%><?^&*+-])+){8,20}/.test(npass.val()))){
				pass_pat.removeClass("hidden");
				return false;
			}
			if(rnpass.val()==="" || npass.val()!==rnpass.val()){
				pass_match.removeClass("hidden");
				return false;
			}
			if(cpass.val()===""){
				pass_err.removeClass("hidden");
				return false;
			}
			if(!pass_correct){
				pass_wrong.removeClass("hidden");
				return false;
			}
			if(npass.val()===cpass.val()){
				pass_diff.removeClass("hidden");
				return false;
			}
			return true;
		}
		if(uname.val()!==nuname.val()){
			if(cpass.val()===""){
				pass_err.removeClass("hidden");
				return false;
			}
			if(!pass_correct){
				pass_wrong.removeClass("hidden");
				return false;
			}
			if(rnpass.val()!==""){
				pass_empty.removeClass("hidden");
				return false;
			}
			return true;
		}
		if(rnpass.val()!==""){
			pass_empty.removeClass("hidden");
			return false;
		}
		$('#no_update').modal();
		return false;
	});

// alert removal
	$('.alert').fadeOut(3000);

});