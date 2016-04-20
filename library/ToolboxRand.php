<?php
/**
 * Short description :
 * The class inherits of framework class and represent a toolbox about randomize.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

final class ToolboxRand extends \Framework\Library\Framework
{
	//******************************************************************************
	//Methods
	//******************************************************************************
	
	//Methods static getters
	//******************************************************************************
	
	/**
	 * Get a random integer with a specified limit.
	 * 
     * @param $intMin, $intMax
	 * @return integer
     */
	static public function getIntRand($intMin, $intMax)
    {
		srand();
		$Result = rand($intMin, $intMax);
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get a random string with a specified size and a specified limit.
	 * This functin is based on the Ascii table.
	 * 
     * @param $intSize = 0, $intMinAsc = 33, $intMaxAsc = 126
	 * @return string
     */
	static public function getRandValue($intSize = 0, $intMinAsc = 33, $intMaxAsc = 126)
    {
		// Init var
		$Result = '';
		
		// Set size
		if($intSize <= 0)
		{
			srand();
			$intSize = static::getIntRand(1, 20);
		}
		
		//Build value
		for($cpt = 0; $cpt < $intSize; $cpt++)
		{
			srand();
			$Result = $Result.chr(static::getIntRand($intMinAsc, $intMaxAsc));
		}
		
		// Return result
		return $Result;
    }
	
	
	
}