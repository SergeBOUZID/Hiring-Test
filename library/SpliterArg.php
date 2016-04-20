<?php
/**
 * Short description :
 * The class inherits of framework class and represent a toolbox to splite a service string arguments.
 * There is mainly three types of arguments : [service_id], {parameter}, "plain_value".
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

final class SpliterArg extends \Framework\Library\Framework
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Pattern arguments from the configuration of a service.
     * @var string
     */
	protected $strArg;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct($strArg) 
	{
		$this->strArg = $strArg;
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get the value from one string argument :
	 * -> [service_id] -> service_id
	 * -> {parameter} -> parameter
	 * -> "plain_value" -> plain_value
	 * 
     * @param $strVal, $strStart, $strEnd
	 * @return string
     */
	private function getArgConfigEngine($strVal, $strStart, $strEnd)
    {
		// Init var
		$Result = '';
		$strVal = trim($strVal);
		
		// Check long
		if(strlen($strVal) > (strlen($strStart) + strlen($strEnd)))
		{
			// Check characters start and end
			if
			(
				(substr($strVal, 0, strlen($strStart)) == $strStart) && 
				(substr($strVal, (strlen($strVal)-strlen($strEnd))) == $strEnd)
			)
			{
				// Get value
				$Result = trim(substr($strVal, strlen($strStart), (strlen($strVal)-strlen($strEnd)-1)));
			}
			
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get the value instantiate from one string argument :
	 * -> [service_id] -> object(service_id)
	 * -> {parameter} -> string constant(parameter)
	 * -> "plain_value" -> string plain_value
	 * 
     * @param $strVal
	 * @return mixed
     */
	private function getArgValueEngine($strVal)
    {
		// Init var
		$Result = null;
		$strVal = trim($strVal);
		$ServiceFactory = $this->getServiceFactory();
		
		
		// Check svc id
		$strValConfig = $this->getArgConfigEngine($strVal, PARAM_KERNEL_SVC_ARG_SVC_ID_START, PARAM_KERNEL_SVC_ARG_SVC_ID_END);
		if(trim($strValConfig) != '')
		{
			// Get service
			$Result = $ServiceFactory->getService($strValConfig);
		}
		else
		{
			// Check constant
			$strValConfig = $this->getArgConfigEngine($strVal, PARAM_KERNEL_SVC_ARG_CONST_START, PARAM_KERNEL_SVC_ARG_CONST_END);
			if(trim($strValConfig) != '')
			{
				// Get constant
				if(defined($strValConfig))
				{
					$Result = constant($strValConfig);
				}
			}
			else
			{
				// Check value
				$strValConfig = $this->getArgConfigEngine($strVal, PARAM_KERNEL_SVC_ARG_VAL_START, PARAM_KERNEL_SVC_ARG_VAL_END);
				if(trim($strValConfig) != '')
				{
					// Get value
					$Result = $strValConfig;
				}
			}
			
		}
		
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get all values instantiates in index table from the string list of arguments :
	 * 
	 * @return array
     */
	public function getTabArgs()
    {
		// Init var
		$Result = array();
		
		// Splite and run
		$tabStr = explode(PARAM_KERNEL_SVC_ARG_SEPARATOR, $this->strArg);
		for($cpt = 0; $cpt<count($tabStr); $cpt++)
		{
			$objVal = $this->getArgValueEngine($tabStr[$cpt]);
			$Result[] = $objVal;
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get the value instantiate in string from one string argument :
	 * -> [service_id] -> string (object(service_id))
	 * -> {parameter} -> string (string constant(parameter))
	 * -> "plain_value" -> string plain_value
	 * 
     * @param $strVal
	 * @return string
     */
	private function getArgStrValueEngine($strVal)
    {
		// Init var
		$Result = '';
		$strVal = trim($strVal);
		
		
		// Check svc id
		$strValConfig = $this->getArgConfigEngine($strVal, PARAM_KERNEL_SVC_ARG_SVC_ID_START, PARAM_KERNEL_SVC_ARG_SVC_ID_END);
		if(trim($strValConfig) != '')
		{
			// Get service
			$Result = '$this->getServiceFactory()->getService(\''.str_replace('\'', '\\\'', $strValConfig).'\')';
		}
		else
		{
			// Check constant
			$strValConfig = $this->getArgConfigEngine($strVal, PARAM_KERNEL_SVC_ARG_CONST_START, PARAM_KERNEL_SVC_ARG_CONST_END);
			
			if(trim($strValConfig) != '')
			{
				// Get constant
				if(defined($strValConfig))
				{
					$Result = 'constant(\''.str_replace('\'', '\\\'', $strValConfig).'\')';
				}
			}
			else
			{
				// Check value
				$strValConfig = $this->getArgConfigEngine($strVal, PARAM_KERNEL_SVC_ARG_VAL_START, PARAM_KERNEL_SVC_ARG_VAL_END);
				if(trim($strValConfig) != '')
				{
					// Get value
					$Result = '\''.str_replace('\'', '\\\'', $strValConfig).'\'';
				}
			}
			
		}
		
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Get all values instantiates in one string from the string list of arguments :
	 * 
	 * @return string
     */
	public function getStrArgs()
    {
		// Init var
		$Result = '';
		
		// Splite and run
		$tabStr = explode(PARAM_KERNEL_SVC_ARG_SEPARATOR, $this->strArg);
		
		for($cpt = 0; $cpt<count($tabStr); $cpt++)
		{
			$strVal = $this->getArgStrValueEngine($tabStr[$cpt]);
			
			if(trim($strVal) != '')
			{
				if(trim($Result) != '')
				{
					$Result = $Result.', ';
				}
				$Result = $Result.$strVal;
			}
		}
		
		// Return result
		return $Result;
    }
	
	
	
}