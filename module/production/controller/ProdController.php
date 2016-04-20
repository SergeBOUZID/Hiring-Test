<?php

use \Framework\Kernel\Extend\Controller;

class ProdController extends Controller
{
	//Action List
	//******************************************************************************
	public function actionIndex()
	{
		$this->actionPageListShow();
	}
	
	
	
	public function actionPageListShow()
	{
		// Init args
		$objToolBoxProd = $this->getService(CONF_TAG_SVC_TOOLBOX_PROD);
		$objToolBoxGraph = $this->getService(CONF_TAG_SVC_TOOLBOX_GRAPH);
		$tabViewArg['strCurId'] = $objToolBoxGraph->getArg('cur_id', '');
		
		// Get list
		$objListDataProd = new ListDataProd();
		$objListDataProd->run();
		$tabViewArg['intRowCount'] = $objListDataProd->getRowCount();
		$tabViewArg['intPageCount'] = $objListDataProd->getPageCount();
		$tabViewArg['intPageActive'] = $objListDataProd->getPageActive();
		$tabViewArg['tabInfo'] = $objToolBoxProd->getTabInfoFull($objListDataProd->getTabResult());
		
		// Set render
		$this->setRender('/module/production/view/ProdPageListView.php', $tabViewArg);
	}
	
	
	
	public function actionListShow()
	{
		// Init args
		$objToolBoxProd = $this->getService(CONF_TAG_SVC_TOOLBOX_PROD);
		
		// Get list
		$objListDataProd = new ListDataProd();
		$objListDataProd->run();
		$tabViewArg['intRowCount'] = $objListDataProd->getRowCount();
		$tabViewArg['intPageCount'] = $objListDataProd->getPageCount();
		$tabViewArg['intPageActive'] = $objListDataProd->getPageActive();
		$tabViewArg['tabInfo'] = $objToolBoxProd->getTabInfoFull($objListDataProd->getTabResult());
		
		// Set render
		$this->setRender('/module/production/view/ProdListView.php', $tabViewArg);
	}
	
	
	
}