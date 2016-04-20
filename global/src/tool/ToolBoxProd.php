<?php

use \Framework\Kernel\Extend\Model;

class ToolBoxProd extends Model
{
	/**
	 * Get the associative table of currencies.
	 * 
	 * @return array
     */
    public function getTabCurrencies()
	{
		$objDb = $this->getService(CONF_TAG_SVC_DB);
		$Result = array();
		
		// Get sum stock
		if($objDb->checkIsConnect())
		{
			// Build SQL
			$strSql = 
			"SELECT * 
			FROM currencies 
			ORDER BY cur_code ASC";
			
			if($objSqlQuery = $objDb->sqlExecuteQuery($strSql))
			{
				if(($objSqlQuery->getCountRow() > 0) && ($objSqlQuery->getCountCol() > 0))
				{
					// Run rows
					for($cpt = 0; $cpt < $objSqlQuery->getCountRow(); $cpt++) 
					{
						$strKey = $objSqlQuery->getDataFromColNm('cur_id', $cpt);
						$strValue = $objSqlQuery->getDataFromColNm('cur_code', $cpt);
						//echo('|'.$strKey.'|'.$strValue.'|<br />');
						
						$Result[$strKey] = $strValue;
					}
				}
			}
		}
		
		// Return result
		return $Result;
	}
	
	
	
	/**
	 * Get the table with full info of prod.
	 * 
	 * @param $tabInfo
	 * @return array
     */
    public function getTabInfoFull($tabInfo)
	{
		// Init var
		$objDb = $this->getService(CONF_TAG_SVC_DB);
		$Result = array();
		$tabNbMsgShw = array();
		$tabNbFl = array();
		$strListPrdId = '';
		
		$boolTabInfo = false;
		if(isset($tabInfo['prd_id']))
		{
			$boolTabInfo = (Count($tabInfo['prd_id']) > 0);
		}
		
		// Check if table of info is not empty
		if($boolTabInfo)
		{
			// Set table info
			for($cpt = 0; $cpt < count($tabInfo['prd_id']); $cpt++)
			{
				$strPrdId = $tabInfo['prd_id'][$cpt];
				
				// Set new prd
				if(!array_key_exists($strPrdId, $Result))
				{
					// Init data
					$Result[$strPrdId] = array();
					
					// Set data
					foreach($tabInfo as $key => $value)
					{
						$Result[$strPrdId][$key] = $tabInfo[$key][$cpt];
					}
					
					// Init new data
					$Result[$strPrdId]['stk_id'] = 0;
					$Result[$strPrdId]['pri_id'] = array();
					
					// Build List
					if(trim($strListPrdId) != '')
					{
						$strListPrdId = $strListPrdId.', ';
					}
					$strListPrdId = $strListPrdId.$objDb->getEscapeVal($strPrdId);
				}
			}
			
			// Get sum stock
			if($objDb->checkIsConnect() && (trim($strListPrdId) != ''))
			{
				// Build SQL
				$strSql = 
				"SELECT stk_prd_id, Sum(stk_quantity) AS stk_quantity_sum
				FROM stocks 
				WHERE 
				(stk_prd_id IN (".$strListPrdId.")) 
				GROUP BY stk_prd_id;";
				
				if($objSqlQuery = $objDb->sqlExecuteQuery($strSql))
				{
					if(($objSqlQuery->getCountRow() > 0) && ($objSqlQuery->getCountCol() > 0))
					{
						// Run rows
						for($cpt = 0; $cpt < $objSqlQuery->getCountRow(); $cpt++) 
						{
							$strPrdId = $objSqlQuery->getDataFromColNm('stk_prd_id', $cpt);
							
							// Complete disc with user info
							if(array_key_exists($strPrdId, $Result)) 
							{
								$Result[$strPrdId]['stk_id'] = $objSqlQuery->getDataFromColNm('stk_quantity_sum', $cpt);
							}
						}
					}
				}
			}
			
			// Get price
			if($objDb->checkIsConnect() && (trim($strListPrdId) != ''))
			{
				// Build SQL
				$strSql = 
				"SELECT prd.*, pri.*, cnt.*, cur.* 
				FROM 
				(
					(
						products prd INNER JOIN prices pri ON (prd.prd_id = pri.pri_prd_id)
					) INNER JOIN countries cnt ON (pri.pri_cnt_id = cnt.cnt_id)
				) INNER JOIN currencies cur ON (cnt.cnt_cur_id = cur.cur_id) 
				WHERE (prd_id IN (".$strListPrdId."));";
				//echo('|'.$strSql.'|');
				
				if($objSqlQuery = $objDb->sqlExecuteQuery($strSql))
				{
					if(($objSqlQuery->getCountRow() > 0) && ($objSqlQuery->getCountCol() > 0))
					{
						// Run rows
						for($cpt = 0; $cpt < $objSqlQuery->getCountRow(); $cpt++) 
						{
							$strPrdId = $objSqlQuery->getDataFromColNm('prd_id', $cpt);
							
							// Complete disc with user info
							if(array_key_exists($strPrdId, $Result)) 
							{
								$tabValue = array();
								
								// Run rows
								for($cpt2 = 0; $cpt2 < $objSqlQuery->getCountCol(); $cpt2++) 
								{
									$strKey = $objSqlQuery->getColNm($cpt2);
									$strValue = $objSqlQuery->getDataFromColIndex($cpt2, $cpt);
									$tabValue[$strKey] = $strValue;
								}
								
								$Result[$strPrdId]['pri_id'][] = $tabValue;
							}
						}
					}
				}
			}
		}
		
		// Return result
		return $Result;
	}
	
	
	
}


