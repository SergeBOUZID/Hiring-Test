<?php
/**
 * Short description :
 * The class inherits of framework class and represent a toolbox about string.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

final class ToolboxString extends \Framework\Library\Framework
{
	//******************************************************************************
	//Methods
	//******************************************************************************
	
	//Methods static check
	//******************************************************************************
	
	/**
	 * Check a specified string start with a specified other string.
	 * The Offset permits to specified about what index to start the search.
	 * 
     * @param $strText, $strStart, $intOffset = 0
	 * @return boolean
     */
	static public function checkStrStart($strText, $strStart, $intOffset = 0)
    {
		$Result = (substr($strText, $intOffset, strlen($strStart)) == $strStart);
		return $Result;
    }
	
	
	
	/**
	 * Check a specified string finish with a specified other string.
	 * The Offset permits to specified about what index to end the search.
	 * 
     * @param $strText, $strEnd, $intOffset = 0
	 * @return boolean
     */
	static public function checkStrEnd($strText, $strEnd, $intOffset = 0)
    {
		$strText = substr($strText, 0, strlen($strText) - $intOffset);
		$Result = (substr($strText, (strlen($strText) - strlen($strEnd))) == $strEnd);
		return $Result;
    }
	
	
	
	
	
	//Methods static getters
	//******************************************************************************
	
	/**
	 * Get a string between specified limits start and end, in a specified string.
	 * The Offset permits to specified about what index to start the search.
	 * It return false if limits not found, the string between limits else.
	 * 
     * @param $strText, $strStart, $strEnd, $intOffset = 0
	 * @return string
     */
	static public function getStrBetween($strText, $strStart, $strEnd, $intOffset = 0)
    {
		// Init var
		$Result = false;
		
		// Get position of limit start
		$intStart = strpos($strText, $strStart, $intOffset);  
		
		// Check limit start exists
		if($intStart !== false)
		{
			// recalcul limit start
			$intStart = ($intStart + strlen($strStart));
			
			// Get position of limit end
			$intEnd = strpos($strText, $strEnd, $intStart); 
			
			// Check limit end exists
			if($intEnd !== false)
			{
				// recalcul limit end
				$intEnd = ($intEnd - $intStart);
				
				// Get string between limits
				$Result = substr($strText, $intStart, $intEnd); 
			}
		}
		
		// Return result
		return $Result;
    }
	
	
	
}