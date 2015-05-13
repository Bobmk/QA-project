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
		 pass_wrong=$('#pass_wrong'),
		 pass_match=$('#pass_match');


// New password tooltip
	npass.tooltip();

// functions for interactive form control
	// function addError(cur,handle1,handle2){
	// 	handle1.removeClass("hidden");
	// 	if(handle2){
	// 		handle2.removeClass("hidden");
	// 	}
	// 	cur.next().addClass("glyphicon-remove");
	// 	cur.parent().parent().addClass("has-error");
	// }

	// function removeError(cur,handle1,handle2){
	// 	handle1.addClass("hidden");
	// 	if(handle2){
	// 		handle2.addClass("hidden");
	// 	}
	// 	cur.next().removeClass("glyphicon-remove");
	// 	cur.parent().parent().removeClass("has-error");
	// }

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
			// if(npass.val()==="" )
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