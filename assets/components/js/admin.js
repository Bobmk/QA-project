$(function(){
	var user_search=$('#user_search'),
		user_name=$('#user_name');

	user_search.submit(function(event) {
		if(user_name.val()===""){
			event.preventDefault();
		}
	});

});