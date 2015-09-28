//ProductManager 2.0
"use strict";
function Product()
{
	this.popupElemTrigger;
	this.popupCloser;
	this.popUpElem;
	this.container;
	this.primaryUrl;
	this.secondaryUrl;
	this.primarySuccess = {};
	this.secondarySuccess = {};

	//setters
	this.setPopUptrigger = setPopUptrigger;
	this.setPupupElem = setPupupElem;
	this.setContainer = setContainer;
	this.setPopupCloser = setPopupCloser;
	this.setContainer = setContainer;
	this.setPrimaryUrl = setPrimaryUrl;
	this.setSecondaryUrl = setSecondaryUrl;
	this.setPrimarySuccessAjaxAction = setPrimarySuccessAjaxAction;
	this.setSecondarySuccessAjaxAction = setSecondarySuccessAjaxAction;

	//getters
	this.getPrimaryAjaxQuery = getPrimaryAjaxQuery;
	this.getSecondaryAjaxQuery = getSecondaryAjaxQuery;
	
	//view
	this.showPopup = showPopup;
	this.hidePopup = hidePopup;
	this.viewPopupManager = viewPopupManager;

	//ajax
	this.ajaxQuery = ajaxQuery;
	this.init = init;
}

function setPrimarySuccessAjaxAction(successObj)
{
	this.primarySuccess = successObj;
}

function setSecondarySuccessAjaxAction(successObj)
{
	this.secondarySuccess = successObj;
}

function init()
{
	this.viewPopupManager();
}

function viewPopupManager()
{
	this.showPopup();
	this.hidePopup();
}

function showPopup()
{
	var that = this;
	this.popupElemTrigger.addEventListener('click',function () {
		$(that.popUpElem).show('normal');
		that.getPrimaryAjaxQuery();
	});
}

function hidePopup()
{
	var that = this;
	this.popupCloser.addEventListener('click',function () {
		$(that.popUpElem).hide('normal');
	});
}

function setPopUptrigger(elemName)
{
	var popupElemTrigger = document.querySelector(elemName);
	if(!popupElemTrigger)
		alert(elemName+' was not defined');

	this.popupElemTrigger = popupElemTrigger;
}

function setPupupElem(elemName)
{
	var popUpElem = document.querySelector(elemName);
	if(!popUpElem)
		alert(elemName+' was not defined');

	this.popUpElem = popUpElem;
}

function setContainer(elemName)
{
	var container = document.querySelector(elemName);
	if(!container)
		alert(elemName+' was not defined');

	this.container = container;
}

function setPopupCloser(elemName)
{
	var container = document.querySelector(elemName);
	if(!container)
		alert(elemName+' was not defined');

	this.container = container;
}

function setPopupCloser(elemName)
{
	var popupCloser = document.querySelector(elemName);
	if(!popupCloser)
		alert(elemName+' was not defined');

	this.popupCloser = popupCloser;
}

function setPrimaryUrl(primaryUrl)
{
	this.primaryUrl = primaryUrl;
}

function setSecondaryUrl(secondaryUrl)
{
	this.secondaryUrl = secondaryUrl;
}

function getPrimaryAjaxQuery()
{
	this.ajaxQuery(this.primaryUrl, this.primarySuccess);
}

function getSecondaryAjaxQuery()
{
	this.ajaxQuery(this.secondaryUrl, this.secondarySuccess);
}

function ajaxQuery(path, successObj)
{
	var success = successObj.success;
	jQuery.ajax({
		url:path,
		dataType: "json",
		async: false,
		success:function(result)
		{
			success(result);
		}
	});
}
