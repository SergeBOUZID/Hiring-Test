<?php
/**
 * Short description :
 * The class inherits of framework class and represent a toolbox to splite a route path.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

final class SpliterPath extends \Framework\Library\Framework
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Specific path used in a route.
     * @var string
     */
	protected $strPath;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct($strPath) 
	{
		$this->strPath = $strPath;
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
     * Get table of info upon the path.
	 * Array return : 
	 * -> tab[0] = path module
	 * -> tab[1] = class name
	 * -> tab[2] = method name
	 * 
     * @return array
     */	
	protected function getPathInfo()
    {
		// Init var
		$Result = array('','','');
		$tabStr = explode(PARAM_KERNEL_ROUTE_SEPARATOR, $this->strPath);
		$strModPath = '';
		$strClassNm = '';
		$strActionNm = '';
		
		if((count($tabStr) == 1) || (count($tabStr) == 2))
		{
			// Set path and action
			$strModPath = trim($tabStr[0]);
			if(count($tabStr) == 2) // Get
			{
				$strActionNm = trim($tabStr[1]);
			}
			
			// Set class name
			if
			(
				(strpos($strModPath, '/') !== false) && 
				(strpos($strModPath, '.') !== false) && 
				(strlen($strModPath)>2)
			)
			{
				$tabStr = explode('/', $strModPath);
				$str = $tabStr[count($tabStr)-1];
				$tabStr = explode('.', $str);
				$strClassNm = trim($tabStr[0]);
				
				$ToolboxNameSpace = $this->getToolboxNameSpace();
				$strNS = $ToolboxNameSpace::getNameSpaceReprocess(PARAM_KERNEL_PATH_ROOT.'/'.$strModPath);
				$strClassNm = $strNS.$strClassNm;
			}
			
			// Check Path
			if(file_exists(PARAM_KERNEL_PATH_ROOT.'/'.$strModPath))
			{
				$Result[0] = $strModPath;
			}
			
			// Put other infos
			$Result[1] = $strClassNm;
			$Result[2] = $strActionNm;
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
     * Get one info upon the path : path in the application.
	 * Use the table of info getter
	 * 
     * @return string
     */
	public function getModulePath()
    {
		$tabInfo = $this->getPathInfo();
		return $tabInfo[0];
    }
	
	
	
	/**
     * Get one info upon the path : class name.
	 * Use the table of info getter
	 * 
     * @return string
     */
	public function getClassNm()
    {
		$tabInfo = $this->getPathInfo();
		return $tabInfo[1];
    }
	
	
	
	/**
     * Get one info upon the path : action name (name of method)
	 * Use the table of info getter
	 * 
     * @return string
     */
	public function getActionNm()
    {
		$tabInfo = $this->getPathInfo();
		return $tabInfo[2];
    }

	
	
}