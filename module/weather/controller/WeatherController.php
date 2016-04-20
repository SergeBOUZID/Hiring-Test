<?php

use \Framework\Kernel\Extend\Controller;

class WeatherController extends Controller
{
	//Action List
	//******************************************************************************
	public function actionIndex()
	{
		$this->actionPageShow();
	}
	
	
	
	public function actionPageShow()
	{
		// Init args
		$objToolBoxWeather = $this->getService(CONF_TAG_SVC_TOOLBOX_WEATHER);
		
		// Get info
		$tabViewArg['tabInfo'] = $objToolBoxWeather->getTabInfoWeather();
		
		// Set render
		$this->setRender('/module/weather/view/WeatherPageView.php', $tabViewArg);
	}
	
	
	
}