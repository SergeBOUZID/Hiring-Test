// String functions
// *******************************************************************************************

/*
 * This function permits to replace all occurrences.
 */
function getStrReplaceAll(strMain, strFind, strReplace)
{
	var Result = '';
	var strVal = strMain;
	
	while(strVal.indexOf(strFind) != -1)
	{
		strVal = strVal.replace(strFind, strReplace);
	}
	
	Result = strVal;
	
	return Result;
}



/*
 * This function permits to evaluate string value from a specified elm to code.
 */
function runCodeFromElm(strIdElm)
{
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		if(elm.innerHTML)
		{
			if(elm.innerHTML.trim() != '')
			{
				eval(elm.innerHTML);
			}
		}
		else if(elm.value)
		{
			if(elm.value.trim() != '')
			{
				eval(elm.value);
			}
		}
	}
}





// Element functions
// *******************************************************************************************

/*
 * This function permits to get div element from string div.
 */
function getElmDivFromStrDiv(strDiv)
{
	var Result;
	
	var elmDivParent = window.document.createElement("div");
	elmDivParent.innerHTML = strDiv;
	Result = elmDivParent.firstChild;
	
	return Result;
}



/*
 * This function permits to get the integer size from a specified element id.
 * intOptWhat permets to specified what size is requested.
 * intOptWhat = 0 => width.
 * intOptWhat = 1 => height.
 */
function getIntElmSize(strIdElm, intOptWhat)
{
	var Result = 0;
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		if(intOptWhat == 0)
		{
			if(elm.offsetWidth)
			{
				Result = elm.offsetWidth;
			}
			else if(elm.style.pixelWidth)
			{
				Result = elm.style.pixelWidth;
			}
			else if(elm.style.width)
			{
				Result = elm.style.width.split('px')[0];
			}
		}
		else
		{
			if(elm.offsetHeight)
			{
				Result = elm.offsetHeight;
			}
			else if(elm.style.pixelHeight)
			{
				Result = elm.style.pixelHeight;
			}
			else if(elm.style.height)
			{
				Result = elm.style.height.split('px')[0];
			}
		}
	}
	
	Result = parseInt(Result, 10);
	
	return Result;
}



/*
 * This function permits to get the maximum integer size from the page.
 * intOptWhat permets to specified what size is requested.
 * intOptWhat = 0 => width.
 * intOptWhat = 1 => height.
 */
function getIntMaxSize(intOptWhat)
{
	// Init var
	var Result = 0;
	var tabElm = window.document.getElementsByTagName("*");
	
	// Run all elements in window.document
	for(var cpt=0; cpt<tabElm.length; cpt++) 
	{
		// Get element
		elm = tabElm[cpt];
		
		// Get size
		intSize = 0;
		if(intOptWhat == 0)
		{
			if(elm.offsetWidth)
			{
				intSize = elm.offsetWidth;
			}
			else if(elm.style.pixelWidth)
			{
				intSize = elm.style.pixelWidth;
			}
			else if(elm.style.width)
			{
				intSize = elm.style.width.split('px')[0];
			}
		}
		else
		{
			if(elm.offsetHeight)
			{
				intSize = elm.offsetHeight;
			}
			else if(elm.style.pixelHeight)
			{
				intSize = elm.style.pixelHeight;
			}
			else if(elm.style.height)
			{
				intSize = elm.style.height.split('px')[0];
			}
		}
		
		// Check size
		if(intSize > 0)
		{
			if(intSize > Result)
			{
				Result = intSize;
			}
		}
	}
	
	// Return result
	return Result;
}



/*
 * This function permits to show an element or not.
 * intOptWhat permets to specified what type of visibility is requested.
 * intOptWhat = 0 => visibility.
 * intOptWhat = 1 => display.
 */
function setElmShow(strIdElm, boolShow, intOptWhat)
{
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		if(boolShow)
		{
			if(intOptWhat == 0)
			{
				elm.style.visibility='visible';
			}
			else
			{
				elm.style.display='block';
			}
		}
		else
		{
			if(intOptWhat == 0)
			{
				elm.style.visibility='hidden';
			}
			else
			{
				elm.style.display='none';
			}
		}
	}
}



