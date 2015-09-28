function InputEditor(inputClass, ajaxPath)
{
	this.inputList;

	this.startAjaxSubmit = startAjaxSubmit;
	this.inputClass = inputClass;
	this.ajaxPath = ajaxPath;

	//getters
	this.getInputs = getInputs;
	
	this.sendAjax = sendAjax;
	this.init = init;
}

function init()
{
	this.inputList = this.getInputs();
	this.startAjaxSubmit();
}

function getInputs()
{
	var inputElements = document.querySelectorAll(this.inputClass);
	if(inputElements.length == 0)
	{
		//alert('Input "'+this.inputClass+'" return 0 results!');
		return false;
	}

	return inputElements;
}

function startAjaxSubmit()
{
	var that = this;

	for(var i=0; i< this.inputList.length; i++)
	{
		this.inputList[i].onkeypress = function (e)
		{
			var key = window.event ? e.keyCode : e.which;
	        if (key == '13')
	        {
	        	that.sendAjax(this.id, this.value, this);
	        } 
		}

		this.inputList[i].onchange = function ()
		{
			that.sendAjax(this.id, this.value, this);
		}
	}
}

function sendAjax(id, message, elem)
{
	if(!$.isNumeric(id))
		return false;
	$.ajax({
		url: this.ajaxPath+"?id="+id+"&value="+message,
		type:"POST",
		async: false,
		success:function(result)
		{
			$(elem).effect("highlight", {color: '#67c58f'}, 1000);
		},
		error:function()
		{
			$(elem).effect("highlight", {color: '#e84c3d'}, 1000);
		}
	});
}