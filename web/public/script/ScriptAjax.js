// List functions
// *******************************************************************************************

/*
 * This function allows to set the list.
 * intTypeAdd = 0 : Add in top of the list / intTypeAdd = 1 : Add in bottom of the list / intTypeAdd = 2 : replace the list
 */
function setAjaxList(strUrl, strIdListContent, strClassListCrit, strIdListPageActiv, boolPopup, strScriptAfter, intTypeAdd, boolWait)
{
	var objAjax = getAjaxEngine();
	
	// Set type add
	if(typeof(intTypeAdd) == 'undefined')
	{
		intTypeAdd = 2;
	}
	
	// Set arguments criteria
	var strArgs = '';
	var strElmArg = '';
	var tabElmArg = window.document.getElementsByClassName(strClassListCrit);
	for(var cpt = 0; cpt<tabElmArg.length; cpt++)
	{
		// Get string value of element
		strElmArg = '';
		if(tabElmArg[cpt].type == 'checkbox')
		{
			if(tabElmArg[cpt].checked)
			{
				strElmArg = encodeURIComponent(tabElmArg[cpt].id) + '=' +  encodeURIComponent('1');
			}
		}
		else
		{
			strElmArg = encodeURIComponent(tabElmArg[cpt].id) + '=' + encodeURIComponent(tabElmArg[cpt].value);
		}
		
		// Set arg string
		if(strElmArg.trim() != '')
		{
			if(strArgs.trim() != '')
			{
				strArgs = strArgs + '&';
			}
			strArgs = strArgs + strElmArg;
		}
	}
	
	// Set arguments page active
	var elmPageActive = window.document.getElementById(strIdListPageActiv);
	if(elmPageActive)
	{
		if(strArgs.trim() != '')
		{
			strArgs = strArgs + '&';
		}
		strArgs = strArgs + encodeURIComponent(elmPageActive.name) + '=' +  encodeURIComponent(elmPageActive.value);
	}
	
	// Set arguments final
	if(strArgs.trim() != '')
	{
		strArgs = '' + strArgs;
	}
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = strArgs;
	objAjax.open(strMethod, (strUrl), true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send(strParam);
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			
			//alert(strAjaxResult);
			
			if(strAjaxResult != 'cmd_ko')
			{
				var elmListContent = window.document.getElementById(strIdListContent);
				
				if(elmListContent)
				{
					// Add return
					if(intTypeAdd == 0) // On the top
					{
						elmListContent.innerHTML = strAjaxResult + elmListContent.innerHTML;
					}
					else if(intTypeAdd == 1) // On the bottom
					{
						elmListContent.innerHTML = elmListContent.innerHTML + strAjaxResult;
					}
					else // Replace
					{
						//elmListContent.innerHTML = '';
						elmListContent.innerHTML = strAjaxResult;
					}
					
					// Scroll to
					//setElmScroll(strIdListContent);
					
					// Execute script after if exists
					if(typeof(strScriptAfter) != 'undefined')
					{
						eval(strScriptAfter);
					}
				}
			}
		}
	};
}



/*
 * This function allows to do an action in an item in a list.
 */
function setAjaxListItemAction(strUrl, strIdListContent, strScriptAfter, boolPopup, boolWait)
{
	var objAjax = getAjaxEngine();
	
	// Set in popup
	boolInPopup = false;
	if(typeof(boolPopup) != 'undefined')
	{
		boolInPopup = boolPopup;
	}
	
	// Set wait popup
	boolWaitPopup = true;
	if(typeof(boolWait) != 'undefined')
	{
		boolWaitPopup = boolWait;
	}
	
	// Break run timer
	//setTimeRun('wbs-time-run', (!boolWaitPopup));
	if(boolWaitPopup)
	{
		setTimers(false);
	}
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = '';
	objAjax.open(strMethod, strUrl, true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send(strParam);
	
	// Show panel wait
	if(boolWaitPopup)
	{
		setPnlPopupWaitShow();
	}
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			
			// Hide panel wait
			if(boolWaitPopup)
			{
				setPnlPopupWaitHide();
				//alert(strAjaxResult);
			}
			
			// Show response
			if(strAjaxResult != 'cmd_ko')
			{
				var elmList = window.document.getElementById(strIdListContent); // List object
				if(elmList)
				{
					elmList.innerHTML = strAjaxResult;
					// Scroll to
					//setElmScroll(strIdListContent);
					
					// Set non scrollable body
					if(boolInPopup)
					{
						$("body").addClass("modal-open");
					}
					
					// Execute script after if exists
					if(typeof(strScriptAfter) != 'undefined')
					{
						eval(strScriptAfter);
					}
				}
			}
			
			// Run timer
			//setTimeRun('wbs-time-run', true);
			if(boolWaitPopup)
			{
				setTimers(true);
			}
		}
	};
}



