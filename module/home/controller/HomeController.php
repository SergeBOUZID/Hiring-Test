<?php

use \Framework\Kernel\Extend\Controller;

class HomeController extends Controller
{
	//Action List
	//******************************************************************************
	public function actionIndex()
	{
		$this->actionPageShow();
	}
	
	
	
	public function actionPageShow()
	{
		//echo('test');
		$this->setRender('/module/home/view/HomePageView.php');
	}
	
	
	
}