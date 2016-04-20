<?php
/**
 * Short description :
 * The class which handle of services part of the framework.
 * 
 * Long description :
 * This class represent the class which handle of services. It's class inherits the singleton.
 * The class permit to load, search and get / instantiate all services of the web project.
 * It based on the configuration file : global/config/Service.yml.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class ServiceFactory extends \Framework\Library\Singleton
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Associate table used to stock in memory, all of the configured services.
     * @var array
     */
	private $tabSvcConfig;
	
	/**
	 * Associate table used to stock in memory, all of the objects instantiated by a call of a service.
     * @var array
     */
	private $tabSvcObj;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	protected function __construct() 
	{
		parent::__construct();
		
		$this->tabSvcConfig = array();
		$this->tabSvcObj = array();
		
		$this->setSvcConfig();
	}
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Load all services from the configuration file of services, to the memory, in table $this->tabSvcConfig.
	 * 
	 * @return array
     */
	private function setSvcConfig()
    {
		// Init var
		$Result = array();
		$strPathFl = PARAM_KERNEL_PATH_ROOT.'/'.PARAM_KERNEL_PATH_SERVICE;
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
				$strSvcNm = '';
				$strSvcPath = '';
				$strSvcArg = '';
				
				// Get nm
				$strRow = trim(fgets($Fl));
				if
				(
					(substr($strRow, 0, strlen(PARAM_KERNEL_SVC_CONF_NM)) == PARAM_KERNEL_SVC_CONF_NM) && 
					(strlen($strRow) > strlen(PARAM_KERNEL_SVC_CONF_NM))
				)
				{
					$strSvcNm = trim(substr($strRow, strlen(PARAM_KERNEL_SVC_CONF_NM)));
					$strSvcNm = substr($strSvcNm, 0, (strlen($strSvcNm) - 1));
					
					// Get path
					if(!feof($Fl))
					{
						$strKey = PARAM_KERNEL_SVC_CONF_PATH.$ParamLoader::getSeparator();
						$strRow = trim(fgets($Fl));
						if(substr($strRow, 0, strlen($strKey)) == $strKey)
						{
							$strSvcPath = trim(substr($strRow, strlen($strKey)));
						}
						
						// Get path
						if(!feof($Fl))
						{
							$strKey = PARAM_KERNEL_SVC_CONF_ARG.$ParamLoader::getSeparator();
							$strRow = trim(fgets($Fl));
							if(substr($strRow, 0, strlen($strKey)) == $strKey)
							{
								$strSvcArg = trim(substr($strRow, strlen($strKey)));
							}
						}
					}
				}
				
				// Add route if ok
				if((trim($strSvcNm) != '') && (trim($strSvcPath) != '')) // && (trim($strSvcArg) != ''))
				{
					$Result[$strSvcNm] = new \Framework\Kernel\Service($strSvcNm, $strSvcPath, $strSvcArg);
				}
			}
			fclose($Fl);
		}
		
		// Return result
		$this->tabSvcConfig = $Result;
		return $Result;
    }
	
	
	
	/**
	 * Load a specified service to the memory, in table $this->tabSvcObj, if it not already exists.
	 * Return true if it's setting well (creation or already exist).
	 * 
	 * @param $strNm
	 * @return boolean
     */
	private function setService($strNm)
    {
		// Init var
		$Result = true;
		
		if(!array_key_exists($strNm, $this->tabSvcObj))
		{
			$Result = false;
			if(array_key_exists($strNm, $this->tabSvcConfig))
			{
				// Load service
				$objSvcConfig = $this->tabSvcConfig[$strNm];
				$strSvcNm = $objSvcConfig->getNm();
				$ObjSvc = $objSvcConfig->getObj();
				
				// Save in memory
				if(($strSvcNm == $strNm) && (!is_null($ObjSvc)))
				{
					$this->tabSvcObj[$strSvcNm] = $ObjSvc;
					
					$Result = true;
				}
			}
		}
		
		// Return
		return $Result;
    }
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get a specified service from the name.
	 * The service is load before if it not already exists.
	 * Return true if it's setting well (creation or already exist).
	 * 
	 * @param $strNm
	 * @return object if success, null else
     */
	public function getService($strNm)
    {
		// Init var
		$Result = null;
		
		// Check setting well
		if($this->setService($strNm))
		{
			if(array_key_exists ($strNm, $this->tabSvcObj))
			{
				// Obtain object
				$Result = $this->tabSvcObj[$strNm];
			}
		}
		
		// Return
		return $Result;
    }
	
	
	
	/**
	 * Get an index table of all service keys.
	 * 
	 * @return array
     */
	public function getTabKey()
    {
		// Init var
		$Result = array();
		
		// Run all services
		foreach($this->tabSvcConfig as $key => $value)
		{
			$Result[] = $key;
		}
		
		// Return
		return $Result;
    }
	
	
	
}