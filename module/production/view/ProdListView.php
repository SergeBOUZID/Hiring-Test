<?php 
	// Init var
	$strRteNmListhow = 'ProdListShow';
	$strIdListContent = 'wbs-list-content';
	$strClassListCrit = 'wbs-list-crit';
	$strIdListPageActiv = 'wbs-list-page-active';
	$strIdListPageCount = 'wbs-list-page-count';
	$strMsgListEmpty = 'No production found!';
	
	
	
	// Check data
	$boolTabInfo = (count($tabInfo) > 0);
	if($boolTabInfo)
	{
		// Set table of columns
		$tabCol = array();
		$tabCol['cat_name'] = array('Catégorie', '');
		$tabCol['prd_name'] = array('Produit', '');
		$tabCol['stk_id'] = array('Quantité', '');
		$tabCol['prices'] = array('Prix', '');
		
		// Set table of data
		$tabData = array();
		foreach($tabCol as $key => $value)
		{
			$tabData[$key] = array();
		}
		
		// Run all info product
		foreach($tabInfo as $key => $value)
		{
			// Set data
			foreach($tabCol as $key2 => $value2)
			{
				if(array_key_exists($key2, $value))
				{
					$tabData[$key2][] = $value[$key2];
				}
			}
			
			// Set price
			$strPriceAll = '';
			for($cpt = 0; $cpt < count($value['pri_id']); $cpt++) 
			{
				if(trim($strPriceAll) != '')
				{
					$strPriceAll = $strPriceAll.'<br />';
				}
				
				$tabPrice = $value['pri_id'][$cpt];
				
				$strPriceAll = $strPriceAll.sprintf($tabPrice['cur_format'], $tabPrice['pri_price']).' ('.$tabPrice['cnt_name'].')';
			}
			
			$tabData['prices'][] = $strPriceAll;
		}
	}
	
	
	
	// Call template list
	include($this->getStrPathProject('/global/src/view/ListView.php'));
?> 