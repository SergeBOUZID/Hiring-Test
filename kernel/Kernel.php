<?php
/**
 * Short description :
 * The class represent the kernel of the framework.
 * 
 * Long description :
 * This class represent the kernel of the framework. It's class inherits the singleton.
 * The class permit to manage the main features of the framework and manage the web project.
 * It permit to manage :
 * -> Configuration with the help of the system class ParamLoader.
 * -> Components loading with the help of the system class ComponentLoader.
 * -> Routes with the help of the system class RouteFactory.
 * -> Services with the help of the system class ServiceFactory.
 * -> Sessions with the help of the system class SessionManager.
 * -> Views with the help of the system class ViewEngine.
 * -> All of others features in the framework.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class Kernel extends \Framework\Library\Singleton
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Route used by user from the called on specified pattern URL.
     * @var \Framework\Kernel\Route
     */
	protected $routeActiv;
	
	/**
	 * The strict URL called by the user.
     * @var string
     */
	protected $urlActiv;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	protected function __construct() 
	{
		parent::__construct();
		
		$this->routeActiv = null;
		$this->urlActiv = '';
	}
	
	
	
	
	
	// Main process
	// ******************************************************************************
	
	/**
	 * The main feature which runs all main functions, from get the user request (treatment of the URL called), to build the answer to the user.
     */
	public function run() 
	{
		// Init Kernel
		// ***
		// Param Kernel
		$this->getParamLoader()->setParamKernel(); // Run param kernel
		$this->urlActivSet(); // Set the url
		$this->routeActivSet(); // Set the route
		
		// Loading Kernel
		$this->getComponentLoader()->setLoadKernelHandle();
		
		
		
		// Init basic level
		// ***
		// Param extended basic
		$this->getParamLoader()->setParamExtendBasic();
		
		// Loading basic
		$this->getComponentLoader()->setLoadConfigBasic();
		
		// Param extended basic reload, after components loading
		$this->getParamLoader()->setParamExtendBasic();
		
		// Load save
		$this->getSaveManager()->setInitToMemory();
		
		
		
		// Init standard level
		// ***
		// Param extended std
		$this->getParamLoader()->setParamExtendStd();
		
		// Loading std
		$this->getComponentLoader()->setLoadConfigStd();
		
		// Param extended std, after components loading
		$this->getParamLoader()->setParamExtendStd();
		
		
		
		// Route run
		// ***
		$boolProcess = $this->routeRun();
		if(!$boolProcess)
		{
			if(is_null($this->routeActiv))
			{
				echo('<h1>Error : Impossible to run route!</h1>');
			}
			else
			{
				echo('<h1>Error : Impossible to run route ('.$this->routeActiv->getNm().')!</h1>');
			}
		}
		
		
		
		// Stock save
		// ***
		$this->getSaveManager()->setInitToEngine();
		
		
		
		// Run view engine (redirection or render)
		// ***
		$this->getViewEngine()->run();
	}
	
	
	
	
	
	// Routing
	// ******************************************************************************
	
	/**
	 * Main process concerned the part of the treatment of the routes of the framework.
	 * Load all routes and treatment of the active route (called route by the user).
     */
	private function routeRun() 
	{
		// Init var
		$Result = false;
		$strRouteUrl = $this->getRouteDefaultUrl();
		$strRoutePath = $this->getRouteDefaultPath(false);
		if(!is_null($this->routeActiv))
		{
			$strRouteUrl = $this->routeActiv->getUrl();
			$strRoutePath = $this->routeActiv->getPath();
		}
		
		// Get path module and action
		$SpliterPath = $this->getSpliterPath($strRoutePath);
		$strPath = $SpliterPath->getModulePath();
		$strClassNm = $SpliterPath->getClassNm();
		$strAction = $SpliterPath->getActionNm();
		if(trim($strAction) == '')
		{
			$strAction = 'actionIndex';
		}
		
		// Check path module and action
		if((trim($strPath) != '') && (trim($strClassNm) != '') && (trim($strAction) != ''))
		{
			// Inclusion class
			require_once(PARAM_KERNEL_PATH_ROOT.'/'.$strPath);
			
			// Obtain tab args
			$SpliterUrl = $this->getSpliterUrl($strRouteUrl, $this->urlActiv);
			
			// Call class and method dynamically
			//$objController = new $strClassNm();
			//$objController->$strAction();
			call_user_func_array(array(new $strClassNm(), $strAction), $SpliterUrl->getTabArgs());
			
			$Result = true;
		}
		
		// Return result
		return $Result;
	}
	
	
	
	/**
	 * Set the active URL (The strict URL called by the user).
     */
	private function urlActivSet() 
	{
		$Result = '/';
		
		if(isset($_GET[PARAM_KERNEL_ROUTE_TAG_ARG]))
		{
			$Result = '/'.$_GET[PARAM_KERNEL_ROUTE_TAG_ARG];
		}
		
		$this->urlActiv = $Result;
		return $Result;
	}
	
	
	
	/**
	 * Get the active URL (The strict URL called by the user).
     */
	public function urlActivGet() 
	{
		return $this->urlActiv;
	}
	
	
	
	/**
	 * Set the active route (The route called by the user).
     */
	private function routeActivSet() 
	{
		// Get route arg
		$strUrl = $this->urlActiv;
		
		// Get route obj
		if(trim($strUrl) != '')
		{
			// Get RouteFactory
			$RouteFactory = $this->getRouteFactory();
			$Result = $RouteFactory->getRoute_FromUrl($strUrl);
		}
		
		// Return result
		$this->routeActiv = $Result;
		return $Result;
	}
	
	
	
	/**
	 * Get the active route (The route called by the user).
     */
	private function routeActivGet()
	{
		return $this->routeActiv;
	}
	
	
	
	/**
	 * Get informations about the active route.
     */
	private function routeActivGetInfo($strInfoKey)
	{
		$Result = '';
		$route = $this->routeActivGet();
		
		if(!is_null($route))
		{
			$Result = $route->getData($strInfoKey);
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Get the name about the active route.
     */
	public function routeActivGetNm()
	{
		return $this->routeActivGetInfo(PARAM_KERNEL_ROUTE_TAG_NM);
	}
	
	
	
	/**
	 * Get the pattern URL about the active route.
     */
	public function routeActivGetUrl()
	{
		return $this->urlActiv; //$this->routeActivGetInfo(PARAM_KERNEL_ROUTE_TAG_URL);
	}
	
	
	
	/**
	 * Get the path of the server part about the active route.
     */
	public function routeActivGetPath()
	{
		return $this->routeActivGetInfo(PARAM_KERNEL_ROUTE_TAG_PATH);
	}
	
	
	
}