//productClass init
var urlVars = this.getUrlParams(document.URL);
var product = new Product();
product.setPrimaryUrl("tools/ajax/AjaxProductsController.php?action=get_manufacturers&id_category="+urlVars['id_category']);

product.setPrimarySuccessAjaxAction({success: function(result)
{
	$('.category').html('');
	for(var i=0; i<result.success.length; i++){
		$('.category').append(function() {
	  		return $('<li id="'+result.success[i].id_manufacturer+'">'+result.success[i].manufacturer+'</li>').click(function (){
	  			product.setSecondaryUrl("tools/ajax/AjaxProductsController.php?action=get_products&id_manufacturer="+this.id+"&delimiter="+urlVars['delimiter']+"&id_category="+urlVars['id_category']);	
				product.getSecondaryAjaxQuery();
	  		});
		})
	}
}
});

product.setSecondarySuccessAjaxAction({
	success: function (result){
		$('.category').html('');
		for(var i=0; i<result.success.length; i++){
			$(".category").append(function(){
				var obj = result.success[i];
				return $("<li id="+result.success[i].id_product+">"+result.success[i].product+"</li>").click(function(){
					product.onSelect(this, obj);
				});
			})
		}	
	}
});

product.onSelect = function (elem, json)
{
	var stock = (urlVars['delimiter'] == 1) ? json.stock_available : 100;
	$('.popup').hide('normal');
	$('#primary-trigger').html($(elem).text());
	$('#qty').attr('max',stock);
	$('#price').val(json.price);
	$('#id_product_target').val(json.id_product);
	calculateAmount();
}

product.setPopUptrigger('#primary-trigger');
product.setContainer('.canvas');
product.setPupupElem('.popup');
product.setPopupCloser('.close-popup');

product.init();