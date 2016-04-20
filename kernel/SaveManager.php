<?php
/**
 * Short description :
 * The class which permits to stock allsave value and stock during process or more. of session management part of the framework.
 * 
 * Long description :
 * This class represent the class which handle of save management. It's class inherits the singleton.
 * The class permits manage all save for the web project. it's possible to save in memory, in session and in cookie.
 * The transmission and serialization for transit is managed.
 * The main featuring is :
 * -> Setting / Getting save. If the option "put in session" or "put in cookie" is selected, the save is transmitted in the next page.
 * -> Check existance of the save.
 * -> Serialization / Unserialization for transit.
 * The save is composed to :
 * -> Key : Name used to call a save.
 * -> Value : Value of a save. Every thing.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

namespace Framework\Kernel;

final class SaveManager extends \Framework\Library\Singleton
{
	// ******************************************************************************
	// Properties
	// ******************************************************************************
	
	/**
	 * Associate table used to stock in memory, all of the save.
	 * Structure : Key : Id => Value : anything.
     * @var array
     */
	private $tabSave;
	
	
	
	/**
	 * Associate table used to stock in memory, all of the session.
	 * Structure : Key : Key in the table save => Value : Key in the table save.
     * @var array
     */
	private $tabSession;
	
	
	
	/**
	 * Index table used to stock in memory, all of the cookie (value = key in the table save).
	 * Structure : Key : Key in the table save => Value : Array(Expire, Path) Key in the table save.
     * @var array
     */
	private $tabCookie;
	
	
	
	
	
	// ******************************************************************************
	// Methods
	// ******************************************************************************
	
	// Constructor / Destructor
	// ******************************************************************************
	protected function __construct() 
	{
		parent::__construct();
		
		$this->tabSave = array();
		$this->tabSession = array();
		$this->tabCookie = array();
	}
	
	
	
	
	
	// Methods check
	// ******************************************************************************
	
	/**
	 * Check a specified save exists or no from a specified key.
	 * 
	 * @param $strKey
	 * @return boolean
     */
	public function checkExists($strKey)
    {
		return (array_key_exists($strKey, $this->tabSave));
    }
	
	
	
	/**
	 * Check a specified save is a session or no from a specified key.
	 * 
	 * @param $strKey
	 * @return boolean
     */
	public function checkIsSession($strKey)
    {
		return (array_key_exists($strKey, $this->tabSession));
    }
	
	
	
	/**
	 * Check a specified save is a cookie or no from a specified key.
	 * 
	 * @param $strKey
	 * @return boolean
     */
	public function checkIsCookie($strKey)
    {
		return (array_key_exists($strKey, $this->tabCookie));
    }
	
	
	
	
	
	// Methods setters
	// ******************************************************************************
	
	/**
	 * Set a specified save with a key and a value attached.
	 * Return true if it's setting well.
	 * 
	 * @param $strKey, $objVal, $boolPutInSession = false, $boolPutInCookie = false, $intTimeCookie = 0, $strPathCookie = '/'
	 * @return boolean
     */
	public function set($strKey, $objVal, $boolPutInSession = false, $boolPutInCookie = false, $intTimeCookie = 0, $strPathCookie = '/')
    {
		// Init var
		$Result = false;
		
		// Set save
		$this->tabSave[$strKey] = $objVal;
		$Result = true;
		
		// Set session
		if($boolPutInSession)
		{
			$this->tabSession[$strKey] = $strKey;
		}
		
		// Set cookie
		if($boolPutInCookie)
		{
			$intTimeCookieTot = (time() + $intTimeCookie);
			$this->tabCookie[$strKey] = array($intTimeCookieTot, $strPathCookie);
			setcookie($strKey, json_encode($objVal), $intTimeCookieTot, $strPathCookie); //serialize
		}
		
		// Return result
		return $Result;
    }
	
	
	
	/**
	 * Remove a save with a specified key.
	 * Return true if it's setting well.
	 * 
	 * @param $strKey
	 * @return boolean
     */
	public function remove($strKey)
    {
		// Init var
		$Result = false;
		
		// Check key exists
		if($this->checkExists($strKey))
		{
			// Remove save
			unset($this->tabSave[$strKey]);
			$Result = true;
			
			// Remove session if exists
			if(array_key_exists($strKey, $this->tabSession))
			{
				unset($this->tabSession[$strKey]);
			}
			
			// Remove cookie if exists
			if(array_key_exists($strKey, $this->tabCookie))
			{
				// Remove cookie in engine
				if(isset($_COOKIE[$strKey]))
				{
					setcookie($strKey, '', (time() - 3600), $this->tabCookie[$strKey][1]);
					unset($_COOKIE[$strKey]);
				}
				
				// Remove cookie in table
				unset($this->tabCookie[$strKey]);
			}
			
		}
		
		// Return result
		return $Result;
    }
	
	
	
	
	
	// Methods getters
	// ******************************************************************************
	
	/**
	 * Get a save from a specified key.
	 * 
	 * @param $strKey
	 * @return object if success, null else
     */
	public function get($strKey)
    {
		// Init var
		$Result = null;
		
		// Check exist
		if($this->checkExists($strKey))
		{
			// Get save
			$Result = $this->tabSave[$strKey];
		}
		
		// Return
		return $Result;
    }
	
	
	
	/**
	 * Get an index table of all save keys.
	 * 
	 * @return array
     */
	public function getTabKey()
    {
		// Init var
		$Result = array();
		
		// Run all saves
		foreach($this->tabSave as $key => $value)
		{
			$Result[] = $key;
		}
		
		// Return
		return $Result;
    }
	
	
	
	
	
	// Methods initialize
	// ******************************************************************************
	
	/**
	 * Set session from memory for save information.
	 * Save session in php engine.
	 * It uses the serialization.
     */
	public function setInitToEngine()
    {
		// Prepare session table save
		$tabSesSave = array();
		
		foreach($this->tabSave as $key => $value)
		{
			if(array_key_exists($key, $this->tabSession))
			{
				$tabSesSave[$key] = $value;
			}
		}
		
		// Set data in session
		$_SESSION[PARAM_KERNEL_SAVE_TAG_TAB] = serialize($tabSesSave);
		$_SESSION[PARAM_KERNEL_SAVE_TAG_COOK_TAB] = serialize($this->tabCookie);
		setcookie(PARAM_KERNEL_SAVE_TAG_COOK_TAB, serialize($this->tabCookie), (time() + PARAM_KERNEL_SAVE_TIMER_COOK_TAB));
    }
	
	
	
	/**
	 * Load session to memory to get information.
	 * Get session from php engine.
	 * It uses the unserialization.
     */
	public function setInitToMemory()
    {
		if(isset($_SESSION[PARAM_KERNEL_SAVE_TAG_TAB]))
		{
			// Set save table
			$this->tabSave = unserialize($_SESSION[PARAM_KERNEL_SAVE_TAG_TAB]);
			
			// Set session table
			$this->tabSession = array();
			foreach($this->tabSave as $key => $value)
			{
				$this->tabSession[$key] = $key;
			}
		}
		
		// Set cookie table
		if(isset($_SESSION[PARAM_KERNEL_SAVE_TAG_COOK_TAB]))
		{
			$this->tabCookie = unserialize($_SESSION[PARAM_KERNEL_SAVE_TAG_COOK_TAB]);
		}
		else if(isset($_COOKIE[PARAM_KERNEL_SAVE_TAG_COOK_TAB]))
		{
			$this->tabCookie = unserialize($_COOKIE[PARAM_KERNEL_SAVE_TAG_COOK_TAB]);
		}
		
		// Add values in cookie in save table
		foreach($this->tabCookie as $key => $value)
		{
			if(isset($_COOKIE[$key]))
			{
				if(!array_key_exists($key, $this->tabSave))
				{
					$this->tabSave[$key] = json_decode($_COOKIE[$key]); // Unserialize
				}
			}
			else
			{
				// Remove cookie in table if cookie not exists
				unset($this->tabCookie[$key]);
			}
		}
    }
	
	
	
}