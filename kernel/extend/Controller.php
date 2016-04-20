<?php
/**
 * Short description :
 * This class represent the controller of the MVC pattern.
 * 
 * Long description :
 * This class represent the controller. This class inherits the FrameworkExtend class.
 * It's the element which is called to build the response for the user.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel\Extend;

abstract class Controller extends \Framework\Kernel\Extend\FrameworkExtend
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
	
	
	
	
	
	// Action list
	// ******************************************************************************
	
	/**
	 * This function is the default method called for the controller.
	 * If an active route permits to access to a controller, but no method are specified or valid, this method are called.
	 * This function must be redefined.
     */
	public abstract function actionIndex();
	
	
	
}
