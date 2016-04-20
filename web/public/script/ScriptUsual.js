// List functions
// *******************************************************************************************

/*
 * This function permits to set the list.
 * intOption : 0 = Show all / 1 = Search with criteria
 */
function setListSearch(intOption, strUrl, strIdListContent, strClassListCrit, strIdListPageActiv, boolPopup, strScriptAfter)
{
	if(intOption == 0)
	{
		// Reset criteria
		var tabElm = window.document.getElementsByClassName(strClassListCrit);
		for(var cpt = 0; cpt<tabElm.length; cpt++)
		{
			// Get arg text
			if(tabElm[cpt].type == 'checkbox')
			{
				tabElm[cpt].checked = false;
			}
			else
			{
				tabElm[cpt].value = '';
			}
		}
	}
	
	// Reset page
	elm = window.document.getElementById(strIdListPageActiv);
	if(elm)
	{
		elm.value = 1;
	}
	
	// Set list
	setAjaxList(strUrl, strIdListContent, strClassListCrit, strIdListPageActiv, boolPopup, strScriptAfter);
}



/*
 * This function permits to move in the list.
 * intOption : 0 = Move to first / 1 = Move to before / 2 = Move to after / 3 = Move to last
 */
function setListMove(intOption, strUrl, strIdListContent, strClassListCrit, strIdListPageActiv, strIdListPageCount, boolPopup, strScriptAfter)
{
	// Init var
	elmPageActive = window.document.getElementById(strIdListPageActiv);
	elmPageCount = window.document.getElementById(strIdListPageCount);
	
	// Re treatment value page
	if((elmPageActive) && (elmPageCount))
	{
		switch(intOption) 
		{
			case 0: // Move to first
				elmPageActive.value = 1;
				break;
				
			case 1: // Move to before
				elmPageActive.value = (parseInt(elmPageActive.value) - 1);
				if(parseInt(elmPageActive.value) < 1)
				{
					elmPageActive.value = 1;
				}
				break;
				
			case 2: // Move to after
				elmPageActive.value = (parseInt(elmPageActive.value) + 1);
				if(parseInt(elmPageActive.value) > parseInt(elmPageCount.value))
				{
					elmPageActive.value = elmPageCount.value;
				}
				break;
				
			case 3: // Move to last
				elmPageActive.value = elmPageCount.value;
				break;
		}
		
		// Set list
		if((parseInt(elmPageActive.value) >= 1) && (parseInt(elmPageActive.value) <= parseInt(elmPageCount.value)))
		{
			setAjaxList(strUrl, strIdListContent, strClassListCrit, strIdListPageActiv, boolPopup, strScriptAfter);
		}
	}
}