/*
 * This function permits to enable a specified element or not.
 */
function setElmEnabled(strIdElm, boolEnabled)
{
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		var tabElm = elm.getElementsByTagName("*");
		
		for(var cpt=0; cpt<tabElm.length; cpt++) 
		{
			if(tabElm[cpt].disabled)
			{
				tabElm[cpt].disabled = (!boolEnabled);
			}
		}
	}
}




/*
 * This function permits to remove the specified element.
 */
function removeElm(strIdElm)
{
	// Init var
	var Result = false;
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		// Remove element
		elm.parentNode.removeChild(elm);
		
		Result = true;
	}
	
	return Result;
}



/*
 * This function allows to execute onclick method of an element if exists.
 */
function setElmOnClick(strIdElm)
{
	var elm = window.document.getElementById(strIdElm);
	
	// Check if elm exists
	if(elm)
	{
		// Execute onclick
		elmBt.onclick();
	}
}





// ListBox functions
// *******************************************************************************************

/*
 * This function permits to get the selected value from a specified ListBox.
 */
function getListBoxValSelect(strIdList)
{
	var Result = '';
	var elm = window.document.getElementById(strIdList);
	
	if(elm)
	{
		Result = elm.options[elm.selectedIndex].value;
	}
	
	return Result;
}



/*
 * This function permits to set the selected value (specified) from a specified ListBox.
 */
function setListBoxValSelect(strIdList, strVal)
{
	var elm = window.document.getElementById(strIdList);
	
	if(elm)
	{
		for(var cpt=0; cpt<elm.length; cpt++) 
		{
			if(elm.options[cpt].value == strVal)
			{
				elm.selectedIndex = Cpt;
				break;
			}
		}
                
	}
}





// CheckBox functions
// *******************************************************************************************

/*
 * This function permits to set the specified checked value in the specified table of CheckBox.
 */
function setTabCheckBoxValue(tabElm, boolValue)
{
	for(var cpt = 0; cpt<tabElm.length; cpt++)
	{
		if(tabElm[cpt].checked)
		{
			tabElm[cpt].checked = boolValue;
		}
	}
}



/*
 * This function permits to set the checked value from a specified CheckBox value, in list of CheckBox from a specified Class.
 */
function setTabCheckBoxFromCheckBoxValue(strIdCheckBoxMain, strClassCheckBox)
{
	var elmCheckBox = window.document.getElementById(strIdCheckBoxMain);
	var tabElm = window.document.getElementsByClassName(strClassCheckBox);
	
	if((elmCheckBox) && (tabElm))
	{
		setTabCheckBoxValue(tabElm, elmCheckBox.checked);
	}
}



/*
 * This function permits to set the checked value from a specified CheckBox value, in list of CheckBox from a specified element.
 */
function setBlockTabCheckBoxFromCheckBoxValue(strIdCheckBoxMain, strIdElm)
{
	var elmCheckBox = window.document.getElementById(strIdCheckBoxMain);
	var elm = window.document.getElementById(strIdElm);
	
	if(elmCheckBox && elm)
	{
		var tabElm = elm.getElementsByTagName('input');
		
		if(tabElm)
		{
			setTabCheckBoxValue(tabElm, elmCheckBox.checked);
		}
	}
}



/*
 * This function permits to set the checked value from a specified other CheckBox value.
 */
function setCheckboxLink(strIdCheckBoxMain, strIdCheckBoxTarget, boolOpposite)
{
	var elmCheckBoxMain = window.document.getElementById(strIdCheckBoxMain);
	var elmCheckBoxTarget = window.document.getElementById(strIdCheckBoxTarget);
	
	if((elmCheckBoxMain) && (elmCheckBoxTarget))
	{
		if(boolOpposite)
		{
			elmCheckBoxTarget.checked = (!elmCheckBoxMain.checked);
		}
		else
		{
			elmCheckBoxTarget.checked = (elmCheckBoxMain.checked);
		}
	}
}





// Scroll elements functions
// *******************************************************************************************

