

function SessionControl(formName)
{	
	this.formobj = document.forms[formName];
	this.formobj.onsubmit = form_submit_handler
	this.close = closePopUp();
}

function form_submit_handler()
{
	$('.prompt').show();
	$('.confirm').click(function(){
		document.forms['session_starter'].submit();
	});

	return false;
}


function closePopUp(e)
{
	$('.prompt').click(function(e){
		if( e.target !== this ) 
       		return;
       	this.style.display = "none";
	});

	$('.cancel').click(function(e){
		if( e.target !== this ) 
       		return;
       $('.prompt').hide();
	});
}