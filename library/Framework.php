<?php
/**
 * Short description :
 * The main source class of all the framework.
 * 
 * Long description :
 * This class represent the main source class.
 * All class for kernel and other elements of this framework inherits of this class.
 * It contains mainly all access for featuring and kernel classes.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

abstract class Framework
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Methods Getters library
	// ******************************************************************************
	
	/**
     * Get the following toolbox object.
	 * 
     * @return \Framework\Library\ToolboxNameSpace
     */
	public function getToolboxNameSpace()
	{
		return new \Framework\Library\ToolboxNameSpace();
	}
	
	
	
	/**
     * Get the following toolbox object.
	 * 
     * @return \Framework\Library\ToolboxRand
     */
	public function getToolboxRand()
	{
		return new \Framework\Library\ToolboxRand();
	}
	
	
	
	/**
     * Get the following toolbox object.
	 * 
     * @return \Framework\Library\ToolboxRand
     */
	public function getToolboxString()
	{
		return new \Framework\Library\ToolboxString();
	}
	
	
	
	/**
     * Get the following toolbox object.
	 * 
     * @param $strPath
     * @return \Framework\Library\SpliterPath
     */
	protected function getSpliterPath($strPath)
	{
		return new \Framework\Library\SpliterPath($strPath);
	}
	
	
	
	/**
     * Get the following toolbox object.
	 * 
     * @param $strUrlPattern, $strUrlActiv
     * @return \Framework\Library\SpliterUrl
     */
	protected function getSpliterUrl($strUrlPattern, $strUrlActiv)
	{
		return new \Framework\Library\SpliterUrl($strUrlPattern, $strUrlActiv);
	}
	
	
	
	/**
     * Get the following toolbox object.
	 * 
     * @param $strArg
     * @return \Framework\Library\SpliterArg
     */
	protected function getSpliterArg($strArg)
	{
		return new \Framework\Library\SpliterArg($strArg);
	}
	
	
	
	
	
	// Methods Getters kernel
	// ******************************************************************************
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\Kernel
     */
	protected function getKernel()
	{
		return \Framework\Kernel\Kernel::getInstance();
	}
	
	
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\ParamLoader
     */
	protected function getParamLoader()
	{
		return \Framework\Kernel\ParamLoader::getInstance();
	}
	
	
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\ComponentLoader
     */
	protected function getComponentLoader()
	{
		return \Framework\Kernel\ComponentLoader::getInstance();
	}
	
	
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\RouteFactory
     */
	protected function getRouteFactory()
	{
		return \Framework\Kernel\RouteFactory::getInstance();
	}
	
	
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\ServiceFactory
     */
	protected function getServiceFactory()
	{
		return \Framework\Kernel\ServiceFactory::getInstance();
	}
	
	
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\SaveManager
     */
	protected function getSaveManager()
	{
		return \Framework\Kernel\SaveManager::getInstance();
	}
	
	
	
	/**
     * Get the following kernel object.
	 * 
     * @return \Framework\Kernel\ViewEngine
     */
	protected function getViewEngine()
	{
		return \Framework\Kernel\ViewEngine::getInstance();
	}
	
	
	
	
	
	// Methods Getters other
	// ******************************************************************************
	
	/**
     * Get the first part of the called Url, common of each called Url.
	 * 
     * @return string
     */
	protected function getStrUrlSrc() 
	{
		$strUrlSrc = $_SERVER['REQUEST_URI'];
		
		// Re treatment 
		if(strpos($strUrlSrc, '?') !== false)
		{
			$tabStr = explode('?', $strUrlSrc);
			$strUrlSrc = $tabStr[0];
		}
		
		$strUrlActiv = $this->getKernel()->urlActivGet();
		$Result = trim(substr($strUrlSrc, 0, (strlen($strUrlSrc)-strlen($strUrlActiv))));
		//$_SERVER['HTTP_HOST'].
		
		return $Result;
	}
	
	
	
	/**
     * Get the full URL or not in the web project.
	 * 
	 * @param $strUrl, $boolIsUrlFull
     * @return string
     */
	protected function getStrUrlProject($strUrl, $boolIsUrlFull = false) 
	{
		// Set URL
		if(!$boolIsUrlFull)
		{
			$strUrl = $this->getStrUrlSrc().$strUrl;
		}
		
		// Return
		return $strUrl;
	}
	
	
	
	/**
     * Get the path complete or not in the web project on the server part.
	 * 
	 * @param $strPathFl, $boolIsPathFull
     * @return string
     */
	protected function getStrPathProject($strPathFl, $boolIsPathFull = false)
	{
		// Set path file
		if(!$boolIsPathFull)
		{
			$strPathFl = PARAM_KERNEL_PATH_ROOT.$strPathFl;
		}
		
		// Return
		return $strPathFl;
	}
	
	
	
	
	
	// Methods setters 
	// ******************************************************************************
	
	/**
     * Load component if there are need, with a specified file.
	 * The path may be relative (default) or absolute.
	 * 
	 * @param $strPathFl, $boolIsPathFull
     */
	protected function setInclude($strPathFl, $boolIsPathFull = false)
	{
		// Get path file
		if(trim($strPathFl) != '')
		{
			$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		}
		
		// Load file
		require_once($strPathFl);
	}
	
	
	
}
