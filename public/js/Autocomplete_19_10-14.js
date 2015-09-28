//autocomplete class
"use strict";
function Autocomplete(htmlPopUpElem)
{
	//this.autocompleteInput = document.querySelector(trigger);
	this.popupTrigger;
	//this.container = document.querySelector(container);
	this.popUpElem = document.querySelector('.popup');
	this.ajaxPath = "";
	this.pathVars = "";

	//vars
	this.queryStr = "";
	this.suggestionList = {};
	this.ajaxPendingQueries = new Array();
	this.container;
	//this.setInputAutocomplete;
	this.autocompleteInput;

	//setters
	this.setAjaxPath = setAjaxPath;
	this.setPathVars = setPathVars;
	this.pendingQueriesManager = pendingQueriesManager;
	this.appendPendingQueries = appendPendingQueries;
	this.deletePendingQueries = deletePendingQueries;
	this.setContainer = setContainer;
	this.setInputAutocomplete = setInputAutocomplete;
	this.setPopupTrigger = setPopupTrigger;

	//getters
	this.getQueryString = getQueryString;
	this.getJSON = getJSON;
	this.setEventInSuggestion = setEventInSuggestion;
	
	this.showResults = showResults;

	this.showSearchBar = showSearchBar;
	this.showPopUp = showPopUp;
	this.hidePopUp = hidePopUp;

	this.init = init;


	this.onSelect = onSelect;
}

function setPopupTrigger(htmlElem)
{
	var popupTriggerElem = document.querySelector(htmlElem);
	if(!popupTriggerElem)
		alert('popupTriggerElem is not setted!');
	this.popupTrigger = popupTriggerElem;

}

function setInputAutocomplete(htmlElem)
{
	var inputElem = document.querySelector(htmlElem);
	if(!inputElem)
		alert('inputElem is not setted!');
	this.autocompleteInput = inputElem;

}

function setContainer(htmlElem)
{
	var container = document.querySelector(htmlElem);
	if(!container)
		alert('container is not setted!');
	this.container = container;
}

function setPathVars(pathVars)
{
	this.pathVars = pathVars;
}

function setAjaxPath(path)
{
	this.ajaxPath = path;
}

function init()
{
	var that = this;
	this.showSearchBar();
	$('#preloader').hide();

	$(this.autocompleteInput).keyup(function(e)
	{
		var query = setTimeout(function(){that.getJSON();}, 300);
		that.queryStr = that.getQueryString();
		that.pendingQueriesManager(query);
	});
}

function pendingQueriesManager(query)
{
	this.appendPendingQueries(query);

	if(this.ajaxPendingQueries.length > 1)
		this.deletePendingQueries();
}

function appendPendingQueries(query)
{
	this.ajaxPendingQueries.push(query);
}


function deletePendingQueries()
{
	var arrayLength = this.ajaxPendingQueries.length;
	for(var i=0; i<arrayLength; i++)
	{ 
		if(this.ajaxPendingQueries[i] != this.ajaxPendingQueries[arrayLength-1])
			clearTimeout(this.ajaxPendingQueries[i]);	
	}
}

function setEventInSuggestion()
{
	var suggestions = document.querySelectorAll('.suggestion');
	var that = this;
	for(var i=0; i<suggestions.length; i++)
	{
		suggestions[i].index = i;
		suggestions[i].onclick = function (){
			that.onSelect(this, that.suggestionList.suggestions[this.index]);
		}	
	}
}

function onSelect(ele, data)
{
	//example
	alert(data.value);
}

function showSearchBar()
{
	var that = this;
    this.popupTrigger.addEventListener('click', function(event){
        event.preventDefault();
        that.showPopUp();
    })  


}

function showPopUp()
{
    $(this.popUpElem).show(500);
    $('.searcher-wrapper').show(500);
}

function hidePopUp()
{
    $(this.popUpElem).hide(250);
}


function getQueryString()
{
	var value = this.autocompleteInput.value;
	return value;
}

function showResults(jsonObj)
{
	var regex = new RegExp(RegExp.quote(this.queryStr),"ig");
	var suggestions = jsonObj.suggestions;
	var htmlSuggestions = '<table class="category tc"><thead><tr><th>Reference</th><th>Name</th><th>Stock</th></tr></thead>';

	this.suggestionList = jsonObj;

	for(var i=0; i<suggestions.length; i++)
		htmlSuggestions += '<tr class="suggestion" id="'+suggestions[i].id_product+'"><td>'+suggestions[i].reference+'</td><td>'+suggestions[i].value.replace(regex,'<span class="highlighted-text">'+this.queryStr+'</span>')+'</td><td>'+suggestions[i].stock+'</td></tr>';

	htmlSuggestions += '</table>';
	this.container.innerHTML = htmlSuggestions;

	this.setEventInSuggestion();
}

function getJSON()
{
	var that = this;
	var url_params = getUrlParams(document.URL);
	var value = this.queryStr;

	var a = jQuery.ajax({
	    url: that.ajaxPath+"?"+that.pathVars+"&query="+value,
	    dataType: "json",
	    beforeSend: function(http){
	        $('#preloader').show();
	        $('.canvas').hide();
	    },
	    success: function (result)
	    {
	    	that.showResults(result);
	    },
	    complete: function (http)
	    {
	    	$('#preloader').hide();
	    	$('.canvas').show();
	    }
	});

}



