<?php
/**
 * Short description :
 * The class inherits of framework class and represents a toolbox to splite a route URL.
 * 
 * Long description :
 * This class represents a toolbox to splite a route URL.
 * It's possible in the URL to pass arguments. 
 * So there are two main elements in each URL of the framework : 
 * -> The standard elements : parts of the URL which are fixed. 
 * -> The arguments : parts of the URL which are variables.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

final class SpliterUrl extends \Framework\Library\Framework
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Pattern URL used in the configuration of a route.
     * @var string
     */
	protected $strUrlPattern;
	
	/**
	 * Active URL called by a user.
     * @var string
     */
	protected $strUrlActiv;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct($strUrlPattern, $strUrlActiv) 
	{
		$this->strUrlPattern = $strUrlPattern;
		$this->strUrlActiv = $strUrlActiv;
	}
	
	
	
	
	
	// Methods check
	// ******************************************************************************
	
	/**
	 * Check if a value is an URL argument.
	 * 
     * @param string
	 * @return boolean
     */
	public function checkIsArg($strVal)
    {
		// Init var
		$Result = false;
		$strVal = trim($strVal);
		
		// Check
		if(strlen($strVal) > (strlen(PARAM_KERNEL_ROUTE_VAR_START) + strlen(PARAM_KERNEL_ROUTE_VAR_END)))
		{
			$Result = 
			(substr($strVal, 0, strlen(PARAM_KERNEL_ROUTE_VAR_START)) == PARAM_KERNEL_ROUTE_VAR_START) && 
			(substr($strVal, (strlen($strVal)-strlen(PARAM_KERNEL_ROUTE_VAR_END))) == PARAM_KERNEL_ROUTE_VAR_END);
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Check if the active URL is valid.
	 * The analysis take the appropriate pattern of the active URL.
	 * 
	 * @return boolean
     */
	public function checkUrlPattern()
    {
		// Init var
		$Result = false;
		$tabStr1 = explode('/', trim($this->strUrlPattern));
		$tabStr2 = explode('/', trim($this->strUrlActiv));
		
		if(count($tabStr1) == count($tabStr2))
		{
			// Run tab
			$Result = true;
			$cpt = 0;
			while(($cpt<count($tabStr1)) && ($Result))
			{
				$Result = 
				($tabStr1[$cpt] == $tabStr2[$cpt]) || 
				(($this->checkIsArg($tabStr1[$cpt])) && (trim($tabStr2[$cpt]) != ''));
				
				$cpt++;
			}
		}
		
		// Return result
		return $Result;
    }
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get the table of all arguments find in the active URL.
	 * Array param : 
	 * -> $intTypArray = 0 (default) : index table
	 * -> $intTypArray = 1 : associate table
	 * 
	 * @param $intTypArray = 0
	 * @return array
     */
	public function getTabArgs($intTypArray = 0)
    {
		// Init var
		$Result = array();
		
		// Check URL OK
		if($this->checkUrlPattern())
		{
			$tabStr1 = explode('/', trim($this->strUrlPattern));
			$tabStr2 = explode('/', trim($this->strUrlActiv));
			
			for($cpt = 0; $cpt<count($tabStr1); $cpt++)
			{
				if($this->checkIsArg($tabStr1[$cpt]))
				{
					$strKey = $tabStr1[$cpt];
					$strKey = substr($strKey, strlen(PARAM_KERNEL_ROUTE_VAR_START), (strlen($strKey)-strlen(PARAM_KERNEL_ROUTE_VAR_END)-1));
					$strKey = trim($strKey);
					if($intTypArray == 0) // index table
					{
						$Result[] = $tabStr2[$cpt];
					}
					else // associate table
					{
						$Result[$strKey] = $tabStr2[$cpt];
					}
				}
			}
		}
		
		// Return result
		return $Result;
    }
	
	
	
}