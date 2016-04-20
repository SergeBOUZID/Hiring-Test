<?php
/**
 * Short description :
 * The class which handle of the components loading part of the framework.
 * 
 * Long description :
 * This class represent the class which handle of the components loading. It's class inherits the singleton.
 * There is two main components loading : 
 * -> The loading of components kernel. This configuration is pre-made. It based on the configuration file : global/config/LoadingKernelHandle.yml.
 * -> The loading of other components in the web project. It based on the configuration file : global/config/Loading.yml.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class ComponentLoader extends \Framework\Library\Singleton
{	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Methods check
	// ******************************************************************************
	
	/**
	 * Check if the active route is include in the specified string.
	 * The specified string represent include or exclude string.
	 * 
     * @param $strVal
	 * @return boolean
     */
	private function checkIncExc($strVal)
	{
		// Init var
		$Result = false;
		$strDelimiter = '#';// Used to born pattern in function preg_...
		$tabStr = explode(PARAM_KERNEL_COMP_VAR_RTE_SEPARATOR, $strVal);
		$cpt = 0;
		$find = false;
		$strRouteActivNm = $this->getKernel()->routeActivGetNm();
		
		// Check valid inputs
		if((trim($strVal) != '') && (count($tabStr) > 0))
		{
			// Run and find
			while(($cpt < count($tabStr)) && (!$find))
			{
				
				// Check value
				$find = ($tabStr[$cpt] == PARAM_KERNEL_COMP_VAR_RTE_ALL); // Check if all routes
				
				if(!$find)
				{
					$find = (($tabStr[$cpt] == $strRouteActivNm) && (trim($strRouteActivNm) != '')); // Check equality
					
					if(!$find)
					{
						$find = ((preg_match($strDelimiter.$tabStr[$cpt].$strDelimiter, $strRouteActivNm) == 1) && (trim($strRouteActivNm) != '')); // Check pattern
					}
				}
				
				$cpt++;
			}
			
			$Result = $find;
		}
		
		// Return
		return $Result;
	}
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Load all components specified in the components loading file specified.
	 * The specified path is considered as full.
	 * 
     * @param $strPathFl
	 * @return boolean
     */
	private function setLoad($strPathFl)
    {
		// Init var
		$Result = false;
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
				$strPath = '';
				$strInclude = '';
				$strExclude = '';
				
				// Get nm
				$strRow = trim(fgets($Fl));
				if
				(
					(substr($strRow, 0, strlen(PARAM_KERNEL_COMP_CONF_NM)) == PARAM_KERNEL_COMP_CONF_NM) && 
					(strlen($strRow) > strlen(PARAM_KERNEL_COMP_CONF_NM))
				)
				{
					$strNm = trim(substr($strRow, strlen(PARAM_KERNEL_COMP_CONF_NM)));
					$strNm = substr($strNm, 0, (strlen($strNm) - 1));
					
					// Get path
					if(!feof($Fl))
					{
						$strKey = PARAM_KERNEL_COMP_CONF_PATH.$ParamLoader::getSeparator();
						$strRow = trim(fgets($Fl));
						if(substr($strRow, 0, strlen($strKey)) == $strKey)
						{
							$strPath = trim(substr($strRow, strlen($strKey)));
						}
						
						// Get include
						if(!feof($Fl))
						{
							$strKey = PARAM_KERNEL_COMP_CONF_INC.$ParamLoader::getSeparator();
							$strRow = trim(fgets($Fl));
							if(substr($strRow, 0, strlen($strKey)) == $strKey)
							{
								$strInclude = trim(substr($strRow, strlen($strKey)));
							}
							
							// Get exclude
							if(!feof($Fl))
							{
								$strKey = PARAM_KERNEL_COMP_CONF_EXC.$ParamLoader::getSeparator();
								$strRow = trim(fgets($Fl));
								if(substr($strRow, 0, strlen($strKey)) == $strKey)
								{
									$strExclude = trim(substr($strRow, strlen($strKey)));
								}
							}
						}
					}
				}
				
				// Process load if ok
				if((trim($strNm) != '') && (trim($strPath) != '') && ((trim($strInclude) != '') || (trim($strExclude) != '')))
				{
					// Build full path
					$strPathFull = PARAM_KERNEL_PATH_ROOT.'/'.$strPath;
					
					// Check route activ is in the selection
					$checkRteActiv = file_exists($strPathFull);
					if($checkRteActiv)
					{
						$checkRteActiv = true;
						
						if(trim($strInclude) != '')
						{
							$checkRteActiv = $this->checkIncExc($strInclude);
						}
						
						if(trim($strExclude) != '')
						{
							$checkRteActiv = $checkRteActiv && (!$this->checkIncExc($strExclude));
						}
					}
					
					// Inclusion component
					if($checkRteActiv)
					{
						require_once($strPathFull);
						$Result = true;
					}
				}
			}
			fclose($Fl);
		}
		
		return $Result;
    }
	
	
	
	/**
	 * Load all components specified in the kernel handle components loading file.
	 * The feature is based upon the function setLoad.
	 * 
     * @see setLoad()
	 * @return boolean
     */
	public function setLoadKernelHandle()
    {
		return $this->setLoad(PARAM_KERNEL_PATH_ROOT.'/'.PARAM_KERNEL_PATH_COMP_KRN_HANDLE);
    }
	
	
	
	/**
	 * Load all components from a specified configuration components loading file.
	 * The feature is based upon the function setLoad.
	 * 
     * @see setLoad()
	 * @return boolean
     */
	private function setLoadConfig($strPathConfFl)
    {
		return $this->setLoad(PARAM_KERNEL_PATH_ROOT.'/'.$strPathConfFl);
    }
	
	
	
	/**
	 * Load all components from a configuration components loading file during the basic level (executed before the standard level).
	 * The feature is based upon the function setLoadConfig.
	 * 
     * @see setLoadConfig()
	 * @return boolean
     */
	public function setLoadConfigBasic()
    {
		return $this->setLoadConfig(PARAM_KERNEL_PATH_COMP_CONF_BASIC);
    }
	
	
	
	/**
	 * Load all components from a configuration components loading file during the standard level (executed after the basic level).
	 * The feature is based upon the function setLoadConfig.
	 * 
     * @see setLoadConfig()
	 * @return boolean
     */
	public function setLoadConfigStd()
    {
		return $this->setLoadConfig(PARAM_KERNEL_PATH_COMP_CONF_STD);
    }
	
	
	
}