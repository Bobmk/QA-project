$(function(){var d=$("#submit"),e=$("#log_form"),c=$("#password"),b=$("#login"),a=$("#msg");b.focus();d.removeClass("disabled");e.submit(function(a){""===c.val()?a.preventDefault():""===b.val()&&a.preventDefault()});b.focusin(function(){a.remove()});c.focusin(function(){a.remove()})});
