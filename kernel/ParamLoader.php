<?php
/**
 * Short description :
 * The class which handle of the configuration part of the framework.
 * 
 * Long description :
 * This class represent the class which handle of the configuration. It's class inherits the singleton.
 * There is two main configurations : 
 * -> The configuration of the kernel. This configuration is compulsory and present in each user call. It based on the configuration file : global/config/Param.yml.
 * -> The configuration extended for the web project. This configuration is variable and programmable. It based on a configuration file : global/config/ParamExtend.yml.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

class ParamLoader extends \Framework\Library\Singleton
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * String used to start the kernel parameters. It's a static property because it's the same for all objects.
     * @var string
     */
	const PARAM_KERNEL_START = 'PARAM_KERNEL_'; //static private $strParamKernelStart
	
	/**
	 * String used to separate the kernel parameters. It's a static property because it's the same for all objects.
     * @var string
     */
	const SEPARATOR = ':'; //static private $strSeparator
	
	/**
	 * String used to comment the kernel parameters. It's a static property because it's the same for all objects.
     * @var string
     */
	const COMMENT_START = '#'; //$strCommentStart 
	
	/**
	 * The relative path of parameters file. It's a static property because it's the same for all objects.
     * @var string
     */
	const PARAM_KERNEL_PATH = 'global/config/Param.yml'; //$strPathParamKernel
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get an associate table from a specified configuration file.
	 * The specified path is considered as full.
	 * 
	 * Type of configuration :
	 * -> $intTypParam = 0 : it's a kernel configuration file
	 * -> $intTypParam = 1 (default) : it's an other configuration file
	 * 
	 * Type of array return : array[key of parameter] = value of parameter
	 * 
	 * 
     * @param $strPathFl, $intTypParam
	 * @return array
     */
	private function getParamFromFile($strPathFl, $intTypParam = 1)
    {
		// Init var
		$Result = array();
		
		// Check file
		if(file_exists($strPathFl))
		{
			// Open file
			$Fl = fopen($strPathFl, 'r');
			
			// Run all row in file
			while(!feof($Fl))
			{
				// Get Row
				$strRow = trim(fgets($Fl));
				
				// Check basic
				if
				(
					($strRow != '') && 
					(!(substr($strRow, 0, strlen(static::getCommentStart())) == static::getCommentStart())) && 
					(strpos($strRow, static::getSeparator()) !== false) && 
					(strlen($strRow) > (strlen(static::getSeparator()) + 1))
				)
				{
					// Check no conflict between kernel param and other params
					if
					(
						(($intTypParam == 0) && (substr($strRow, 0, strlen(static::getParamKernelStart())) == static::getParamKernelStart())) || 
						(($intTypParam != 0) && (!(substr($strRow, 0, strlen(static::getParamKernelStart())) == static::getParamKernelStart())))
					)
					{
						// Init var
						$tabStr = explode(static::getSeparator(), $strRow);
						$strKey = '';
						$strVal = '';
						
						// Set Key
						if(count($tabStr) > 1)
						{
							$strKey = trim($tabStr[0]);
						}
						
						// Set Val
						$strVal = trim(substr($strRow, strlen($strKey) + strlen(static::getSeparator())));
						
						// Set constant
						if((trim($strKey) != '') && (trim($strVal) != ''))
						{
							$Result[$strKey] = $strVal;
						}
					}
				}
			}
		}
		
		return $Result;
    }
	
	
	
	/**
	 * Get an associate table from a specified configuration file for configuration extended.
	 * The specified path is considered as full.
	 * This function is based upon the this feature : getParamExtend.
	 * 
	 * @see getParamFromFile()
     * @param $strPathFl
	 * @return array
     */
	public function getParamExtendFromFile($strPathFl)
    {
		$Result = $this->getParamFromFile($strPathFl, 1);
		return $Result;
    }
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Set constants from a specified configuration file.
	 * The specified path is considered as full.
	 * The feature is based upon the function getParamFromFile.
	 * 
	 * Type of configuration :
	 * -> $intTypParam = 0 : it's a kernel configuration file
	 * -> $intTypParam = 1 (default) : it's an other configuration file
	 * 
	 * Return boolean, true if success false else.
	 * 
	 * @see getNameSpace()
     * @param $strPathFl, $intTypParam
	 * @return boolean
     */
	private function setParamFromFile($strPathFl, $intTypParam = 1)
    {
		// Init var
		$Result = false;
		$tabStr = $this->getParamFromFile($strPathFl, $intTypParam);
		
		// Check exist param
		if(count($tabStr) > 0)
		{
			foreach ($tabStr as $key => $value)
			{
				if(!defined($key))
				{
					define($key , $value);
				}
			}
			
			$Result = true;
		}
		
		return $Result;
    }
	
	
	
	/**
	 * Set constants from the kernel configuration file.
	 * The feature is based upon the function setParamFromFile.
	 * Return boolean, true if success false else.
	 * 
	 * @see setParamFromFile()
	 * @return boolean
     */
	public function setParamKernel()
    {
		return $this->setParamFromFile(PARAM_KERNEL_PATH_ROOT.'/'.static::getPathParamKernel(), 0);
	}
	
	
	
	/**
	 * Set constants from the specified extended configuration file.
	 * Run all of configuration files written in the extended configuration file and launch the main function.
	 * Return boolean, true if success false else.
	 * 
	 * @return boolean
     */
	private function setParamExtend($strPathConfFl)
    {
		// Init var
		$Result = true;
		$tabStr = $this->getParamFromFile(PARAM_KERNEL_PATH_ROOT.'/'.$strPathConfFl, 1);
		
		// Check exist param
		if(count($tabStr) > 0)
		{
			foreach ($tabStr as $key => $value)
			{
				// Init var
				$boolProcessRun = false;
				$strPathFl = $value;
				$strFullPathFl = PARAM_KERNEL_PATH_ROOT.'/'.$strPathFl;
				
				// Check file
				if(file_exists($strFullPathFl))
				{
					try
					{
						// Splite
						$SpliterPath = $this->getSpliterPath($strPathFl);
						$strClassNm = $SpliterPath->getClassNm();
						
						// Inclusion class
						require_once($strFullPathFl);
						
						// Call class and method dynamically
						call_user_func_array(array(new $strClassNm(), 'run'), array());
						
						// Return true
						$boolProcessRun = true;
					}
					catch(Exception $e)
					{
						// echo($e->getMessage());
					}
					
				}
				
				// Return result
				$Result = $Result && $boolProcessRun;
			}
		}
		
		// Return
		return $Result;
	}
	
	
	
	/**
	 * Set constants from the extended configuration file during the basic level (executed before the standard level).
	 * Run all of configuration files written in the extended configuration file and launch the main function.
	 * Return boolean, true if success false else.
	 * 
	 * @return boolean
     */
	public function setParamExtendBasic()
    {
		return $this->setParamExtend(PARAM_KERNEL_PATH_PARAM_EXTEND_BASIC);
	}
	
	
	
	/**
	 * Set constants from the extended configuration file during the standard level (executed after the basic level).
	 * Run all of configuration files written in the extended configuration file and launch the main function.
	 * Return boolean, true if success false else.
	 * 
	 * @return boolean
     */
	public function setParamExtendStd()
    {
		return $this->setParamExtend(PARAM_KERNEL_PATH_PARAM_EXTEND_STD);
	}
	
	
	
	/**
	 * Set constants from a specified configuration file.
	 * The specified path is considered as full.
	 * The feature is based upon the function setParamFromFile.
	 * Return boolean, true if success false else.
	 * 
	 * @see setParamFromFile()
	 * @param $strPathFl
	 * @return boolean
     */
	public function setParamExtendFromFile($strPathFl)
    {
		return $this->setParamFromFile($strPathFl);
	}
	
	
	
	
	
	// Methods statics getters
	// ******************************************************************************
	
	/**
	 * Get the property
	 * 
	 * @see $this->strParamKernelStart
	 * @return string
     */
	static public function getParamKernelStart()
    {
		return static::PARAM_KERNEL_START;
	}
	
	
	
	/**
	 * Get the property
	 * 
	 * @see $this->strSeparator
	 * @return string
     */
	static public function getSeparator()
    {
		return static::SEPARATOR;
	}
	
	
	
	/**
	 * Get the property
	 * 
	 * @see $this->strCommentStart
	 * @return string
     */
	static public function getCommentStart()
    {
		return static::COMMENT_START;
	}
	
	
	
	/**
	 * Get the property
	 * 
	 * @see $this->strPathParamKernel
	 * @return string
     */
	static public function getPathParamKernel()
    {
		return static::PARAM_KERNEL_PATH;
	}
	
	
	
}