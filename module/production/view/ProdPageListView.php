[[Extend src="/global/src/view/MainView.php"/]]

[[Block:BlockPageBody]]
<?php 
	// Init var
	$objToolBoxProd = $this->getService(CONF_TAG_SVC_TOOLBOX_PROD);
	$objToolBoxGraph = $this->getService(CONF_TAG_SVC_TOOLBOX_GRAPH);
	
	$strRteNmListhow = 'ProdListShow';
	$strIdListContent = 'wbs-list-content';
	$strClassListCrit = 'wbs-list-crit';
	$strIdListPageActiv = 'wbs-list-page-active';
	
	
	
	// Set list status
	$tabCurrencies = $objToolBoxProd->getTabCurrencies();//array_merge(array('0' => 'Select'), $objToolBoxProd->getTabCurrencies());
	$tabCurrencies2 = array();
	$tabCurrencies2[''] = 'Select';
	foreach($tabCurrencies as $key => $value)
	{
		$tabCurrencies2[$key] = $value;
	}
	$strListBox = $objToolBoxGraph->getListBoxTab
	(
		$tabCurrencies2, 
		true, 
		'cur_id', 
		'cur_id', 
		'form-control input-sm '.$strClassListCrit, 
		$strCurId, 
		""
	);
	
	
	// Set table of criteria
	$tabCrit = array();
	//$tabCrit['cur_id'] = array('text', 'Devise (au minimum)', $strCurId, '', '10', '10');
	$tabCrit['cur_id']= array('select', 'Devise (au minimum)', $strListBox);
	
	
	
	// Set table of buttons
	$tabCritBt = array();
	
	
	
	// Get table of data
	ob_start();
	include($this->getStrPathProject('/module/production/view/ProdListView.php'));
	$strListView = ob_get_clean();
	
	
	
	// Call template page list
	include($this->getStrPathProject('/global/src/view/PageListView.php'));
?>
[[/Block:BlockPageBody]]