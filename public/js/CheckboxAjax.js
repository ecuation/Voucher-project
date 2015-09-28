function CheckboxAjax(inputClass, ajaxPath)
{
	this.inputList;

	this.inputClass = inputClass;
	this.ajaxPath = ajaxPath;

	//getters
	this.getInputs = getInputs;
	
	this.sendAjax = sendAjax;
	this.start = start;
	this.prepare = prepare;
}

function start()
{
	this.inputList = this.getInputs();
	this.prepare();
}

function getInputs()
{
	var inputElements = document.querySelectorAll(this.inputClass);
	if(inputElements.length == 0)
	{
		return false;
	}

	return inputElements;
}


function prepare()
{
	var that = this;

	for(var i=0; i< this.inputList.length; i++)
	{

		this.inputList[i].onclick = function ()
		{
			var value = ($(this).is(':checked')) ? 1 : 0;
			that.sendAjax(this.id, value, this);
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