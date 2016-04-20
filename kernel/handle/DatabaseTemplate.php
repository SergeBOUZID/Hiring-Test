<?php
/**
 * Short description :
 * This class is included to the group of elements handles database management.
 * 
 * Long description :
 * This class permit to manage the stocked process.
 * It's based on PDO. This class inherits the FrameworkHandle class.
 *  
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel\Handle;

use \Framework\Kernel\Handle\DatabaseStatement;

final class DatabaseTemplate extends \Framework\Kernel\Handle\FrameworkHandle
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Object represents the PDO SQL statement which is used for stored procedure.
     * @var \PDOStatement
     */
	private $objStatement;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************

	public function __construct($objStatement) 
	{
		// Set properties
		$this->setStatement($objStatement);
	}
	
	public function __destruct() {
	
		$this->objStatement = null;
	}
	
	
	
	
	
	// Methods setters / getters statement
	// ******************************************************************************
	
	/**
	 * Set the DB statement.
	 * 
	 * @param $objStatement
     */
	public function setStatement($objStatement)
	{
		$this->objStatement = $objStatement;
	}
	
	
	
	/**
	 * Get the DB statement.
	 * 
	 * @return \PDOStatement
     */
	public function getStatement()
	{
		return $this->objStatement;
	}
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Function permits to set parameters to link variables values to prepare DB statement.
	 * Return true if success, false else.
	 * 
	 * @param $strKeyParam, &$variableValue
	 * @return boolean
     */
	public function setParamLink($strKeyParam, &$variableValue, $type = \PDO::PARAM_STR) 
	{
		return $this->objStatement->bindParam($strKeyParam, $variableValue, $type);
	}
	
	
	
	
	
	// Methods execute
	// ******************************************************************************
	
	/**
	 * Function permits to execute statement with parameters set before.
	 * Return true if success, false else.
	 * 
	 * @return boolean
     */
	public function execute() 
	{
		return $this->objStatement->execute();
	}
	
	
	
	/**
	 * Function permits to execute statement with parameters set before.
	 * Return false if doesn't run, object \Framework\Kernel\Handle\DatabaseStatement else.
	 * 
	 * @return \Framework\Kernel\Handle\DatabaseStatement if success, false else
     */
	public function executeQuery() 
	{
		$Result = $this->objStatement->execute();
		
		if($Result)
		{
			$Result = new DatabaseStatement($this->objStatement);
		}
		
		return $Result;
	}
	
	
	
} 