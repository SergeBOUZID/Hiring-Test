<?php
/**
 * Short description :
 * The class which handle of display view part of the framework.
 * 
 * Long description :
 * This class represent the class which handle of the template view engine. It's class inherits the singleton.
 * The class permit to obtain template php, and pass arguments it, for display the view.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class ViewEngine extends \Framework\Library\Singleton
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Table of blocks : array[block id] = block content.
     * @var array()
     */
	private $tabBlock;
	
	
	
	/**
	 * Table of Arguments : array[argument id] = argument content.
     * @var array()
     */
	private $tabArg;
	
	
	
	/**
	 * URL to redirect.
     * @var string()
     */
	private $strRedirectUrl;
	
	
	
	/**
	 * Table of Arguments for redirection with method get : array[argument id] = argument content.
     * @var array()
     */
	private $tabArgGet;
	
	
	
	/**
	 * Render to print.
     * @var string()
     */
	private $strRender;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	protected function __construct() 
	{
		parent::__construct();
		
		$this->tabBlock = array();
		$this->tabArg = array();
		
		$this->strRedirectUrl = '';
		$this->tabArgGet = array();
		
		$this->strRender = '';
	}
	
	
	
	
	
	//Methods render
	//******************************************************************************
	
	/**
	 * Get the string render with block replacement from a specified table of blocks.
	 * 
	 * @param $strRender, $tabBlock
	 * @return string
     */
	private function renderGetBlockReplace($strRender, $tabBlock)
    {
		// Init var
		$Result = $strRender;
		
		$strDelimiter = '#';// Used to born pattern in function preg_replace
		
		$objToolboxRand = $this->getToolboxRand();
		$strRandValue1 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		$strRandValue2 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		$strRandValue3 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		
		// Replace \n and \r
		$Result = str_replace ("\r\n", $strRandValue1, $Result);
		$Result = str_replace ("\n", $strRandValue2, $Result);
		$Result = str_replace ("\r", $strRandValue3, $Result);
		
		// Run
		foreach($tabBlock as $key => $value)
		{
			$strBlockStart = PARAM_KERNEL_VIEW_ENG_BLOCK_START_START.$key.PARAM_KERNEL_VIEW_ENG_BLOCK_START_END;
			$strBlockEnd = PARAM_KERNEL_VIEW_ENG_BLOCK_END_START.$key.PARAM_KERNEL_VIEW_ENG_BLOCK_END_END;
			
			if((strpos($Result, $strBlockStart) !== false) && (strpos($Result, $strBlockEnd) !== false))
			{
				// Replace in string
				$strPattern = preg_quote($strBlockStart).".*".preg_quote($strBlockEnd);
				$Result = preg_replace($strDelimiter.$strPattern.$strDelimiter, $value, $Result);
				
			}
		}
		
		// Re put \n and \r
		$Result = str_replace ($strRandValue1, "\r\n", $Result);
		$Result = str_replace ($strRandValue2, "\n", $Result);
		$Result = str_replace ($strRandValue3, "\r", $Result);
		
		return $Result;
    }
	
	
	
	/**
	 * Get the string render without special expression : extend, blocks ... from a specified template.
	 * 
	 * @param $strRender
	 * @return string
     */
	private function renderGetClean($strRender)
    {
		// Init var
		$Result = $strRender;
		
		$strDelimiter = '#';// Used to born pattern in function preg_replace
		
		$objToolboxRand = $this->getToolboxRand();
		$strRandValue1 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		$strRandValue2 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		$strRandValue3 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		
		// Replace \n and \r
		$Result = str_replace ("\r\n", $strRandValue1, $Result);
		$Result = str_replace ("\n", $strRandValue2, $Result);
		$Result = str_replace ("\r", $strRandValue3, $Result);
		
		//Replace pattern expressions
		$tabPattern = array
		(
			'[^'.preg_quote(PARAM_KERNEL_VIEW_ENG_ESCAPE).']'.preg_quote(PARAM_KERNEL_VIEW_ENG_EXTEND_START).".*".preg_quote(PARAM_KERNEL_VIEW_ENG_EXTEND_END), 
			'[^'.preg_quote(PARAM_KERNEL_VIEW_ENG_ESCAPE).']'.preg_quote(PARAM_KERNEL_VIEW_ENG_BLOCK_START_START).".*".preg_quote(PARAM_KERNEL_VIEW_ENG_BLOCK_START_END), 
			'[^'.preg_quote(PARAM_KERNEL_VIEW_ENG_ESCAPE).']'.preg_quote(PARAM_KERNEL_VIEW_ENG_BLOCK_END_START).".*".preg_quote(PARAM_KERNEL_VIEW_ENG_BLOCK_END_END),
			'[^'.preg_quote(PARAM_KERNEL_VIEW_ENG_ESCAPE).']'.preg_quote(PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_START).".*".preg_quote(PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_END), 
			'[^'.preg_quote(PARAM_KERNEL_VIEW_ENG_ESCAPE).']'.preg_quote(PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_START).".*".preg_quote(PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_END)
		);
		
		for($cpt = 0; $cpt < count($tabPattern); $cpt++)
		{
			$Result = preg_replace($strDelimiter.$tabPattern[$cpt].$strDelimiter, '', $Result);
		}
		
		// Re put \n and \r
		$Result = str_replace ($strRandValue1, "\r\n", $Result);
		$Result = str_replace ($strRandValue2, "\n", $Result);
		$Result = str_replace ($strRandValue3, "\r", $Result);
		
		//Return result
		return $Result;
    }
	
	
	
	/**
	 * Get the text render.
	 * The $strPathFl constitutes the absolute path of the template (php or html).
	 * The $tabArg constitutes the associate table of argument to pass to the template.
	 * The $tabBlock constitutes the associate table of blocks and contents (array[id of block] = text in block) to pass to the template.
	 * 
	 * @param $strPathFl, $tabArg = array(), $tabBlock = array()
	 * @return string
     */
	public function renderGetStr($strPathFl, $tabArg = array(), $tabBlock = array())
    {
		// Init var
		$Result = '';
		$this->tabBlock = array();
		$this->tabArg = array();
		
		
		// Check file
		if(file_exists($strPathFl))
		{
			// Put Args
			if(count($tabArg) > 0)
			{
				foreach($tabArg as $key => $value)
				{
					${$key} = $value;
				}
			}
			
			// Put Args in memory
			$this->tabArg = $tabArg;
			
			// Put blocks
			if(count($tabBlock) > 0)
			{
				$this->blockAddTab($tabBlock);
			}
			
			// If it's an extend, call the parent template
			$boolWrap = true;
			while($boolWrap)
			{
				$boolWrap = false;
				
				// Get view
				ob_start(); // Redirect out to memory
				require_once($strPathFl);
				$strRender = ob_get_clean(); // Get view from memory and stop redirection
				
				// Set table block
				$this->blockAddTab($this->blockGetTab($strRender));
				
				// If it's an extend, call the parent template
				$strElmExtendPath = $this->extendGetPath($strRender);
				
				if($strElmExtendPath !== false)
				{
					$strPathFl = $this->getStrPathProject($strElmExtendPath, false);
					$boolWrap = file_exists($strPathFl);
				}
				
				// If end of process
				if(!$boolWrap)
				{
					// Treatment table of blocks
					$tabBlock = $this->blockGetTabReplace($this->tabBlock);
					$Result = $this->renderGetBlockReplace($strRender, $tabBlock);
					
					// Remove all special expressions : extend, block, ...
					$Result = $this->renderGetClean($Result);
					
					// Remove escape value
					$Result = $this->getNotEscapeValue($Result);
				}
			}
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Set the text render.
	 * The $strPathFl constitutes the absolute path of the template (php or html).
	 * The $tabArg constitutes the associate table of argument to pass to the template.
	 * The feature is based upon the function renderGetStr.
	 * 
	 * @see renderGetStr()
	 * @param $strPathFl, $tabArg, $tabBlock = array()
     */
	public function renderSet($strPathFile, $tabArg = array(), $tabBlock = array())
    {
		$this->strRender = $this->renderGetStr($strPathFile, $tabArg, $tabBlock);
    }
	
	
	
	/**
	 * Set the text render from a specified text.
	 * 
	 * @param $strRender
     */
	public function renderSetStr($strRender)
    {
		$this->strRender = $strRender;
    }
	
	
	
	/**
     * Load component in a render, from a specified file.
	 * 
	 * @param $strPathFl
     */
	public function renderSetInclude($strPathFl)
	{
		// Put Args from memory
		if(count($this->tabArg) > 0)
		{
			foreach($this->tabArg as $key => $value)
			{
				${$key} = $value;
			}
		}
		
		// Load file
		require_once($strPathFl);
	}
	
	
	
	
	
	// Methods redirect
	// ******************************************************************************
	
	/**
	 * Set a redirection from a specified URL.
	 * This URL is stocked and executed after all kernel process.
	 * 
	 * @param $strUrl, $tabArgGet = null
     */
	public function redirect($strUrl, $tabArgGet = null)
    {
		if(trim($strUrl) != '')
		{
			// Save in memory : URL
			$this->strRedirectUrl = $strUrl;
			
			// Save in memory if need : table arguments get
			if((!is_null($tabArgGet)) && (is_array($tabArgGet)))
			{
				$this->tabArgGet = $tabArgGet;
			}
			else
			{
				$this->tabArgGet = array();
			}
		}
    }
	
	
	
	
	
	// Methods hide value
	// ******************************************************************************
	
	/**
	 * Get the hidden value from a specified key, in a specified file.
	 * The $strPathFl constitutes the absolute path of the template (php or html).
	 * It return false if limits not found, the string between limits else.
	 * 
	 * @param $strKey, $strPathFl
	 * @return string
     */
	public function hideValueGetStr($strKey, $strPathFl)
    {
		// Init var
		$Result = false;
		$objToolboxString = $this->getToolboxString();
		
		if(file_exists($strPathFl))
		{
			// Get the content of the file
			$strFl = file_get_contents($strPathFl); 
			
			// Check if the content is OK
			if($strFl !== false)
			{
				// Put the limits
				$strHiddenStart = PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_START.$strKey.PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_END;
				$strHiddenEnd = PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_START.$strKey.PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_END;
				
				// Get string between start and end of the hidden value
				$strHidden = $objToolboxString::getStrBetween
				(
					$strFl, 
					$strHiddenStart, 
					$strHiddenEnd
				);
				
				// Check result
				if($strHidden !== false)
				{
					$Result = $strHidden;
				}
			}
		}
		
		//Return result
		return $Result;
    }
	
	
	
	
	
	// Methods run
	// ******************************************************************************
	
	/**
	 * Run the view engine after all kernel process.
	 * At first, set the redirection from the URL stocked in memory if it is.
	 * At second, set the render from the string render stocked in memory if it is.
	 * 
     */
	public function run()
    {
		if(trim($this->strRedirectUrl) != '')
		{
			// Get get arguments
			$strGetArgs = '';
			if(count($this->tabArgGet) > 0)
			{
				foreach($this->tabArgGet as $key => $value)
				{
					if(trim($strGetArgs) != '')
					{
						$strGetArgs = $strGetArgs.'&';
					}
					
					$strGetArgs = $strGetArgs.urlencode($key).'='.urlencode($value);
				}
				
				if(trim($strGetArgs) != '')
				{
					$strGetArgs = '?'.$strGetArgs;
				}
			}
			
			// Redirection
			header('Location: '.$this->strRedirectUrl.$strGetArgs);
		}
		else if(trim($this->strRender) != '')
		{
			// Set render
			echo($this->strRender);
		}
    }
	
	
	
	
	
	// Methods extend path
	// ******************************************************************************
	
	/**
	 * Get the extend path of the parent template from a specified template.
	 * The $strRender represents the specified template in string.
	 * Return the string relative path of the parent template if it finds it, false else.
	 * 
	 * @param $strRender
	 * @return string if success, false else
     */
	private function extendGetPath($strRender)
    {
		// Init var
		$Result = false;
		$tabStr = explode("\n", $strRender);
		
		if(count($tabStr) > 0)
		{
			// Get first line
			$strExtend = $tabStr[0];
			
			// Check extend start
			if(substr($strExtend, 0, strlen(PARAM_KERNEL_VIEW_ENG_EXTEND_START)) == PARAM_KERNEL_VIEW_ENG_EXTEND_START)
			{
				// Get extend string
				$strExtend = trim(substr($strExtend, strlen(PARAM_KERNEL_VIEW_ENG_EXTEND_START)));
				
				// Check extend end
				if(substr($strExtend, (strlen($strExtend) - strlen(PARAM_KERNEL_VIEW_ENG_EXTEND_END))) == PARAM_KERNEL_VIEW_ENG_EXTEND_END)
				{
					// Get extend string
					$strExtend = trim(substr($strExtend, 0, (strlen($strExtend) - strlen(PARAM_KERNEL_VIEW_ENG_EXTEND_END))));
					$Result = $strExtend;
				}
			}
		}
		
		return $Result;
    }
	
	
	
	
	
	// Methods table of blocks
	// ******************************************************************************
	
	/**
	 * Add a specified table of blocks in the table in properties.
	 * 
	 * @param &$tabBlock
     */
	private function blockAddTab($tabBlock)
    {
		// Initialize table blocks if need
		if(is_null($this->tabBlock) || (!is_array($this->tabBlock)))
		{
			$this->tabBlock = array();
		}
		
		// Run all items
		foreach($tabBlock as $key => $value)
		{
			// Check key not already exists
			if(!array_key_exists($key, $this->tabBlock))
			{
				// Save in table in memory
				$this->tabBlock[$key] = $value;
			}
		}
    }
	
	
	
	/**
	 * Get the associate table of blocks from a specified template.
	 * The $strRender represents the template in string.
	 * Return an array[id of block] = text in block.
	 * 
	 * @param $strRender
	 * @return array
     */
	private function blockGetTab($strRender)
    {
		// Init var
		$Result = array();
		$boolWrap = true;
		$cpt = 0;
		$objToolboxString = $this->getToolboxString();
		
		// Run
		while($boolWrap)
		{
			// Get bloc id
			$strBlockId = $objToolboxString::getStrBetween
			(
				$strRender, 
				PARAM_KERNEL_VIEW_ENG_BLOCK_START_START, 
				PARAM_KERNEL_VIEW_ENG_BLOCK_START_END, 
				$cpt
			);
			
			// Check block id
			$boolWrap = ($strBlockId !== false);
			
			if($boolWrap)
			{
				// Check block id
				$boolGo = (trim($strBlockId) != '');
				$strBlockIdStart = PARAM_KERNEL_VIEW_ENG_BLOCK_START_START.$strBlockId.PARAM_KERNEL_VIEW_ENG_BLOCK_START_END;
				$intStart = strpos($strRender, $strBlockIdStart);
				
				// Check start block does not be escaped
				$boolGo = false;
				if($intStart !==false)
				{
					$boolGo = (substr($strRender, ($intStart-strlen(PARAM_KERNEL_VIEW_ENG_ESCAPE)), strlen(PARAM_KERNEL_VIEW_ENG_ESCAPE)) != PARAM_KERNEL_VIEW_ENG_ESCAPE);
					//echo('|'.$strBlockIdStart.':'.substr($strRender, ($intStart-strlen(PARAM_KERNEL_VIEW_ENG_ESCAPE)), strlen(PARAM_KERNEL_VIEW_ENG_ESCAPE)).'|'.PARAM_KERNEL_VIEW_ENG_ESCAPE.'|'.$boolGo.'|<br />');
				}
				
				if($boolGo)
				{
					$boolGo = false;
					$strBlockIdEnd = PARAM_KERNEL_VIEW_ENG_BLOCK_END_START.$strBlockId.PARAM_KERNEL_VIEW_ENG_BLOCK_END_END;
					
					// Check end block exists
					$intEnd = strpos($strRender, $strBlockIdEnd);
					if($intEnd !== false)
					{
						// Check end block does not be escaped
						$boolGo = (substr($strRender, ($intEnd-strlen(PARAM_KERNEL_VIEW_ENG_ESCAPE)), strlen(PARAM_KERNEL_VIEW_ENG_ESCAPE)) != PARAM_KERNEL_VIEW_ENG_ESCAPE);
						
						if($boolGo)
						{
							// Get string between start and end of the block
							$strBlockContent = $objToolboxString::getStrBetween
							(
								$strRender, 
								$strBlockIdStart, 
								$strBlockIdEnd, 
								$cpt
							);
							
							if($strBlockContent !== false)
							{
								// Put in table
								$Result[$strBlockId] = $strBlockContent;
							}
						}
					}
				}
				
				// Put count
				$cpt = ($intStart + strlen($strBlockIdStart));
			}
		}
		
		return $Result;
    }
	
	
	
	/**
	 * Get the associate table of blocks, with all under blocks replaced from a specified table of blocks.
	 * 
	 * @param $tabBlock
	 * @return array
     */
	private function blockGetTabReplace($tabBlock)
    {
		// Init var
		$Result = array();
		
		$strDelimiter = '#';// Used to born pattern in function preg_replace
		
		$objToolboxRand = $this->getToolboxRand();
		$strRandValue1 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		$strRandValue2 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		$strRandValue3 = preg_quote($objToolboxRand::getRandValue(10,48 , 122));
		
		// Run
		foreach($tabBlock as $key => $value)
		{
			// Replace \n and \r
			$value = str_replace("\r\n", $strRandValue1, $value);
			$value = str_replace("\n", $strRandValue2, $value);
			$value = str_replace("\r", $strRandValue3, $value);
			
			$boolWrap = true;
			while($boolWrap)
			{
				$boolWrap = false;
				foreach($tabBlock as $key2 => $value2)
				{
					$strBlockStart = PARAM_KERNEL_VIEW_ENG_BLOCK_START_START.$key2.PARAM_KERNEL_VIEW_ENG_BLOCK_START_END;
					$strBlockEnd = PARAM_KERNEL_VIEW_ENG_BLOCK_END_START.$key2.PARAM_KERNEL_VIEW_ENG_BLOCK_END_END;
					
					if((strpos($value, $strBlockStart) !== false) && (strpos($value, $strBlockEnd) !== false))
					{
						// Replace in string
						$strPattern = preg_quote($strBlockStart).".*".preg_quote($strBlockEnd);
						$value = preg_replace($strDelimiter.$strPattern.$strDelimiter, $value2, $value);
						
						// Save in tabBlock for next replace if need
						$valueSave = $value;
						$valueSave = str_replace($strRandValue1, "\r\n", $valueSave);
						$valueSave = str_replace($strRandValue2, "\n", $valueSave);
						$valueSave = str_replace($strRandValue3, "\r", $valueSave);
						$tabBlock[$key] = $valueSave;
						
						// Check roll wrap
						$boolWrap = 
						(
							$boolWrap || 
							(
								(strpos($value, PARAM_KERNEL_VIEW_ENG_BLOCK_START_START) !== false) && 
								(strpos($value, PARAM_KERNEL_VIEW_ENG_BLOCK_END_START) !== false)
							)
						);
					}
				}
			}
			
			// Re put \n and \r
			$value = str_replace($strRandValue1, "\r\n", $value);
			$value = str_replace($strRandValue2, "\n", $value);
			$value = str_replace($strRandValue3, "\r", $value);
			
			// Set value in result
			$Result[$key] = $value;
		}
		
		return $Result;
    }
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get the value with not escaped all special expression : extend, blocks ... from a specified value.
	 * 
	 * @param $strValue
	 * @return string
     */
	private function getNotEscapeValue($strValue)
    {
		// Init var
		$Result = $strValue;
		
		//Replace with real expressions
		$tabSpeExpr = array
		(
			PARAM_KERNEL_VIEW_ENG_EXTEND_START,
			PARAM_KERNEL_VIEW_ENG_EXTEND_END,
			PARAM_KERNEL_VIEW_ENG_BLOCK_START_START,
			PARAM_KERNEL_VIEW_ENG_BLOCK_START_END,
			PARAM_KERNEL_VIEW_ENG_BLOCK_END_START,
			PARAM_KERNEL_VIEW_ENG_BLOCK_END_END,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_START,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_END,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_START,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_END
		);
		
		for($cpt = 0; $cpt < count($tabSpeExpr); $cpt++)
		{
			$Result = str_replace(PARAM_KERNEL_VIEW_ENG_ESCAPE.$tabSpeExpr[$cpt], $tabSpeExpr[$cpt], $Result);
		}
		
		//Return result
		return $Result;
    }
	
	
	
	/**
	 * Get the value with escaped all special expression : extend, blocks ... from a specified value.
	 * 
	 * @param $strValue
	 * @return string
     */
	public function getEscapeValue($strValue)
    {
		// Init var
		$Result = $strValue;
		
		//Replace with real expressions
		$tabSpeExpr = array
		(
			PARAM_KERNEL_VIEW_ENG_EXTEND_START,
			PARAM_KERNEL_VIEW_ENG_EXTEND_END,
			PARAM_KERNEL_VIEW_ENG_BLOCK_START_START,
			PARAM_KERNEL_VIEW_ENG_BLOCK_START_END,
			PARAM_KERNEL_VIEW_ENG_BLOCK_END_START,
			PARAM_KERNEL_VIEW_ENG_BLOCK_END_END,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_START,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_START_END,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_START,
			PARAM_KERNEL_VIEW_ENG_VALUE_HIDE_END_END
		);
		
		for($cpt = 0; $cpt < count($tabSpeExpr); $cpt++)
		{
			$Result = str_replace($tabSpeExpr[$cpt], PARAM_KERNEL_VIEW_ENG_ESCAPE.$tabSpeExpr[$cpt], $Result);
		}
		
		//Return result
		return $Result;
    }
	
	
	
}





// Old methods
// ******************************************************************************

/**
 * Get the associate table of blocks from a specified template.
 * The $strRender represents the template in string.
 * Return an array[id of block] = text in block.
 * 
 * @param $strRender
 * @return array
 */
/*
private function blockGetTab2($strRender)
{
	// Init var
	$Result = array();
	$boolWrap = true;
	$tabStr = explode("\n", $strRender);
	
	if(count($tabStr) > 0)
	{
		while($boolWrap)
		{
			// Run all rows
			$cpt = 0;
			$strBlockId = '';
			$strBlockTxt = '';
			$boolWrap = false;
			for($cpt = 0; $cpt < count($tabStr); $cpt++)
			{
				$strRow = $tabStr[$cpt];
				
				// Search block id
				if(trim($strBlockId) == '')
				{
					$strRow = trim($strRow);
					
					// Check block start start
					if(substr($strRow, 0, strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_START_START)) == PARAM_KERNEL_VIEW_ENG_BLOCK_START_START)
					{
						// Get block id
						$strRow = trim(substr($strRow, strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_START_START)));
						
						// Check block start end
						if(substr($strRow, (strlen($strRow) - strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_START_END))) == PARAM_KERNEL_VIEW_ENG_BLOCK_START_END)
						{
							// Get block id
							$strRow = trim(substr($strRow, 0, (strlen($strRow) - strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_START_END))));
							
							// Check block id not exists
							if(!array_key_exists($strRow, $Result))
							{
								$strBlockId = $strRow;
							}
						}
					}
				}
				else // If in a block
				{
					// Check to roll wrap (Check at least one block in active block)
					$boolWrap = 
					(
						$boolWrap || 
						(substr(trim($strRow), 0, strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_START_START)) == PARAM_KERNEL_VIEW_ENG_BLOCK_START_START)
					);
					
					// Check block end start
					$boolEndBlock = false;
					$strRowEndBlock = $strRow;
					if(substr(trim($strRowEndBlock), 0, strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_END_START)) == PARAM_KERNEL_VIEW_ENG_BLOCK_END_START)
					{
						// Get block id
						$strRowEndBlock = trim(substr(trim($strRowEndBlock), strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_END_START)));
						
						// Check block end end
						if(substr($strRowEndBlock, (strlen($strRowEndBlock) - strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_END_END))) == PARAM_KERNEL_VIEW_ENG_BLOCK_END_END)
						{
							// Get block id
							$strRowEndBlock = trim(substr($strRowEndBlock, 0, (strlen($strRowEndBlock) - strlen(PARAM_KERNEL_VIEW_ENG_BLOCK_END_END))));
							$boolEndBlock = (trim($strBlockId) == trim($strRowEndBlock));
						}
					}
					
					// If end of the active block
					if($boolEndBlock)
					{
						// Save and reinit var
						$Result[$strBlockId] = $strBlockTxt;
						$strBlockId = '';
						$strBlockTxt = '';
					}
					else
					{
						// Save content of the active block
						$strBlockTxt = $strBlockTxt.$strRow;
					}
				}
			}
		}
	}
	
	return $Result;
}
*/