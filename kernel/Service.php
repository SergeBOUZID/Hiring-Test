<?php
/**
 * Short description :
 * The class represent a service.
 * 
 * Long description :
 * The class represent a service. It's class inherits the data class.
 * A service represent a class which be instantiate only one time. It's the same goal of a singleton but it permits to parameter it.
 * A service is composed of three informations :
 * -> The name : the name which use to call or define a service.
 * -> The path : the path to permit to instantiate at the first time, the service.
 * -> The string of arguments : the list of arguments to instantiate a service.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class Service extends \Framework\Library\Data
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct($strNm, $strPath, $strArg) 
	{
		parent::__construct();
		
		$this->setData(PARAM_KERNEL_SVC_TAG_NM, $strNm);
		$this->setData(PARAM_KERNEL_SVC_TAG_PATH, $strPath);
		$this->setData(PARAM_KERNEL_SVC_TAG_ARG, $strArg);
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get the name used to call a service.
	 * 
	 * @return string
     */
	public function getNm()
    {
		$Result = $this->getData(PARAM_KERNEL_SVC_TAG_NM);
		return $Result;
    }
	
	/**
	 * Get the path used to load a service.
	 * 
	 * @return string
     */
	public function getPath()
    {
		$Result = $this->getData(PARAM_KERNEL_SVC_TAG_PATH);
		return $Result;
    }
	
	/**
	 * Get the string of arguments used to configure a service.
	 * 
	 * @return string
     */
	public function getArg()
    {
		$Result = $this->getData(PARAM_KERNEL_SVC_TAG_ARG);
		return $Result;
    }
	
	
	
	/**
	 * Get the class instance represented by the service.
	 * 
	 * @return object if success, null else
     */
	public function getObj()
    {
		$Result = null;
		
		try
		{
			// Splite and get class
			$SpliterPath = $this->getSpliterPath($this->getPath());
			$strClassNm = $SpliterPath->getClassNm();
			
			// Splite and get tab args
			$SpliterArg = $this->getSpliterArg($this->getArg());
			$strArgs = $SpliterArg->getStrArgs();
			
			// Inclusion class
			require_once(PARAM_KERNEL_PATH_ROOT.'/'.$this->getPath());
			
			// Call class and method dynamically
			$strEval = '$Result = new '.$strClassNm.'('.$strArgs.');';
			eval($strEval);
			//$Result = new \Svc1('Il s\'agit du service n°1.', constant('PARAM_GLOB_1'));
			//$reflectedFoo = new ReflectionClass($strClassNm);
			//$Result = $reflectedFoo->newInstanceArgs($tabArgs);
		}
		catch(Exception $e)
		{
			echo($e->getMessage());
		}
		
		return $Result;
    }
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Set the name used to call a service.
	 * 
	 * @param $strVal
	 * @return boolean
     */
	public function setNm($strVal)
    {
		$Result = $this->setData(PARAM_KERNEL_SVC_TAG_NM, $strVal);
		return $Result;
    }
	
	
	
	/**
	 * Set the path used to load a service.
	 * 
	 * @param $strVal
	 * @return boolean
     */
	public function setPath($strVal)
    {
		$Result = $this->setData(PARAM_KERNEL_SVC_TAG_PATH, $strVal);
		return $Result;
    }
	
	
	
	/**
	 * Set the string of arguments used to configure a service.
	 * 
	 * @param $strVal
	 * @return boolean
     */
	public function setArg($strVal)
    {
		$Result = $this->setData(PARAM_KERNEL_SVC_TAG_ARG, $strVal);
		return $Result;
    }
	
	
	
}