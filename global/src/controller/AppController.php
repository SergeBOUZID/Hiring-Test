<?php

use \Framework\Kernel\Extend\Controller;

class AppController extends Controller
{
	//Action List
	//******************************************************************************
	public function actionIndex()
	{
		$this->actionPageErrShow();
	}
	
	
	
	public function actionPageErrShow()
	{
		$tabViewArg['strMsg'] = 'Error 404, page not found!';
		
		$this->setRender('/global/src/view/AppPageErrView.php', $tabViewArg);
	}
	
	
	
}