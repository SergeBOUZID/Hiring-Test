<?php
/**
 * Short description :
 * The class inherits of framework class and represent a data which contains string datas.
 * 
 * Long description :
 * This class permit to represent an object with string datas.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

abstract class Data extends \Framework\Library\FrameworkUse
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Table contains all datas.
     * @var array
     */
	protected $tabData;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct() 
	{
		$this->tabData = array();
	}
	
	public function __destruct() 
	{
		
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
     * Get a precise data.
	 * 
     * @param $Key
     * @return string if find, null else
     */
	public function getData($Key)
    {
		$Result = null;
		
		if(isset($this->tabData[$Key]))
		{
			$Result = $this->tabData[$Key];
		}
		
		return $Result;
    }
	
	
	
	
	
	// Methodes setters
	// ******************************************************************************
	
	/**
     * Set a data.
	 * 
     * @param $Key, $Val
     * @return true if success, false else
     */
	public function setData($Key, $Val)
    {
		$Result = false;
		$this->tabData[$Key] = $Val;
		$Result = true;
		
		return $Result;
    }
	
	
	
	
	
	// Methodes remove
	// ******************************************************************************
	
	/**
     * Remove a precise data.
	 * 
     * @param $Key
     * @return true if success, false else
     */
	public function removeData($Key)
    {
		$Result = false;
		
		if(isset($this->tabData[$Key]))
		{
			unset($this->tabData[$Key]);
			$Result = true;
		}
		
		return $Result;
    }
	
	
	
}