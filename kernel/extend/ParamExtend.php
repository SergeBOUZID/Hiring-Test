<?php
/**
 * Short description :
 * This class permit to manage the configuration extended for the web project.
 * 
 * Long description :
 * This class represent the management of the configuration extended. This class inherits the FrameworkExtend class.
 * It's permit to load configuration file by programming process.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel\Extend;

abstract class ParamExtend extends \Framework\Kernel\Extend\FrameworkExtend
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	public function __construct() 
	{
		
	}
	
	public function __destruct() 
	{
		
	}
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * This function is the main feature called in the kernel.
	 * It permits to program rules to load specific parameters.
	 * This function must be redefined.
     */
	public abstract function run();
	
	
	
}