/*
 * This function allows to set form of an item in a list.
 */
function setAjaxListItemFrm(strIdPopup, strIdForm, strIdListContent, strTagToSave, strListIdArg, strUrl, strScriptAfterForm, strScriptAfterList)
{
	var objAjax = getAjaxEngine();
	
	// Set arguments criteria
	var tabIdArg = strListIdArg.split(',');
	var strArgs = '';
	var strIdArg = '';
	var elm;
	var strElmArg = '';
	
	// Break run timer
	//setTimeRun('wbs-time-run', false);
	setTimers(false);
	
	// Run all arg id
	for(var cpt = 0; cpt<tabIdArg.length; cpt++)
	{
		// Get elm
		strIdArg = tabIdArg[cpt];
		elm = window.document.getElementById(strIdArg);
		strElmArg = '';
		
		if(elm)
		{
			// Get arg text
			if(elm.type == 'checkbox')
			{
				if(elm.checked)
				{
					strElmArg = encodeURIComponent(elm.name) + '=' + encodeURIComponent('1');
					//strElmArg = elm.name + '=' +  '1';
				}
			}
			else
			{
				strElmArg = encodeURIComponent(elm.name) + '=' + encodeURIComponent(elm.value);
				//strElmArg = elm.name + '=' + elm.value;
			}
			
			// Set arg text
			if(strElmArg.trim() != '')
			{
				if(strArgs.trim() != '')
				{
					strArgs = strArgs + '&';
				}
				
				strArgs = strArgs + strElmArg;
			}
		}
	}
	
	// Check if form shown
	elm = window.document.getElementById(strIdPopup);
	if(elm)
	{
		if(strArgs.trim() != '')
		{
			strArgs = strArgs + '&';
		}
		
		strArgs = strArgs + encodeURIComponent(strTagToSave) + '=' +  encodeURIComponent('1');
	}
	
	// Set arguments final
	if(strArgs.trim() != '')
	{
		strArgs = '' + strArgs;
	}
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = strArgs;
	objAjax.open(strMethod, (strUrl), true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send(strParam);
	
	// Show panel wait
	setPnlPopupWaitShow();
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			//alert(strAjaxResult);
			
			// Show response
			if
			(
				(strAjaxResult.indexOf('modal') > -1) && 
				(strAjaxResult.indexOf('modal-dialog') > -1) && 
				(strAjaxResult.indexOf('modal-content') > -1)
			) // Form
			{
				// Hide panel wait
				setPnlPopupWaitHide();
				
				// Hide popup
				setPnlPopupCancel(strIdPopup);
				
				// Show form
				setPnlPopupShow(strIdPopup, strAjaxResult);
				
				// Set non scrollable body
				$("body").addClass("modal-open");
				
				// Execute script after if exists
				if(typeof(strScriptAfterForm) != 'undefined')
				{
					if(strScriptAfterForm.trim() != '')
					{
						eval(strScriptAfterForm);
					}
				}
			}
			else if(strAjaxResult.trim() != '') // List
			{
				// Hide panel wait
				setPnlPopupWaitHide();
				
				// Hide popup
				setPnlPopupCancel(strIdPopup);
				
				// Show list
				var elmList = window.document.getElementById(strIdListContent);
				
				if(elmList)
				{
					elmList.innerHTML = strAjaxResult;
					// Scroll to
					//setElmScroll(strIdListContent);
				}
				
				// Execute script after if exists
				if(typeof(strScriptAfterList) != 'undefined')
				{
					if(strScriptAfterList.trim() != '')
					{
						eval(strScriptAfterList);
					}
				}
			}
			
			// Run timer
			//setTimeRun('wbs-time-run', true);
			setTimers(true);
		}
	};
}



