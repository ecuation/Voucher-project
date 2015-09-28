$( document ).ready(function() {
 
 	if($.cookie('advisor') == 'checked')
 		$('#cookies-banner').hide();

	$('.closewin').click(function(){
		$.cookie('advisor', 'checked', { expires: 365, path: '/' });
		$('#cookies-banner').hide();
	});
});