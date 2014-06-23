<?php
/**
 *  
 *  Copyright (C) 2014
 *
 *	EAN Generation / Export for MAGE
 *
 *  @who	   	PAJ
 *  @info   	paj@gaiterjones.com
 *  @license    blog.gaiterjones.com
 *
 */

// APPLICATIO CONFIGURATION
// 
// includes	
require_once './php/Magento/Connect/Connect.php';
require_once './php/Helper/Data/Data.php';
require_once './php/Magento/Collection/Collection.php';
require_once './php/Application.php';


// Setup error handling
// error_reporting(0);


// debugging
error_reporting(E_ALL);
//set_error_handler( array( 'Error', 'captureNormal' ) );
//register_shutdown_function( array( 'Error', 'captureShutdown' ) );



// Edit configuration settings here
//
//
class config
{

	// define path to Magento app
	const pathToMagentoApp = '/home/www/dev/magento/app/Mage.php';
	
	// define ean export file path and name
	const pathToExportFile = '/home/www/dev/magento/myexport/eanexporttest.csv';
	
	// define ean code prefix - country / manufacturer
	const eanPrefix = '1234567';

	
	public function __construct()
	{

	}
	
	
    public function get($constant) {
	
	    $constant = 'self::'. $constant;
	
	    if(defined($constant)) {
	        return constant($constant);
	    }
	    else {
	        return false;
	    }

	}
}


