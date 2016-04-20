<?php

use \Framework\Kernel\Extend\Model;

class ToolBoxWeather extends Model
{
	/**
	 * Get the associative table of currencies.
	 * 
	 * @return array
     */
    public function getTabInfoWeather()
	{
		/*
		Je ne connais pas les méthodes de mis en cache comme je l'ai dit avant et pendant mon premier entretien avec Perrine CLEMENT et Calin CRETU.
		Je vais donc utiliser un moyen autre, en passant par les sessions (j'évite ainsi de passer par la DB, et je'utilise en quelque sorte de la mémoire vive).
		*/
		
		// Init var
		$strData = '';
		
		// Check exist in session
		if($this->checkSaveExists(CONF_TAG_SAVE_API_WEATHER))
		{
			// Get from session
			$strData = $this->getSave(CONF_TAG_SAVE_API_WEATHER);
		}
		else
		{
			// Get from api
			$strData = file_get_contents(CONF_URL_API_WEATHER);
			
			// Save in session
			$this->setSave(CONF_TAG_SAVE_API_WEATHER, $strData, true);
		}
		
		// Set result
		$Result = json_decode($strData);
		
		// Return result
		return $Result;
	}
	
	
	
}