/*
 * This function allows to set form of an item and redirect to a new URL if good.
 */
function setAjaxListItemFrmToUrl(strIdPopup, strIdForm, strTagToSave, strListIdArg, strUrl, strScriptAfterForm)
{
	var objAjax = getAjaxEngine();
	
	// Set arguments criteria
	var tabIdArg = strListIdArg.split(',');
	var strArgs = '';
	var strIdArg = '';
	var elm;
	var strElmArg = '';
	
	// Break run timer
	//setTimeRun('wbs-time-run', false);
	setTimers(false);
	
	// Run all arg id
	for(var cpt = 0; cpt<tabIdArg.length; cpt++)
	{
		// Get elm
		strIdArg = tabIdArg[cpt];
		elm = window.document.getElementById(strIdArg);
		strElmArg = '';
		
		if(elm)
		{
			// Get arg text
			if(elm.type == 'checkbox')
			{
				if(elm.checked)
				{
					strElmArg = encodeURIComponent(elm.name) + '=' +  encodeURIComponent('1');
				}
			}
			else
			{
				strElmArg = encodeURIComponent(elm.name) + '=' +  encodeURIComponent(elm.value);
			}
			
			// Set arg text
			if(strElmArg.trim() != '')
			{
				if(strArgs.trim() != '')
				{
					strArgs = strArgs + '&';
				}
				
				strArgs = strArgs + strElmArg;
			}
		}
	}
	
	// Check if form shown
	elm = window.document.getElementById(strIdPopup);
	if(elm)
	{
		if(strArgs.trim() != '')
		{
			strArgs = strArgs + '&';
		}
		
		strArgs = strArgs + encodeURIComponent(strTagToSave) + '=' +  encodeURIComponent('1');
	}
	
	// Set arguments final
	if(strArgs.trim() != '')
	{
		strArgs = '' + strArgs;
	}
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = strArgs;
	objAjax.open(strMethod, (strUrl), true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send(strParam);
	
	// Show panel wait
	setPnlPopupWaitShow();
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			//alert(strAjaxResult);
			
			// Show response
			if
			(
				(strAjaxResult.indexOf('modal') > -1) && 
				(strAjaxResult.indexOf('modal-dialog') > -1) && 
				(strAjaxResult.indexOf('modal-content') > -1)
			) // Form
			{
				// Hide panel wait
				setPnlPopupWaitHide();
				
				// Hide popup
				setPnlPopupCancel(strIdPopup);
				
				// Show form
				setPnlPopupShow(strIdPopup, strAjaxResult);
				
				// Set non scrollable body
				$("body").addClass("modal-open");
				
				// Execute script after if exists
				if(typeof(strScriptAfterForm) != 'undefined')
				{
					if(strScriptAfterForm.trim() != '')
					{
						eval(strScriptAfterForm);
					}
				}
			}
			else if(strAjaxResult.trim() != '') // Redirection to
			{
				window.location.href = strAjaxResult;
			}
			
			// Run timer
			//setTimeRun('wbs-time-run', true);
			setTimers(true);
		}
	};
}





// Menu count functions
// *******************************************************************************************

/*
 * This function allows to show count in menu.
 */
function setAjaxCount(strIdCount, strUrl, strScriptAfter)
{
	var objAjax = getAjaxEngine();
	
	// Break run timer
	// setTimeRun('wbs-time-run', false);
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = '';
	objAjax.open(strMethod, strUrl, true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send(strParam);
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			
			// Show response
			if((strAjaxResult.trim() != '') && (strAjaxResult != 'cmd_ko'))
			{
				setCount(strIdCount, parseInt(strAjaxResult));
				
				// Execute script after if exists
				if(typeof(strScriptAfter) != 'undefined')
				{
					eval(strScriptAfter);
				}
			}
			
			// Run timer
			// setTimeRun('wbs-time-run', true);
		}
	};
}





