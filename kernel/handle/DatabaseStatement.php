<?php
/**
 * Short description :
 * This class is included to the group of elements handles database management.
 * 
 * Long description :
 * This class permit to manage the SQL result.
 * It's based on PDO. This class inherits the FrameworkHandle class.
 *  
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel\Handle;

final class DatabaseStatement extends \Framework\Kernel\Handle\FrameworkHandle
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Object represents the PDO SQL statement which is used to get information.
     * @var \PDOStatement
     */
	private $objStatement;
	
	/**
	 * The number of columns in the SQL statement.
     * @var integer
     */
	private $countCol;
	
	/**
	 * The number of rows in the SQL statement.
     * @var integer
     */
	private $countRow;
	
	/**
	 * The index table with all columns of the SQL statement.
     * @var array
     */
	private $tabCol;
	
	/**
	 * The specific table with all data of the SQL statement.
	 * Composition : array[columns index][row index]
     * @var array
     */
	private $tabData;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************

	public function __construct($objStatement) 
	{
		// Set properties
		$this->setStatement($objStatement);
		
		// Set count
		$this->setCountCol();
		$this->setCountRow();
		
		// Set table
		$this->tabCol = null;
		$this->tabData = null;
		$this->setTab();
	}
	
	public function __destruct() 
	{
	
		$this->objStatement = null;
		
		$this->countCol = 0;
		$this->countRow = 0;
		
		$this->tabCol = null;
		$this->tabData = null;
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
	
	
	
	
	
	// Methods tab
	// ******************************************************************************
	
	/**
	 * Function permits to put tables of columns and data in memory from the DB statement. 
	 * Composition :
	 * -> Table of columns : $this->tabCol : array[columns index]
	 * -> Table of data : $this->tabData : array[columns index][row index]
     */
	private function setTab() 
	{
		$objStatement = $this->getStatement();
		
		if($objStatement != null)
		{
				$tabCol = array();
				$tabData = array();
				
				// Run Rows
				while($tabRow = $objStatement->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT, 0))
				{	
					$cpt = 0;
					foreach($tabRow as $key => $value)
					{
						// Set column if doesn't exist
						if(!isset($tabCol[$cpt]))
						{
							$tabCol[] = $key;
						}
						
						// Set data
						if(!isset($tabData[$cpt]))
						{
							$tabData[] = array();
						}
						$tabData[$cpt][] = $value;
						
						// Cursor
						$cpt++;
					}
				}
				
				// Set properties
				$this->tabCol = $tabCol;
				$this->tabData = $tabData;
		}
	}
	
	
	
	/**
	 * Function permits to check table is not empty.
	 * Only the property tables are accepted.
	 * 
	 * @param $tab
	 * @return boolean
     */
	private function checkTab($tab) 
	{
		$Result = false;
		
		if(!is_null($tab))
		{
			if(is_array($tab))
			{
				if(count($tab) > 0)
				{
					$Result = true;
				}
			}
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods getters column
	// ******************************************************************************
	
	/**
	 * Function permits to get the name of a column from an specified index.
	 * The index is an integer which starts by 0 and finish to (getCountCol() - 1).
	 * Return the name of the columns if it finds, false else.
	 * 
	 * @see getCountCol()
	 * @param $index
	 * @return string if success, false else
     */
	public function getColNm($index)
	{
		$Result = false;
		
		// Check index
		if(($this->checkTab($this->tabCol)) && (is_int($index)))
		{
			if(($index >= 0) && ($index < $this->getCountCol()))
			{
				// Get name
				$Result = $this->tabCol[$index];
			}
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to get the index of a column from a specified name.
	 * The index is an integer which starts by 0 and finish to (getCountCol() - 1).
	 * Return the index of the columns if it finds, false else.
	 * 
	 * @see getCountCol()
	 * @param $strNm
	 * @return integer if success, false else
     */
	public function getColIndex($strNm)
	{
		$Result = false;
		
		// Check strNm
		if((!is_null($strNm)) && ($this->checkTab($this->tabCol)))
		{
			if(trim($strNm) != '')
			{
				$cpt = 0;
				$find = false;
				
				// Run tabCol
				while(($cpt < $this->getCountCol()) && (!$find))
				{
					$find = ($this->tabCol[$cpt] == $strNm);
					$cpt++;
				}
				
				// If find
				if($find)
				{
					$cpt--;
					$Result = $cpt;
				}
			}
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods getters data
	// ******************************************************************************
	
	/**
	 * Function permits to get a precise data from an specified name of column and an specified index of row.
	 * The index of row is an integer which starts by 0 and finish to (getCountRow() - 1).
	 * Return the data if it finds, false else.
	 * The feature is based upon the function getDataFromColIndex.
	 * 
	 * @see getDataFromColIndex()
	 * @see getCountRow()
	 * @param $strColNm, $indexRow
	 * @return string if success, false else
     */
	public function getDataFromColNm($strColNm, $indexRow)
	{
		$Result = false;
		
		try
		{
			$Result = $this->getDataFromColIndex($this->getColIndex($strColNm), $indexRow);
		}
		catch(Exception $e)
		{
			echo($e->getMessage());
		}
		
		return $Result;
	}
	
	
	
	/**
	 * Function permits to get a precise data from an specified index of column and an specified index of row.
	 * The index is an integer which starts by 0 and finish to (getCountCol() - 1) for columns or (getCountRow() - 1) for rows.
	 * Return the data if it finds, false else.
	 * 
	 * @see getCountCol()
	 * @see getCountRow()
	 * @param $indexCol, $indexRow
	 * @return string if success, false else
     */
	public function getDataFromColIndex($indexCol, $indexRow)
	{
		$Result = false;
		
		try
		{
			$Result = $this->tabData[$indexCol][$indexRow];
		}
		catch(Exception $e)
		{
			echo($e->getMessage());
		}
		
		return $Result;
	}
	
	
	
	
	
	// Methods setters / getters count
	// ******************************************************************************
	
	/**
	 * Function permits to set the number of columns from the DB statement.
     */
	private function setCountCol() 
	{
		$this->countCol = 0;
		$objStatement = $this->getStatement();
		
		if($objStatement != null)
		{
			$this->countCol = $objStatement->columnCount();
		}
	}
	
	
	
	/**
	 * Function permits to get the number of columns from properties.
	 *
	 * @return integer
     */
	public function getCountCol() 
	{
		return $this->countCol;
	}
	
	
	
	/**
	 * Function permits to set the number of rows from the DB statement.
     */
	private function setCountRow() 
	{
		$this->countRow = 0;
		$objStatement = $this->getStatement();
		
		if($objStatement != null)
		{
			$this->countRow = $objStatement->rowCount();
		}
	}
	
	
	
	/**
	 * Function permits to get the number of rows from properties.
	 *
	 * @return integer
     */
	public function getCountRow() 
	{
		return $this->countRow;
	}
	
	
	
} 