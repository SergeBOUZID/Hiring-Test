<?php
/**
 * Short description :
 * The class inherits of framework class and represent the design pattern 'Singleton' of the framework.
 * 
 * Long description :
 * This class is the singleton which be used for all singletons in the framework.
 * A singleton is a class permit to instantiate only one object for all the web project.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Library;

abstract class Singleton extends \Framework\Library\FrameworkUse
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	protected function __construct() 
	{
		
	}
	
	final public function __clone()
    {
        throw new LogicException(sprintf('Cloning an instance of `%s` is not allowed.', get_class($this)));
    }
	
	
	
	
	
	// Methodes statics
	// ******************************************************************************
	final static public function getInstance()
    {
		// Declare this variable here because in propertie declaration, the extends doesn't work
		static $instance;
		
		if(is_null($instance))
		{
			$instance = new static;  
		}
		
		return $instance;
    }
	
	
	
}