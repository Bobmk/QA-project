$(function(){
	
	var ques_up=$('#ques_up'),
		 ques_down=$('#ques_down'),
		 ans_up=$('.ans_up'),
		 ans_down=$('.ans_down'),
		 ans_part=$('.ans_part'),
		 ques_part=$('#ques_part'),
		 usr_id=$('#usr_id');

//Rich Text area
	var r_text=$('#rich-text');
	r_text.focusin(function(){
		CKEDITOR.replace('rich-text',{
			toolbar: [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'NewPage', 'Preview', 'Print' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-' ] },
				{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
				{ name: 'insert', items: [ 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak' ] }

			]
		});
	});

// question vote up
	ques_up.click(function(){
		if($(this).siblings('span').data('update')){
			var ques=$(this).siblings('span').data('qid');
			var usr=usr_id.data('uid');
			$.ajax({
				url: '/assets/components/php/rank-process.php',
				type: 'POST',
				data: {question_up: ques,user: usr},
				success: function(data){
					if(data==="owner"){
						$('#no_own_ques').modal();
					}else if(data==="voted"){
						$('#no_vote_ques').modal();
					}else{
						ques_up.siblings('span').text(data);
					}
				},
				error: function(){
					// alert("error during question rank up");
				}
			});	
		}else{
			$('#no_perm_ques').modal();
		}			
	});

// question vote down
	ques_down.click(function(){
		if($(this).siblings('span').data('update')){
			var ques=$(this).siblings('span').data('qid');
			var usr=usr_id.data('uid');
			$.ajax({
				url: '/assets/components/php/rank-process.php',
				type: 'POST',
				data: {question_down: ques,user: usr},
				success: function(data){
					if(data==="owner"){
						$('#no_own_ques').modal();
					}else if(data==="voted"){
						$('#no_vote_ques').modal();
					}
					else{
						ques_down.siblings('span').text(data);
					}
				},
				error: function(){
					// alert("error during question rank down");
				}
			});
		}else{
			$('#no_perm_ques').modal();
		}	
	});

// answer vote up
	ans_up.click(function(){
		if($(this).siblings('span').data('update')){
			var a_qid=$(this).siblings('span').data('qid'),
				 a_uid=$(this).siblings('span').data('uid'),
				 a_ans=$(this).siblings('span').data('answered'),
				 s_id=$(this),
				 usr=usr_id.data('uid');
			if(usr==a_uid){
				$('#no_own_ans').modal();
				return false;
			}
			$.ajax({
				url: '/assets/components/php/rank-process.php',
				type: 'POST',
				data: { ans_up: true, ans_qid: a_qid, ans_uid: a_uid, ans_ans: a_ans, ans_usr: usr },
				success: function(data){
					if(data=="voted"){
						$('#no_vote_ans').modal();
					}
					else{
						s_id.siblings('span').text(data);
					}
				},
				error: function(){
					// alert("error during answer rank up");
				}
			});
		}else{
			$('#no_perm_ans').modal();
		}		
	});

// answer vote down
	ans_down.click(function(){
		if($(this).siblings('span').data('update')){
			var a_qid=$(this).siblings('span').data('qid'),
				 a_uid=$(this).siblings('span').data('uid'),
				 a_ans=$(this).siblings('span').data('answered'),
				 s_id=$(this),
				 usr=usr_id.data('uid');
			if(usr==a_uid){
				$('#no_own_ans').modal();
				return false;
			}
			$.ajax({
				url: '/assets/components/php/rank-process.php',
				type: 'POST',
				data: { ans_down: true, ans_qid: a_qid, ans_uid: a_uid, ans_ans: a_ans, ans_usr: usr },
				success: function(data){
					if(data=="voted"){
						$('#no_vote_ans').modal();
					}
					else{
						s_id.siblings('span').text(data);
					}
				},
				error: function(){
					// alert("error during answer rank down");
				}
			});
		}else{
			$('#no_perm_ans').modal();
		}		
	});



});