// User config functions
// *******************************************************************************************

/*
 * This function allows to show element default value.
 */
function setAjaxUsrCnfElmDefaultVal(strUrl)
{
	var objAjax = getAjaxEngine();
	
	// Break run timer
	//setTimeRun('wbs-time-run', false);
	setTimers(false);
	
	// Set arguments criteria
	var strArgs = '';
	var elm = window.document.getElementById('usr_cnf_elm_typ');
	if(elm)
	{
		strArgs = encodeURIComponent(elm.name) + '=' +  encodeURIComponent(elm.value);
	}
	
	elm = window.document.getElementById('usr_cnf_elm_lst_id');
	if(elm)
	{
		if(strArgs.trim() != '')
		{
			strArgs = strArgs + '&';
		}
		
		strArgs = strArgs + encodeURIComponent(elm.name) + '=' +  encodeURIComponent(elm.value);
	}
	
	// Set arguments final
	if(strArgs.trim() != '')
	{
		strArgs = '' + strArgs;
	}
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = strArgs;
	objAjax.open(strMethod, (strUrl), true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send(strParam);
	
	// Show panel wait
	setPnlPopupWaitShow();
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			
			// Hide panel wait
			setPnlPopupWaitHide();
			
			// Show response
			if((strAjaxResult.trim() != '') && (strAjaxResult != 'cmd_ko'))
			{
				// Get element default value
				elm = window.document.getElementById('usr_cnf_elm_default_val');
				
				if(elm)
				{
					// Set new default value
					elm.parentNode.innerHTML = strAjaxResult;
					$("body").addClass("modal-open");
				}
			}
			
			// Run timer
			//setTimeRun('wbs-time-run', true);
			setTimers(true);
		}
	};
}





// Discussions functions
// *******************************************************************************************

/*
 * This function allows to show discussion, from the user select list.
 */
function setAjaxDiscUsrSelect(strIdPopupDisc, strIdPopupUsrSelect, strClassSaveUsrSelect, strClassDiscMsg, strUrl, strUrlSeparator, strMsgErr, strArg)
{
	var objAjax = getAjaxEngine();
	
	// Break run timer
	//setTimeRun('wbs-time-run', false);
	setTimers(false);
	
	// Set in popup
	strUrlArg = '';
	if(typeof(strArg) != 'undefined')
	{
		strUrlArg = strArg;
	}
	
	if(strUrlArg.trim() == '')
	{
		strUrlArg = getStrUserSelectList(strClassSaveUsrSelect, strUrlSeparator);
	}
	
	// Call url and send parameters
	var strMethod = 'POST';
	var strParam = '';
	objAjax.open(strMethod, (strUrl + strUrlArg), true);
	objAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Necessary with post method
    objAjax.send('');
	
	// Show panel wait
	setPnlPopupWaitShow();
	
	// Return response
	objAjax.onreadystatechange = function() 
	{
		// State = OK
		if(objAjax.readyState == 4)
		{
			// Get return
			var strAjaxResult = objAjax.responseText.trim();
			
			// Hide panel wait
			setPnlPopupWaitHide();
			//alert(strAjaxResult);
			
			// Hide others popups
			if(window.document.getElementById(strIdPopupDisc))
			{
				setPnlPopupCancel(strIdPopupDisc);
			}
			if(window.document.getElementById(strIdPopupUsrSelect))
			{
				setPnlPopupCancel(strIdPopupUsrSelect);
			}
			
			// Show response
			if((strAjaxResult.trim() != '') && (strAjaxResult != 'cmd_ko'))
			{
				// Show discussion
				setPnlPopupShow(strIdPopupDisc, strAjaxResult);
				
				// Set non scrollable body
				//$("body").addClass("modal-open");
				
				// Scroll last msg
				setTimeout(function (){setDiscMsgScroll(strClassDiscMsg);$("body").addClass("modal-open");}, 500);
			}
			else
			{
				alert(strMsgErr);
			}
			
			// Run timer
			//setTimeRun('wbs-time-run', true);
			setTimers(true);
		}
	};
}


