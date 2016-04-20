<?php
 /**
 * Short description :
 * The main source class of all classes where features will be used in the web project.
 * 
 * Long description :
 * This class represent the main source class of all classes will be used in the web project.
 * All features permit to access more simply and directly to kernel function without to get kernel classes.
 * The aim of this element is to be extended.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

abstract class FrameworkUse extends \Framework\Library\Framework
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Methods param
	// ******************************************************************************
	
	/**
	 * Get an associate table from a specified configuration file for configuration extended.
	 * The path ($strPathFl) may be considered as relative (default) or absolute with the parameter $boolPathFull.
	 * 
     * @param $strPathFl, $boolIsPathFull = false
	 * @return array
     */
	public function getParam($strPathFl, $boolIsPathFull = false)
	{
		$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		return $this->getParamLoader()->getParamExtendFromFile($strPathFl);
	}
	
	
	
	/**
	 * Load in memory the extended configuration file.
	 * The path ($strPathFl) may be considered as relative (default) or absolute with the parameter $boolPathFull.
	 * Return boolean, true if success false else.
	 * 
	 * @param $strPathFl, $boolIsPathFull = false
	 * @return boolean
     */
	public function setParam($strPathFl, $boolIsPathFull = false)
    {
		$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		return $this->getParamLoader()->setParamExtendFromFile($strPathFl);
    }
	
	
	
	
	
	// Methods routes
	// ******************************************************************************
	
	/**
	 * Get a route from the name.
	 * 
	 * @param $strNm
	 * @return \Framework\Kernel\Route if success, null else
     */
	private function getRouteObj($strNm)
	{
		return $this->getRouteFactory()->getRoute_FromNm($strNm);
	}
	
	
	
	/**
	 * Get a route information from the name and a type of criteria.
	 * There are three types of criteria :
	 * -> The name.
	 * -> The URL used by user.
	 * -> The path used in the server part.
	 * 
	 * @param $strNm, $strInfoKey
	 * @return string
     */
	private function getRouteInfo($strNm, $strInfoKey)
	{
		$Result = '';
		$route = $this->getRouteObj($strNm);
		
		if(!is_null($route))
		{
			$Result = $route->getData($strInfoKey);
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Get an index table of all route keys.
	 * 
	 * @return array
     */
	public function getRouteTabKey()
	{
		return $this->getRouteFactory()->getTabKey();
	}
	
	
	
	/**
	 * Get a route URL from the name, full or not.
	 * The feature is based upon the function getRouteInfo.
	 * 
     * @see getRouteInfo()
	 * @param $strNm, $tabParam = array(), $boolUrlFull = false
	 * @return string
     */
	public function getRouteUrl($strNm, $tabParam = array(), $boolUrlFull = true)
	{
		$Result = '';
		$route = $this->getRouteObj($strNm);
		
		if(!is_null($route))
		{
			// Get URL
			$Result = $route->getUrl($tabParam);
			
			// Get full URL or not
			if(trim($Result) != '')
			{
				$Result = $this->getStrUrlProject($Result, (!$boolUrlFull));
			}
		}
		
		return $Result; //$this->getRouteInfo($strNm, PARAM_KERNEL_ROUTE_TAG_URL);
	}
	
	
	
	/**
	 * Get a route path from the name, full or not.
	 * The feature is based upon the function getRouteInfo.
	 * 
     * @see getRouteInfo()
	 * @param $strNm, $boolPathFull = false
	 * @return string
     */
	public function getRoutePath($strNm, $boolPathFull = true)
	{
		// Get path
		$Result = $this->getRouteInfo($strNm, PARAM_KERNEL_ROUTE_TAG_PATH);
		
		// Get full path or not
		if(trim($Result) != '')
		{
			$Result = $this->getStrPathProject($Result, (!$boolPathFull));
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods default route
	// ******************************************************************************
	
	/**
	 * Get the default route if it is configured.
	 * 
	 * @return \Framework\Kernel\Route if success, null else
     */
	private function getRouteDefault()
	{
		return $this->getRouteFactory()->getRoute_FromNm(PARAM_KERNEL_ROUTE_CONF_DEFAULT);
	}
	
	
	
	/**
	 * Get the name of the default route.
	 * 
	 * @return string
     */
	public function getRouteDefaultNm()
	{
		$Result = '';
		$route = $this->getRouteDefault();
		
		if(!is_null($route))
		{
			// Get name
			$Result = $route->getNm();
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Get the default route url if it is configured.
	 * The feature is based upon the function getRouteDefault.
	 * 
     * @see getRouteDefault()
	 * @param $tabParam = array(), $boolUrlFull = false
	 * @return string
     */
	public function getRouteDefaultUrl($tabParam = array(), $boolUrlFull = true)
	{
		$Result = '';
		$route = $this->getRouteDefault();
		
		if(!is_null($route))
		{
			// Get URL
			$Result = $route->getUrl($tabParam);
			
			// Get full URL or not
			if(trim($Result) != '')
			{
				$Result = $this->getStrUrlProject($Result, (!$boolUrlFull));
			}
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Get the default route path if it is configured.
	 * The feature is based upon the function getRouteDefault.
	 * 
     * @see getRouteDefault()
	 * @param $boolPathFull = false
	 * @return string
     */
	public function getRouteDefaultPath($boolPathFull = true)
	{
		$Result = '';
		$route = $this->getRouteDefault();
		
		if(!is_null($route))
		{
			// Get path
			$Result = $route->getPath();
			
			// Get full path or not
			if(trim($Result) != '')
			{
				$Result = $this->getStrPathProject($Result, (!$boolPathFull));
			}
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods active route
	// ******************************************************************************
	
	/**
	 * Get the name of the active route (called by the user).
	 * 
	 * @return string
     */
	public function getRouteActivNm()
	{
		return $this->getKernel()->routeActivGetNm();
	}
	
	
	
	/**
	 * Get the URL of the active route (called by the user).
	 * It's the strict URL and not the pattern URL which is return.
	 * 
	 * @param $boolUrlFull = false
	 * @return string
     */
	public function getRouteActivUrl($boolUrlFull = true)
	{
		// Get URL
		$Result = $this->getKernel()->routeActivGetUrl();
		
		// Get full URL or not
		if(trim($Result) != '')
		{
			$Result = $this->getStrUrlProject($Result, (!$boolUrlFull));
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Get the table of arguments from the URL of the active route (called by the user).
	 * It's the strict URL and not the pattern URL which is return. 
	 * Array param : 
	 * -> $intTypArray = 0 (default) : index table
	 * -> $intTypArray = 1 : associate table
	 * 
	 * @param $intTypArray = 0
	 * @return array
     */
	public function getRouteActivUrlTableArg($intTypArray = 0)
	{
		$strUrlPattern = $this->getRouteUrl($this->getRouteActivNm(), array(), false);
		$strUrlActiv = $this->getKernel()->routeActivGetUrl();
		$SpliterUrl = $this->getSpliterUrl($strUrlPattern, $strUrlActiv);
		
		return $SpliterUrl->getTabArgs($intTypArray);
	}
	
	
	
	/**
	 * Get the path of the active route (called by the user).
	 * 
	 * @param $boolPathFull = false
	 * @return string
     */
	public function getRouteActivPath($boolPathFull = true)
	{
		// Get path
		$Result = $this->getKernel()->routeActivGetPath();
		
		// Get full path or not
		if(trim($Result) != '')
		{
			$Result = $this->getStrPathProject($Result, (!$boolPathFull));
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods service
	// ******************************************************************************
	
	/**
	 * Get a service.
	 * 
	 * @see \Framework\Kernel\ServiceFactory::getService()
	 * @param $strNm
	 * @return object if success, null else
     */
	public function getService($strNm)
	{
		return $this->getServiceFactory()->getService($strNm);
	}
	
	
	
	/**
	 * Get an index table of all service keys.
	 * 
	 * @return array
     */
	public function getServiceTabKey()
	{
		return $this->getServiceFactory()->getTabKey($strNm);
	}
	
	
	
	
	
	// Methods save
	// ******************************************************************************
	
	/**
	 * Check if a save is set in memory.
	 * 
	 * @see \Framework\Kernel\SaveManager::checkExists()
	 * @param $strKey
	 * @return boolean
     */
	public function checkSaveExists($strKey)
	{
		return $this->getSaveManager()->checkExists($strKey);
	}
	
	
	
	/**
	 * Check a specified save is a session or no from a specified key.
	 * 
	 * @param $strKey
	 * @return boolean
     */
	public function checkSaveIsSession($strKey)
	{
		return $this->getSaveManager()->checkIsSession($strKey);
	}
	
	
	
	/**
	 * Check a specified save is a cookie or no from a specified key.
	 * 
	 * @param $strKey
	 * @return boolean
     */
	public function checkSaveIsCookie($strKey)
	{
		return $this->getSaveManager()->checkIsCookie($strKey);
	}
	
	
	
	/**
	 * Get a save.
	 * 
	 * @see \Framework\Kernel\getSaveManager::get()
	 * @param $strKey
	 * @return object if success, null else
     */
	public function getSave($strKey)
	{
		return $this->getSaveManager()->get($strKey);
	}
	
	
	
	/**
	 * Get an index table of all save keys.
	 * 
	 * @return array
     */
	public function getSaveTabKey()
	{
		return $this->getSaveManager()->getTabKey();
	}
	
	
	
	/**
	 * Set a save.
	 * 
	 * @see \Framework\Kernel\getSaveManager::set()
	 * @param $strKey, $objVal, $boolPutInSession = false, $boolPutInCookie = false, $intTimeCookie = 0, $strPathCookie = '/'
	 * @return boolean
     */
	public function setSave($strKey, $objVal, $boolPutInSession = false, $boolPutInCookie = false, $intTimeCookie = 0, $strPathCookie = '/')
	{
		return $this->getSaveManager()->set($strKey, $objVal, $boolPutInSession, $boolPutInCookie, $intTimeCookie, $strPathCookie);
	}
	
	
	
	/**
	 * Remove a save from a specified key.
	 * 
	 * @see \Framework\Kernel\getSaveManager::remove()
	 * @param $strKey
	 * @return boolean
     */
	public function removeSave($strKey)
    {
		return $this->getSaveManager()->remove($strKey);
    }
	
	
	
	
	
	// Methods view engine
	// ******************************************************************************
	
	/**
	 * Get the text render.
	 * 
	 * @see \Framework\Kernel\ViewEngine::renderGetStr()
	 * @param $strPathFl, $tabArg = array(), $tabBlock = array(), $boolIsPathFull = false
	 * @return string
     */
	public function getRenderStr($strPathFl, $tabArg = array(), $tabBlock = array(), $boolIsPathFull = false)
	{
		if(trim($strPathFl) != '')
		{
			$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		}
		
		return $this->getViewEngine()->renderGetStr($strPathFl, $tabArg, $tabBlock);
	}
	
	
	
	/**
	 * Set the text render.
	 * 
	 * @see \Framework\Kernel\ViewEngine::renderSet()
	 * @param $strPathFl, $tabArg = array(), $tabBlock = array(), $boolIsPathFull = false
     */
	public function setRender($strPathFl, $tabArg = array(), $tabBlock = array(), $boolIsPathFull = false)
	{
		if(trim($strPathFl) != '')
		{
			$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		}
		
		$this->getViewEngine()->renderSet($strPathFl, $tabArg, $tabBlock);
	}
	
	
	
	/**
	 * Set the specified text render.
	 * 
	 * @see \Framework\Kernel\ViewEngine::renderSetStr()
	 * @param $strRender
     */
	public function setRenderStr($strRender)
	{
		$this->getViewEngine()->renderSetStr($strRender);
	}
	
	
	
	/**
     * Load component in a render, from a specified file.
	 * The path may be relative (default) or absolute.
	 * 
	 * @param $strPathFl, $boolIsPathFull
     */
	public function setRenderInclude($strPathFl, $boolIsPathFull = false)
	{
		// Get path file
		if(trim($strPathFl) != '')
		{
			$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		}
		
		// Load file
		$this->getViewEngine()->renderSetInclude($strPathFl);
	}
	
	
	
	/**
	 * Set a redirection from a specified URL.
	 * 
	 * @see \Framework\Kernel\ViewEngine::redirect()
	 * @param $strUrl, $boolIsUrlFull = false, $tabArgGet = null
     */
	public function redirectUrl($strUrl, $boolIsUrlFull = true, $tabArgGet = null)
	{
		// Get full URL or not
		if(trim($strUrl) != '')
		{
			$strUrl = $this->getStrUrlProject($strUrl, $boolIsUrlFull);
		}
		
		$this->getViewEngine()->redirect($strUrl, $tabArgGet);
	}
	
	
	
	/**
	 * Set a redirection from a specified route name.
	 * The feature is based upon the function redirect.
	 * 
	 * @see redirect()
	 * @param $strNm, $tabParam = array(), $tabArgGet = null
     */
	public function redirectRouteNm($strNm, $tabParam = array(), $tabArgGet = null)
	{
		$strRouteUrl = $this->getRouteUrl($strNm, $tabParam);
		
		if(trim($strRouteUrl) != '')
		{
			$this->redirectUrl($strRouteUrl, true, $tabArgGet);
		}
	}
	
	
	
	/**
	 * Set a redirection to the default route.
	 * The feature is based upon the function redirect.
	 * 
	 * @see redirect()
	 * @param $tabParam = array(), $tabArgGet = null
     */
	public function redirectRouteDefault($tabParam = array(), $tabArgGet = null)
	{
		$this->redirectUrl($this->getRouteDefaultUrl($tabParam), true, $tabArgGet);
	}
	
	
	
	/**
	 * Set a redirection to the active route.
	 * The feature is based upon the function redirect.
	 * 
	 * @see redirect()
	 * @param $strNm, $tabArgGet = null
     */
	public function redirectRouteActiv($tabArgGet = null)
	{
		$this->redirectUrl($this->getRouteActivUrl(), true, $tabArgGet);
	}
	
	
	
	// Methods hide value
	// ******************************************************************************
	
	/**
	 * Get the hidden value from a specified key, in a specified file of template.
	 * It return false if limits not found, the string between limits else.
	 * 
	 * @see \Framework\Kernel\ViewEngine::hideValueGetStr()
	 * @param $strKey, $strPathFl
	 * @return string
     */
	public function getStrHideValue($strKey, $strPathFl, $boolIsPathFull = false)
    {
		if(trim($strPathFl) != '')
		{
			$strPathFl = $this->getStrPathProject($strPathFl, $boolIsPathFull);
		}
		
		return $this->getViewEngine()->hideValueGetStr($strKey, $strPathFl);
	}
	
	
	
}

