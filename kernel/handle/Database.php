<?php
/**
 * Short description :
 * This class is included to the group of elements handles database management.
 * 
 * Long description :
 * This class permit to manage the database connector.
 * It's based on PDO and use the MySQL driver. This class inherits the FrameworkHandle class.
 *  
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel\Handle;

use \Framework\Kernel\Handle\DatabaseTemplate;
use \Framework\Kernel\Handle\DatabaseStatement;

final class Database extends \Framework\Kernel\Handle\FrameworkHandle
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * String represents the connection text to connect to the database.
	 * As DNS in PDO : includes : -> Name of SGBD -> Name of DB -> Path : Host and port
     * @var string
     */
	private $strDbDns;
	
	/**
	 * String represents the login to connect to the database.
     * @var string
     */
	private $strDbLg;
	
	/**
	 * String represents the password to connect to the database.
     * @var string
     */
	private $strDbPw;
	
	/**
	 * Object represents the connector to the database.
     * @var \PDO
     */
	private $objDbEngine;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************

	public function __construct($strDbDns, $strDbLg, $strDbPw) 
	{
		// Set properties
		$this->setDataDbDns($strDbDns);
		$this->setDataDbLg($strDbLg);
		$this->setDataDbPw($strDbPw);
		
		// Set connection
		$this->setConnection();
	}
	
	public function __destruct() {
	
		$this->setDisconnection();
	}
	
	
	
	
	
	// Methods setters properties
	// ******************************************************************************
	
	/**
	 * Set the DB connection text.
	 * 
	 * @param $strDbDns
     */
	public function setDataDbDns($strDbDns)
	{
		$this->strDbDns = $strDbDns;
	}
	
	/**
	 * Set the DB connection login.
	 * 
	 * @param $strDbLg
     */
	public function setDataDbLg($strDbLg)
	{
		$this->strDbLg = $strDbLg;
	}
	
	/**
	 * Set the DB connection password.
	 * 
	 * @param $strDbPw
     */
	public function setDataDbPw($strDbPw)
	{
		$this->strDbPw = $strDbPw;
	}
	
	
	
	
	
	// Methods getters properties
	// ******************************************************************************
	
	/**
	 * Get the DB connection text.
	 * 
	 * @return string
     */
	public function getDataDbDns()
	{
		return $this->strDbDns;
	}
	
	/**
	 * Get the DB connection login.
	 * 
	 * @return string
     */
	public function getDataDbLg()
	{
		return $this->strDbLg;
	}
	
	/**
	 * Get the DB connection password.
	 * 
	 * @return string
     */
	public function getDataDbPw()
	{
		return $this->strDbPw;
	}
	
	/**
	 * Get the DB connector.
	 * 
	 * @return \PDO
     */
	public function getDbEngine()
	{
		return $this->objDbEngine;
	}
	
	
	
	
	
	// Connection / Disconnection
	// ******************************************************************************
	
	/**
	 * Set the connection to database.
	 * This feature permits to instantiate the DB connector ($this->objDbEngine).
     */
	public function setConnection() 
	{
		//Initialisation
		$this->objDbEngine = null;
		//echo('|'.$this->db_Svr .'|'.$this->db_Lg .'|'.$this->db_Pw .'|'. $this->db_Nm .'|<br />');
		
		if
		(
			(trim($this->strDbDns) != '') && 
			(trim($this->strDbLg) != '') && 
			(trim($this->strDbPw) != '')
		)
		{
			//echo('|'.$this->strDbDns.'|'.$this->strDbLg.'|'.$this->strDbPw.'|');
			try
			{
				//Connection DB cible, le @ permet a la fonction de ne pas retourner derreur
				$objDbEngine = new \PDO
				(
					$this->strDbDns,
					$this->strDbLg,
					$this->strDbPw
				);//array(\PDO::ATTR_PERSISTENT => true)
				
				//If no error, save connection
				$this->objDbEngine = $objDbEngine;
			}
			catch(\PDOException $e)
			{
				echo($e->getMessage());
			}
		}
	}
	
	
	
	/**
	 * Set the disconnection to database.
     */
	public function setDisconnection() 
	{
		if($this->objDbEngine != null)
		{
			$this->objDbEngine = null;
		}
	}
	
	
	
	
	
	// Methods check
	// ******************************************************************************
	
	/**
	 * Check if the object is connected to the database.
	 * Return boolean : true if connected, false else.
	 * 
	 * @return boolean
     */
	public function checkIsConnect() 
	{
		$Result = ($this->objDbEngine != null);
		
		return $Result;
	}
	
	
	
	
	
	// Methods Transaction
	// ******************************************************************************
	
	/**
	 * Function permits to check a transaction already start and is not finish. 
	 * Return boolean : true if you are within transaction false else.
	 * 
	 * @return boolean
     */
	public function transactionCheckRun()
	{
		$Result = false;
		
		if($this->checkIsConnect())
		{
			$Result = ($this->objDbEngine->inTransaction());
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to start a new transaction. 
	 * Return boolean : true if run with success, false else.
	 * 
	 * @return boolean
     */
	public function transactionStart() 
	{
		$Result = false;
		
		if(($this->checkIsConnect()) && (!$this->transactionCheckRun()))
		{
			$Result = ($this->objDbEngine->beginTransaction());
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to validate, execute and close transaction. 
	 * Return boolean : true if success to validate and execute, false else.
	 * 
	 * @return boolean
     */
	public function transactionCommit() 
	{
		$Result = false;
		
		if($this->checkIsConnect() && $this->transactionCheckRun())
		{
			$Result = ($this->objDbEngine->commit());
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to cancel and close transaction. 
	 * Return boolean : true if success to cancel, false else.
	 * 
	 * @return boolean
     */
	public function transactionRollBack() 
	{
		$Result = false;
		
		if($this->checkIsConnect() && $this->transactionCheckRun())
		{
			$Result = ($this->objDbEngine->rollBack());
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods SQL
	// ******************************************************************************
	
	/**
	 * Function permits to execute SQL without data returns. 
	 * Return false if doesn't run, the number of row affected else.
	 * 
	 * @param $strSQL
	 * @return boolean
     */
	public function sqlExecute($strSQL) 
	{
		$Result = false;
		
		if($strSQL != null)
		{
			if(trim($strSQL) != '')
			{
				if($this->checkIsConnect())
				{
					$sqlResult = $this->objDbEngine->exec($strSQL);
					$Result = ($strSQL !== false);
				}
			}
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to execute SQL with data returns. 
	 * Return false if doesn't run, object \Framework\Kernel\Handle\DatabaseStatement else.
	 * 
	 * @param $strSQL
	 * @return \Framework\Kernel\Handle\DatabaseStatement if success, false else
     */
	public function sqlExecuteQuery($strSQL) 
	{
		$Result = false;
		
		if($strSQL != null)
		{
			if(trim($strSQL) != '')
			{
				if($this->checkIsConnect())
				{
					$Result = new DatabaseStatement($this->objDbEngine->query($strSQL));
				}
			}
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods SQL dlookup
	// ******************************************************************************
	
	/**
	 * Function permits to search one value. 
	 * Return string value if find it, empty else.
	 * 
	 * @param $strNmTable, $strColTarget, $strWhere
	 * @return string
     */
	public function sqlDLookUp($strNmTable, $strColTarget, $strWhere) 
	{
		$Result = '';
		
		if($this->checkIsConnect())
		{
			// Despecialize
			//$strNmTable = $this->getEscapeVal($strNmTable);
			//$strColTarget = $this->getEscapeVal($strColTarget);
			
			// Build SQL
			$strSQL = "SELECT ".$strColTarget." FROM ".$strNmTable." WHERE (".$strWhere.");";
			
			// Run SQL
			if($sqlStmt = $this->sqlExecuteQuery($strSQL))
			{
				if(($sqlData = $sqlStmt->getDataFromColNm($strColTarget, 0)) && ($sqlStmt->getCountCol() > 0) && ($sqlStmt->getCountRow() > 0))
				{
					// Get info
					$Result = $sqlData;
				}
			}
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to search one value with one criteria. 
	 * The feature is based upon the function sqlDLookUp.
	 * 
     * @see sqlDLookUp()
	 * @param $strNmTable, $strColTarget, $strColWhere, $strValWhere
	 * @return string
     */
	public function sqlDLookUpOneCriteria($strNmTable, $strColTarget, $strColWhere, $strValWhere) 
	{
		$Result = '';
		
		if($this->checkIsConnect())
		{
			// Despecialize
			//$strColWhere = $this->getEscapeVal($strColWhere);
			$strValWhere = $this->getEscapeVal($strValWhere);
			
			// Build SQL
			$strSqlWhere = "".$strColWhere." = ".$strValWhere."";
			
			// Get info
			$Result = $this->sqlDLookUp($strNmTable, $strColTarget, $strSqlWhere);
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods SQL template (stocked process)
	// ******************************************************************************
	
	/**
	 * Function permits to get the stocked process based on the command SQL. 
	 * Return false if doesn't run, object \Framework\Kernel\Handle\DatabaseTemplate else.
	 * 
	 * @param $strSQL
	 * @return \Framework\Kernel\Handle\DatabaseTemplate if success, false else
     */
	public function sqlTemplateGet($strSQL) 
	{
		$Result = false;
		
		if($strSQL != null)
		{
			if(trim($strSQL) != '')
			{
				if($this->checkIsConnect())
				{
					$Result = new DatabaseTemplate($this->objDbEngine->prepare($strSQL));
				}
			}
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Function permits to escape specials characters in a specified value. 
	 * Warning, it's not necessary to add simple quotes around the value, this function handles this feature.
	 * 
	 * @param $strVal
	 * @return string
     */
	public function getEscapeVal($strVal) 
	{
		$Result = $strVal;
		
		if($this->checkIsConnect())
		{
			$Result = $this->objDbEngine->quote($strVal);
		}
		
		return $Result;
	}
	
	
	
} 