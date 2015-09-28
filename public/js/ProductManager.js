function ProductManager(limitQty)
{
	this.getNewProduct = getNewProduct;
	this.limitQty = limitQty;
	this.init = init;
	this.AjaxProductList = AjaxProductList;
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

function getNewProduct(canvasElem, triggerElem)
{
	if(!document.querySelector(triggerElem) || !document.querySelector(canvasElem)){
		alert('Alguno de los selectores no existe o no es correcto');
		return false;	
	}
	var that = this;
	var triggerElem = $(triggerElem);
	var canvasElem = document.querySelector(canvasElem);

	triggerElem.click(function (){
		that.init();
	});

	this.AjaxProductList = new AjaxProductList(canvasElem, this.limitQty);	
}


function init()
{
	this.AjaxProductList.getManufacturers();
	$('.popup').on('click', function(e) { 
       if( e.target !== this ) 
               return;
           $(this).hide(500);
    });
}

function AjaxProductList(canvasElem, limitQty)
{
	//html elements
	this.popupElem = document.querySelector('.popup');
	this.canvasElem = canvasElem;

	//setters
	this.limitQty = limitQty;
	this.setGettersOnManufacturers = setGettersOnManufacturers;
	this.setProductInUI = setProductInUI;
	this.calculateAmount = calculateAmount;

	//getters
	this.getProducts = getProducts;
	this.getManufacturers = getManufacturers;
	this.getUrlParams = getUrlParams;

	//cancel & close
	this.cancelLink = cancelLink;
	this.closePopUp = closePopUp;

}

function setGettersOnManufacturers()
{
	var that = this;
	$(this.popupElem).find('a').bind('click', function() {
 		that.getProducts(this.href);
	});
}
//user interface
function setProductInUI()
{
	var that = this;
	$(this.popupElem).find('a').bind('click', function() {
 		that.canvasElem.innerHTML = this.innerHTML;
 		//set values in html
 		document.getElementById('id_product_target').value = that.getUrlParams(this.href)['id_product'];
 		document.getElementById('price').value = this.getAttribute('price');

 		if(that.limitQty == true)
 			document.getElementById('qty').setAttribute('max',this.getAttribute('max'));
 		
 		document.getElementById('qty').value = "1";
 		that.closePopUp();
 		that.calculateAmount();

	});
}

function getProducts(href)
{
	var id_category = this.getUrlParams(document.URL);
	var id_manufacturer = this.getUrlParams(href);
	var delimiter = this.getUrlParams(document.URL);
	var that = this;

	$("#preloader").show();
	$(".popup .category").empty();

	$('.popup').show(500);
	$('.canvas').show(500);
	//$('#related-autocomplete').hide();

	$.ajax({
		url:"tools/ajax/AjaxProductsController.php?action=get_products&id_category="+id_category['id_category']+"&id_manufacturer="+id_manufacturer['id_manufacturer']+"&delimiter="+delimiter['delimiter'], 
		type:"GET",
		async: false,
		success:function(result)
		{	
			$("#preloader").hide();
			$(".canvas").html('<ul class="category">'+result+'<ul/>');
			that.cancelLink();
			that.setProductInUI();
	}});
}

function getManufacturers()
{
	var urlVars = this.getUrlParams(document.URL);
	var that = this;

	$("#preloader").show();
	$(".popup .category").empty();

	$('.popup').show(500);
	$('.canvas').show(500);
	$('#related-autocomplete').hide();

	$.ajax({
		url:"tools/ajax/AjaxProductsController.php?action=get_manufacturers&id_category="+urlVars['id_category'],
		type:"GET",
		async: false,
		success:function(result)
		{
			$("#preloader").hide();
			$(".canvas").html('<ul class="category">'+result+'<ul/>');
			that.cancelLink();
			that.setGettersOnManufacturers();
	}});
}

/**
*@ return array with url params
*/
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


function cancelLink()
{
	$(this.popupElem).find('a').click( function(event){
	     event.preventDefault();
	     var url = $(this).attr("href");
	     var div = "#"+$(this).attr("name");
	     $(div).load(url);
	     return false;
	});
}


function closePopUp()
{
	$('.popup').hide(350);
}


