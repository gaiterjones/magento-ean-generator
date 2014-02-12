<?php
/**
 *  
 *  Copyright (C) 2014
 *
 *
 *  @who	   	PAJ
 *  @info   	paj@gaiterjones.com
 *  @license    blog.gaiterjones.com
 * 	
 *
 */
 /**
 * Main MAGENTO class
 * -- Connects to MAGENTO
 * @access public
 * @return nix
 */
class Application_Magento_Connect
{

	protected $__config;
	protected $__;
	
	public function __construct() {
		
			$this->loadConfig();
			$this->loadMagento();

	}
	
	
	// -- get app config
	private function loadConfig()
	{
		$this->__config= new config();
	}


	// -- connect to Magento
	private function loadMagento()
	{
		require_once $this->__config->get('pathToMagentoApp');
		umask(0);
		Mage::app();
		
		// - this crashes some installs ?
		//Mage::app()->loadArea(Mage_Core_Model_App_Area::AREA_FRONTEND);

	}
	
	
	public function set($key,$value)
	{
		$this->__[$key] = $value;
	}

	public function get($variable)
	{
		return $this->__[$variable];
	}

}  
?>