/*
 * This function permits to set the scroll on the specified element.
 */
function setElmScroll(strIdElm)
{
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		elm.scrollIntoView(true);
	}
}



/*
 * This function permits to scroll in a specified element.
 */
function setElmScrollInPx(strIdElm, intPx)
{
	var elm = window.document.getElementById(strIdElm);
	
	if(elm)
	{
		elm.scrollTop = intPx;
	}
}



//Lancement scroll slowly
function ScrollTo_Elm_Slowly(Id, NbPxStart, NbPxTot)
{
	var NbStep = 5;
	var WaitStep = 2000;
	
	var NbPxStep = Math.round(NbPxTot/NbStep);
	var NbPxProgress = NbPxStart;
	
	ScrollTo_Elm_Slowly_Px(Id, NbPxTot, NbPxStep, NbPxProgress);
}



//Scroll slowly dun element pour une repetition
function ScrollTo_Elm_Slowly_Px(Id, NbPxTot, NbPxStep, NbPxProgress, WaitStep)
{
	//Progression scroll
	NbPxProgress = (NbPxProgress + NbPxStep);
	ScrollTo_Elm_Px(Id, NbPxProgress);
	
	//Pose nouvelle progression si necessaire
	if(NbPxProgress<NbPxTot)
	{
		setTimeout
		(
			ScrollTo_Elm_Slowly_Px(Id, NbPxTot, NbPxStep, NbPxProgress, WaitStep)
			, WaitStep
		);
	}
}





// URL functions
// *******************************************************************************************

/*
 * This function permits to go to a new URL.
 */
function setNewUrl(strUrl, boolNewPage, strTxtConfirme)
{
	// Confirmation
	var boolGo = true;
	if(strTxtConfirme.trim() != '')
	{
		boolGo = confirm(strTxtConfirme);
	}
	
	// Launch Url
	if(boolGo)
	{
		if(boolNewPage) // In new page
		{
			window.open(strUrl);
		}
		else // In the same page
		{
			window.location.href = strUrl;
		}
	}
}



/*
 * This function allows to send an http request (post, get).
 */
function sendRequest(strUrl, strMethod, tabFields, boolNewPage)
{
	// Create element form
	var objFrm = window.document.createElement('form');
	objFrm.setAttribute('method', strMethod);
	objFrm.setAttribute('action', strUrl);
	
	if(boolNewPage) // In new page
	{
		objFrm.setAttribute('target', '_blank');
	}
	
	// Set fields
	var objField;
	for(var key in tabFields)
	{
		objField = window.document.createElement('input');
		objField.setAttribute('type', 'hidden');
		objField.setAttribute('name', key);
		objField.setAttribute('value', tabFields[key]);
	}
	
	// Send form
	objFrm.submit();
}





// Screen functions
// *******************************************************************************************

/*
 * This function permits to check if the size of the screen respects the specified limit.
 * intOptWhat permits to specified what type of limit is requested.
 * intOptWhat = 0 => Min.
 * intOptWhat = 1 => Max.
 */
function checkScreenSizeEngine(intLimit, intOptWhat)
{
	Result = false;
	
	if(intOptWhat == 0)
	{
		Result = (window.innerWidth >= intLimit);
	}
	else
	{
		Result = (window.innerWidth <= intLimit);
	}
	
	return Result;
}



/*
 * This function permits to check if the size of the screen respects the specified limit minimum and maximum.
 */
function checkScreenSize(intLimitMin, intLimitMax)
{
	Result = 
	(
		(checkScreenSizeEngine(intLimitMin, 0) || (intLimitMin == 0)) && 
		(checkScreenSizeEngine(intLimitMax, 1) || (intLimitMax == 0))
	);
	
	return Result;
}





// Ajax functions
// *******************************************************************************************

/*
 * This function permits to get the Ajax.
 */
function getAjaxEngine()
{
    var objAjax = null;
	
    if(window.XMLHttpRequest) 
	{
        objAjax = new XMLHttpRequest();
    }
    else if(window.ActiveXObject) 
    {
        objAjax = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	return objAjax;
}


