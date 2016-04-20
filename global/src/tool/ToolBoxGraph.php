<?php

use \Framework\Kernel\Extend\Model;

class ToolBoxGraph extends Model
{
	// Form data functions
	// ***************************************************************************************************
	
	/**
	 * Get the string value from arguments from a specified key.
	 * 
	 * @param $strKey, $strValueDefault = ''
	 * @return string
     */
	static public function getArg($strKey, $strValueDefault = '')
	{
		$Result = $strValueDefault;
		
		if(isset($_POST[$strKey]))
		{
			$Result = $_POST[$strKey];
		}
		else if(isset($_GET[$strKey]))
		{
			$Result = $_GET[$strKey];
		}
		/*
		else if(isset($_SESSION[$strKey]))
		{
			$Result = $_SESSION[$strKey];
		}
		*/
		
		return $Result;
	}
	
	
	
	
	
	// ListBox functions
	// ***************************************************************************************************
	
	/**
	 * Get the string litsbox from a specified associate or index table.
	 * 
	 * @param $tabValue, $boolIsAssociateTable = true, $strNmListBox = '', $strIdListBox = '', $strClassListBox = '', $strSelected = '', $strScriptOnChange = ''
	 * @return string
     */
	static public function getListBoxTab($tabValue, $boolIsAssociateTable = true, $strNmListBox = '', $strIdListBox = '', $strClassListBox = '', $strSelected = '', $strScriptOnChange = '')
	{
		$Result = '';
		
		if(is_array($tabValue))
		{
			$strNm = '';
			if(trim($strNmListBox) != '')
			{
				$strNm = 'Name="'.$strNmListBox.'"';
			}
			
			$strId = '';
			if(trim($strIdListBox) != '')
			{
				$strId = 'Id="'.$strIdListBox.'"';
			}
			
			$strClass = '';
			if(trim($strClassListBox) != '')
			{
				$strClass = 'Class="'.$strClassListBox.'"';
			}
			
			$strScriptChange = '';
			if(trim($strScriptOnChange) != '')
			{
				$strScriptChange = 'onChange="'.$strScriptOnChange.'"';
			}
			
			$Result = '<select '.$strNm.' '.$strId.' '.$strClass.' '.$strScriptChange.'>';
			
			if($boolIsAssociateTable) // Case of associate table
			{
				foreach($tabValue as $key => $value) 
				{
					$strKeyEscape = str_replace('"', '\\"', $key);
					
					if(($key == $strSelected) && ($strSelected != ''))
					{
						$Result = $Result.'<option value="'.$strKeyEscape.'" selected="selected" >'.$value.'</option>';
					}
					else
					{
						$Result = $Result.'<option value="'.$strKeyEscape.'" >'.$value.'</option>';
					}
				}
			}
			else // Case of index table
			{
				for($cpt=0; $cpt<count($tabValue); $cpt++) 
				{
					$strValue = $tabValue[$cpt];
					$strValueEscape = str_replace('"', '\\"', $strValue);
					
					if(($strValue == $strSelected) && ($strSelected != ''))
					{
						$Result = $Result.'<option value="'.$strValueEscape.'" selected="selected" >'.$strValue.'</option>';
					}
					else
					{
						$Result = $Result.'<option value="'.$strValueEscape.'" >'.$strValue.'</option>';
					}
				}
			}
			
			$Result = $Result.'</select>';
		}
		
		return $Result;
	}
	
	
	
}


