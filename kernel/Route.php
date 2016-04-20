<?php
/**
 * Short description :
 * The class represent a route.
 * 
 * Long description :
 * The class represent a route. It's class inherits the data class.
 * A route represent the request of the user (url) and the path of the web project for construct the response (path).
 * A route is composed of three informations :
 * -> The name : the name which use to call a route.
 * -> The URL : the request of the user.
 * -> The path : the path to permit to construct the answer. Mainly a path which drives to a controller.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class Route extends \Framework\Library\Data
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct($strNm, $strUrl, $strPath) 
	{
		parent::__construct();
		
		$this->setData(PARAM_KERNEL_ROUTE_TAG_NM, $strNm);
		$this->setData(PARAM_KERNEL_ROUTE_TAG_URL, $strUrl);
		$this->setData(PARAM_KERNEL_ROUTE_TAG_PATH, $strPath);
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get the name which use to call a route.
	 * 
	 * @return string
     */
	public function getNm()
    {
		$Result = $this->getData(PARAM_KERNEL_ROUTE_TAG_NM);
		return $Result;
    }
	
	/**
	 * Get the URL, the request of the user.
	 * It is possible to get URL with replaced values of variables from a specified table of parameters.
	 * 
	 * @param $tabParam = array()
	 * @return string
     */
	public function getUrl($tabParam = array())
    {
		$Result = $this->getData(PARAM_KERNEL_ROUTE_TAG_URL);
		
		foreach($tabParam as $key => $value)
		{
			$Result = str_replace (PARAM_KERNEL_ROUTE_VAR_START.$key.PARAM_KERNEL_ROUTE_VAR_END, $value, $Result);
		}
		
		return $Result;
    }
	
	/**
	 * Get the path to permit to construct the answer.
	 * 
	 * @return string
     */
	public function getPath()
    {
		$Result = $this->getData(PARAM_KERNEL_ROUTE_TAG_PATH);
		return $Result;
    }
	
	
	
	
	
	//Methodes setters
	//******************************************************************************
	
	/**
	 * Set the name which use to call a route.
	 * 
	 * @param $strVal
	 * @return boolean$
     */
	public function setNm($strVal)
    {
		$Result = $this->setData(PARAM_KERNEL_ROUTE_TAG_NM, $strVal);
		return $Result;
    }
	
	/**
	 * Set the URL, the request of the user.
	 * 
	 * @param $strVal
	 * @return boolean
     */
	public function setUrl($strVal)
    {
		$Result = $this->setData(PARAM_KERNEL_ROUTE_TAG_URL, $strVal);
		return $Result;
    }
	
	/**
	 * Set the path to permit to construct the answer.
	 * 
	 * @param $strVal
	 * @return boolean
     */
	public function setPath($strVal)
    {
		$Result = $this->setData(PARAM_KERNEL_ROUTE_TAG_PATH, $strVal);
		return $Result;
    }
	
	
	
}