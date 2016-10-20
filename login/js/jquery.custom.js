$(document).ready(function () {
	$("#card").flip({
	  trigger: 'manual'
	});

	$(".forgot-pass").on('click',function(){
		$("#card").flip(true);
	});

	$(".back-to-login").on('click',function(){
		$("#card").flip(false);
	});

});