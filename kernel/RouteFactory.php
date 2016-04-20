<?php
/**
 * Short description :
 * The class which handle of routes part of the framework.
 * 
 * Long description :
 * This class represent the class which handle of routes. It's class inherits the singleton.
 * The class permit to load, search and get all routes of the web project.
 * It based on the configuration file : global/config/Routing.yml.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class RouteFactory extends \Framework\Library\Singleton
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Index table used to stock in memory, all of the configured routes.
     * @var array
     */
	protected $tabRoute;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct() 
	{
		parent::__construct();
		$tabRoute = array();
		
		$this->setRouteTab();
	}
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Load all routes from the configuration file of routes, to the memory, in table $this->tabRoute.
	 * 
	 * @return array
     */
	private function setRouteTab()
    {
		// Init var
		$Result = array();
		$strPathFl = PARAM_KERNEL_PATH_ROOT.'/'.PARAM_KERNEL_PATH_ROUTING;
		$ParamLoader = $this->getParamLoader();
		
		// Check file
		if(file_exists($strPathFl))
		{
			// Open file
			$Fl = fopen($strPathFl, 'r');
			// Run all row in file
			while(!feof($Fl))
			{
				// Init var
				$strNm = '';
				$strUrl = '';
				$strPath = '';
				$strRow = trim(fgets($Fl));
				$strKeyDefault = PARAM_KERNEL_ROUTE_CONF_DEFAULT.$ParamLoader::getSeparator();
				
				
				// Get nm
				if(substr($strRow, 0, strlen($strKeyDefault)) == $strKeyDefault) // Check if it is default route
				{
					$strNm = PARAM_KERNEL_ROUTE_CONF_DEFAULT;
				}
				else if
				(
					(substr($strRow, 0, strlen(PARAM_KERNEL_ROUTE_CONF_NM)) == PARAM_KERNEL_ROUTE_CONF_NM) && 
					(strlen($strRow) > strlen(PARAM_KERNEL_ROUTE_CONF_NM))
				)
				{
					$strNm = trim(substr($strRow, strlen(PARAM_KERNEL_ROUTE_CONF_NM)));
					$strNm = substr($strNm, 0, (strlen($strNm) - 1));
					
					if($strNm == PARAM_KERNEL_ROUTE_CONF_DEFAULT)
					{
						$strNm = '';
					}
				}
			
				// Check nm exists
				if(trim($strNm) != '')
				{
					// Get url
					if(!feof($Fl))
					{
						$strKey = PARAM_KERNEL_ROUTE_CONF_URL.$ParamLoader::getSeparator();
						$strRow = trim(fgets($Fl));
						if(substr($strRow, 0, strlen($strKey)) == $strKey)
						{
							$strUrl = trim(substr($strRow, strlen($strKey)));
						}
						
						// Get path
						if(!feof($Fl))
						{
							$strKey = PARAM_KERNEL_ROUTE_CONF_PATH.$ParamLoader::getSeparator();
							$strRow = trim(fgets($Fl));
							if(substr($strRow, 0, strlen($strKey)) == $strKey)
							{
								$strPath = trim(substr($strRow, strlen($strKey)));
							}
						}
					}
				}
				
				// Add route if ok
				if((trim($strNm) != '') && (trim($strUrl) != '') && (trim($strPath) != ''))
				{
					$Result[] = new \Framework\Kernel\Route($strNm, $strUrl, $strPath);
				}
			}
			fclose($Fl);
		}
		
		// Return result
		$this->tabRoute = $Result;
		return $Result;
    }
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get one route with a type of criteria ($strKey) and the value of criteria ($strVal) from table of routes.
	 * There are three types of criteria :
	 * -> Find a route by the name.
	 * -> Find a route by the URL used by user.
	 * -> Find a route by the path used in the server part.
	 * 
	 * @param $strKey, $strVal
	 * @return \Framework\Kernel\Route if success, null else
     */
	private function getRoute($strKey, $strVal)
    {
		$Result = null;
		
		// Init var
		$cpt = 0;
		$boolFind = false;
		$tabRoute = $this->tabRoute;
		
		// Run tabRoute
		while(($cpt < Count($tabRoute)) && (!$boolFind))
		{
			// Check in
			if($strKey == PARAM_KERNEL_ROUTE_TAG_URL) // In the specific case of url
			{
				// Obtain spliter url
				$SpliterUrl = $this->getSpliterUrl($tabRoute[$cpt]->getData($strKey) , $strVal);
				// Check
				$boolFind = $SpliterUrl->checkUrlPattern();
			}
			else // In the other cases
			{
				$boolFind = ($tabRoute[$cpt]->getData($strKey) == $strVal);
			}
			
			if($boolFind)
			{
				$Result = $tabRoute[$cpt];
			}
			
			$cpt++;
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get one route from the name.
	 * The feature is based upon the function getRoute.
	 * 
     * @see getRoute()
	 * @param $strNm
	 * @return \Framework\Kernel\Route if success, null else
     */
	public function getRoute_FromNm($strNm)
    {
		$Result = $this->getRoute(PARAM_KERNEL_ROUTE_TAG_NM, $strNm);
		return $Result;
    }
	
	
	
	/**
	 * Get one route from the URL.
	 * The feature is based upon the function getRoute.
	 * 
     * @see getRoute()
	 * @param $strNm
	 * @return \Framework\Kernel\Route if success, null else
     */
	public function getRoute_FromUrl($strUrl)
    {
		$Result = $this->getRoute(PARAM_KERNEL_ROUTE_TAG_URL, $strUrl);
		return $Result;
    }
	
	
	
	/**
	 * Get one route from the path.
	 * The feature is based upon the function getRoute.
	 * 
     * @see getRoute()
	 * @param $strNm
	 * @return \Framework\Kernel\Route if success, null else
     */
	public function getRoute_FromPath($strPath)
    {
		$Result = $this->getRoute(PARAM_KERNEL_ROUTE_TAG_PATH, $strPath);
		return $Result;
    }
	
	
	
	/**
	 * Get an index table of all route keys.
	 * 
	 * @return array
     */
	public function getTabKey()
    {
		// Init var
		$Result = array();
		
		// Run all routes
		foreach($this->tabRoute as $value)
		{
			$Result[] = $value->getNm();
		}
		
		// Return
		return $Result;
    }
	
	
	
}