//init
window.onload = function (e)
{
	// var cookie = readCookie("styles");
	// var title = cookie ? cookie : getPreferredStyleSheet();
	// setActiveStyleSheet(title);

	//function list
	startTime();
	iconReloadController();
	popUptriggersController();
}

function popUptriggersController()
{
	var subproductTrigger = $('#secondary-trigger');
	var categoryTrigger = $('#primary-trigger');

	categoryTrigger.click(function()
	{
		$('#input-primary-product').show();
		$('#input-secondary-product').hide();
	});

	subproductTrigger.click(function()
	{
		$('#input-primary-product').hide();
		$('#input-secondary-product').show();
		$('.canvas').html('');
	});
}


function iconReloadController()
{
	var icon_reload = $('.icon-refresh');
	icon_reload.bind('click', function() {
	   return false;
	})

	icon_reload.click(function()
	{
		$(this).animate({borderSpacing: 360 }, {
		    step: function(now,fx) {
		      $(this).css('-webkit-transform','rotate('+now+'deg)'); 
		      $(this).css('-moz-transform','rotate('+now+'deg)');
			  $(this).css('-ms-transform','rotate('+now+'deg)');
		      $(this).css('transform','rotate('+now+'deg)'); 
		    },
		    duration:'normal',
		    complete:  function() { window.location.reload(); } 
		},'linear');
	});

}

function resetInputForm()
{
	var reset = $('.reset-form');
	reset.bind('click', function(){
		return false;
	});

	reset.click(function(){
		 $('#searcher')[0].reset();
	});
}

// get screen resolution
window.onresize = function ()
{
	var target_div = document.getElementById('screen-resolution');
	if(target_div)
		target_div.innerHTML = window.innerWidth;
	
}

//functions 
function getUrlParams(urlString)
{
    var vars = [], hash;
    var hashes = urlString.slice(urlString.indexOf('?') + 1).split('&');

    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function calculateAmount()
{
	var quantity = document.getElementById('qty').value;
	var price = document.getElementById('price').value.replace(",", ".");
		if(isNaN(price))
			return false;

	var amountElem = document.querySelector('.amount');
	var total = (quantity * price).toFixed(2);

	//result
	amountElem.innerHTML = total;
}

RegExp.quote = function(str) {
	return (str+'').replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
};


