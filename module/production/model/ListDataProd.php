<?php

class ListDataProd extends ListData
{
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	
	public function __construct() 
	{
		$strSqlModel = 
		'SELECT cat.*, prd.* 
		FROM 
		(
			(
				(
					(
						products prd INNER JOIN categories cat ON (prd.prd_cat_id = cat.cat_id)
					) INNER JOIN prices pri ON (prd.prd_id = pri.pri_prd_id)
				) INNER JOIN countries cnt ON (pri.pri_cnt_id = cnt.cnt_id)
			) INNER JOIN currencies cur ON (cnt.cnt_cur_id = cur.cur_id)
		)
		INNER JOIN stocks stk ON (prd.prd_id = stk.stk_prd_id) 
		'.CONF_TAG_LIST_SQL_CRITERIA.' 
		GROUP BY prd.prd_id 
		ORDER BY cat.cat_id ASC, prd.prd_id ASC 
		'.CONF_TAG_LIST_SQL_LIMIT.'';
		
		$intPageNbRow = CONF_LIST_PAGE_COUNT_ROW_PROD;
		
		$tabCritOperation = array();
		$tabCritOperation['cur_id'] = "(cur.cur_id = ".CONF_TAG_LIST_SQL_OPE_VALUE.")";
		
		parent::__construct($strSqlModel, $tabCritOperation, $intPageNbRow);
	}
	
	
	
	
	
	// Methods run
	// ******************************************************************************
	
	/**
	 * Set default data in memory.
     */
    public function run()
    {
		// Set criteria
		foreach($this->tabCritOperation as $key => $value) 
		{
			// Get arg
			$strArg = '';
			if(isset($_POST[$key]))
			{
				$strArg = $_POST[$key];
			}
			else if(isset($_GET[$key]))
			{
				$strArg = $_GET[$key];
			}
			
			// Process arg
			if(trim($strArg) != '')
			{
				$this->setCritValue($key, $strArg);
			}
		}
		
		
		
		// Set active page
		$strArg = '1';
		if(isset($_POST['page_active']))
		{
			$strArg = $_POST['page_active'];
		}
		else if(isset($_GET['page_active']))
		{
			$strArg = $_GET['page_active'];
		}
		
		if((trim($strArg) != '') && (ctype_digit($strArg)))
		{
			$this->setPageActive(intval($strArg));
		}
		
		
		
    }
	
	
	
}
