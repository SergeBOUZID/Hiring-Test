<?php
/**
 * Short description :
 * The class inherits of framework class and represent a toolbox about name space.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

final class ToolboxNameSpace extends \Framework\Library\Framework
{
	//******************************************************************************
	//Methods
	//******************************************************************************
	
	//Methods static getters
	//******************************************************************************
	
	/**
	 * Get the name space if exist from a specified file.
	 * The specified path is considered as full.
	 * 
     * @param $strPathFl
	 * @return string
     */
	static public function getNameSpace($strPathFl)
    {
		// Init var
		$Result = '';
		$strNSStart = 'namespace';
		$strNSEnd = ';';
		$Find = false;
		
		// Check file
		if(file_exists($strPathFl))
		{
			// Open file
			$Fl = fopen($strPathFl, 'r');
			// Run all row in file
			while((!feof($Fl)) && (!$Find))
			{
				// Get nm
				$strRow = trim(fgets($Fl));
				
				// Check characters start and end
				if
				(
					(substr($strRow, 0, strlen($strNSStart)) == $strNSStart) && 
					(substr($strRow, (strlen($strRow)-strlen($strNSEnd))) == $strNSEnd)
				)
				{
					// Get value
					$strVal = trim(substr($strRow, strlen($strNSStart), (strlen($strRow)-strlen($strNSStart)-strlen($strNSEnd))));
					
					// Set result
					if(trim($strVal) != '')
					{
						$Result = $strVal;
						$Find = true;
					}
				}
			
			}
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get the name space customized if exist from a specified file.
	 * The specified path is considered as full.
	 * The feature is based upon the function getNameSpace.
	 * 
	 * @see getNameSpace()
	 * 
     * @param $strPathFl
	 * @return string
     */
	///get str name space from file
	static public function getNameSpaceReprocess($strPathFl)
    {
		// Init var
		$Result = trim(static::getNameSpace($strPathFl));
		$strStart = '\\';
		$strEnd = '\\';
		
		// Reprocessing
		if(trim($Result) != '')
		{
			// Correction start
			if(substr($Result, 0, strlen($strStart)) != $strStart)
			{
				$Result = $strStart.$Result;
			}
			
			// Correction end
			if(substr($Result, (strlen($Result)-strlen($strEnd))) != $strEnd)
			{
				$Result = $Result.$strEnd;
			}
		}
		else
		{
			$Result = $strStart;
		}
		
		
		// Return result
		return $Result;
    }
	
	
	
}