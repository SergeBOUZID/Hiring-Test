<?php

use \Framework\Kernel\Extend\Model;

class ListData extends Model
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * This property represents the text sql without part where included criteria.
     * @var string
     */
	protected $strSqlModel;
	
	
	
	/**
	 * This property represents the array of operations by criteria.
     * @var array
     */
	protected $tabCritOperation;
	
	
	
	/**
	 * This property represents the array of values by criteria.
     * @var array
     */
	protected $tabCritValue;
	
	
	
	/**
	 * This property represents the the number of row per page.
     * @var integer
     */
	protected $intPageNbRow;
	
	
	
	/**
	 * This property represents the active page.
     * @var integer
     */
	protected $intPageActive;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	
	public function __construct($strSqlModel, $tabCritOperation, $intPageNbRow) 
	{
		$this->strSqlModel = $strSqlModel;
		$this->tabCritOperation = $tabCritOperation;
		$this->tabCritValue = array();
		$this->intPageNbRow = $intPageNbRow;
		$this->intPageActive = 1;
	}
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	public function setCritValue($strCrit, $strValue)
	{
		if(array_key_exists($strCrit, $this->tabCritOperation))
		{
			$this->tabCritValue[$strCrit] = $strValue;
		}
	}
	
	
	
	public function setPageActive($intPage)
	{
		if($this->getRowCount() > 0)
		{
			if($intPage < 1)
			{
				$this->intPageActive = 1;
			}
			else if($intPage > $this->getPageCount())
			{
				$this->intPageActive = $this->getPageCount();
			}
			else
			{
				$this->intPageActive = $intPage;
			}
		}
		else
		{
			$this->intPageActive = 1;
		}
	}
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	public function getRowCount()
	{
		$Result = 0;
		$objDb = $this->getService(CONF_TAG_SVC_DB);
		
		if($objDb->checkIsConnect())
		{
			$strSql = $this->getStrSql(true, false);
			if($objSqlQuery = $objDb->sqlExecuteQuery($strSql))
			{
				$Result = $objSqlQuery->getCountRow();
			}
		}
		
		return $Result;
	}
	
	
	
	public function getPageCount()
	{
		$Result = 0;
		$objDb = $this->getService(CONF_TAG_SVC_DB);
		
		if($objDb->checkIsConnect())
		{
			$intRowCount = $this->getRowCount();
			
			if($intRowCount > 0)
			{
				$Result = ceil($this->getRowCount()/intval($this->intPageNbRow));
			}
		}
		
		return $Result;
	}
	
	
	
	public function getPageActive()
	{
		return $this->intPageActive;
	}
	
	
	
	public function getTabCritKey()
	{
		$Result = array();
		
		foreach($this->tabCritOperation as $key => $value)
		{
			$Result[] = $key;
		}
		
		return $Result;
	}
	
	
	
	public function getCritValue($strCrit)
	{
		$Result = '';
		
		if(array_key_exists($strCrit, $this->tabCritValue))
		{
			$Result = $this->tabCritValue[$strCrit];
		}
		
		return $Result;
	}
	
	
	
	private function getStrSqlCriteria()
	{
		$Result = '';
		$objDb = $this->getService(CONF_TAG_SVC_DB);
		
		if($objDb->checkIsConnect())
		{
			foreach($this->tabCritValue as $key => $value)
			{
				if(array_key_exists($key, $this->tabCritOperation))
				{
					if(trim($Result) != '')
					{
						$Result = $Result.' AND ';
					}
					
					$Result = $Result.'('.str_replace(CONF_TAG_LIST_SQL_OPE_VALUE, $objDb->getEscapeVal($value), $this->tabCritOperation[$key]).')';
				}
			}
		}
		
		return $Result;
	}
	
	
	
	private function getStrSqlLimit()
	{
		$Result = '';
		
		$intLimOffset = (($this->intPageActive-1) * $this->intPageNbRow);
		$intLimCount = $this->intPageNbRow;
		
		$Result = 'LIMIT '.$intLimOffset.', '.$intLimCount;
		
		return $Result;
	}
	
	
	
	private function getStrSql($boolWithCriteria, $boolWithSqlLimit)
	{
		// Init var
		$Result = $this->strSqlModel;
		
		// Process with criteria if need
		if($boolWithCriteria)
		{
			// Get sql criteria
			$strSqlCriteria = $this->getStrSqlCriteria();
			
			// Re treatment sql criteria 
			if(trim($strSqlCriteria) != '')
			{
				if(strpos(strtolower($Result), 'where') === false)
				{
					$strSqlCriteria = ' WHERE('.$strSqlCriteria.') ';
				}
				else
				{
					$strSqlCriteria = ' AND ('.$strSqlCriteria.') ';
				}
			}
			
			// Replace 
			$Result = str_replace(CONF_TAG_LIST_SQL_CRITERIA, $strSqlCriteria, $Result);
		}
		else
		{
			$Result = str_replace(CONF_TAG_LIST_SQL_CRITERIA, '', $Result);
		}
		
		// Process with limit if need
		if($boolWithSqlLimit)
		{
			// Get sql limit
			$strSqlLimit = $this->getStrSqlLimit();
			
			// Replace 
			$Result = str_replace(CONF_TAG_LIST_SQL_LIMIT, $strSqlLimit, $Result);
		}
		else
		{
			$Result = str_replace(CONF_TAG_LIST_SQL_LIMIT, '', $Result);
		}
		
		// return result
		return $Result;
	}
	
	
	
	public function getTabResult()
	{
		// Init var
		$Result = array();
		$objDb = $this->getService(CONF_TAG_SVC_DB);
		
		if($objDb->checkIsConnect())
		{
			$strSql = $this->getStrSql(true, true);
			//echo('|'.$strSql.'|');
			
			if($objSqlQuery = $objDb->sqlExecuteQuery($strSql))
			{
				if(($objSqlQuery->getCountRow() > 0) && ($objSqlQuery->getCountCol() > 0))
				{
					// Run columns
					for($cpt = 0; $cpt < $objSqlQuery->getCountCol(); $cpt++) 
					{
						// Set columns result
						$strKey = $objSqlQuery->getColNm($cpt);
						$Result[$strKey] = array();
						
						// Run rows
						for($cpt2 = 0; $cpt2 < $objSqlQuery->getCountRow(); $cpt2++) 
						{
							// Set values result
							$strValue = $objSqlQuery->getDataFromColIndex($cpt, $cpt2);
							$Result[$strKey][] = $strValue;
						}
					}
				}
			}
		}
		
		// return result
		return $Result;
	}
	
	
	
}
