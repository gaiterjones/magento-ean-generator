<?php
/**
 *  
 *  Copyright (C) 2014
 *
 *	EAN Generation / Export for MAGEN
 *
 *  @who	   	PAJ
 *  @info   	paj@gaiterjones.com
 *  @license    blog.gaiterjones.com
 * 	
 *	usage - browser http://blah.com/ean.php?export
 			command line php ean.php debug
 *
 * 	VERSION 1.02 10.02.2014 
	http://www.gs1.org/barcodes/technical/idkeys/gtin
 */

/* Main application class */
class Application
{
	
	protected $__;
	protected $__config;
	
	public function __construct() {
	
		$this->loadConfig();
		$this->getProductCollection();
		$this->createDataFile();

	
	}


	private function getProductCollection()
	{
		$_storeID=0;
		
		$_obj=new Application_Magento_Collection();
		$_obj->getAllSKUs($_storeID);
		$_collection=$_obj->get('collection');
		$this->set('collection',$_collection);
		
	}

	private function createDataFile()
	{
		$_debug=false;
		$_data=array();
		
		//$_seperator="\t"; // TAB
		$_seperator=','; // COMMA
		
		$_eanPrefix=$this->get('eanprefix');
		$_eanPrefixLength=strlen($_eanPrefix);
		
		$_products=$this->get('collection');

		foreach($_products as $_id=>$_product)
		{
			$_sku = $_product->getSku();
			$_ean=Application_Helper_Data::ean13CheckDigit($_eanPrefix. str_pad($_id, (12 - $_eanPrefixLength), "0", STR_PAD_LEFT)); // generate ean13, pad product id to available digits

			if (strlen($_eanPrefix) != 13) throw new exception ('Generated EAN13 incorrect length.');
			
			$_data[] = array(
							$_sku,
							$_ean
						);			
		}
		
		$_header = array(
				'sku',
				'ean'
			);
		
		if (php_sapi_name() === 'cli') { // from command line
			
			$_file=$this->__config->get('pathToExportFile');
			
			foreach($_SERVER['argv'] as $_cliVar)
			{
				if ($_cliVar==="debug") { $_debug = true;}
			}
			
			Application_Helper_Data::exportToFile($_header,$_data,$_file,$_seperator);
			
			if ($_debug) { // with command line debug switch
				echo '< MAGENTO EAN -> D E B U G >' . "\n";
				echo 'Exporting EAN data for '. count($_products). ' Magento product/s ... '. "\n"; 
				echo 'Data file created at ' . $_file. "\n";
				echo 'Export finished.' . "\n";
			}
			
		} else if(isset($_GET['export'])){ // from web browser
		
			header("Content-type:text/octect-stream");
			header("Content-Disposition:attachment;filename=exportMyEANCodes.txt");

			echo Application_Helper_Data::exportToOutput($_header,$_data,$_seperator);
		}
		
	}
	
	private function loadConfig()
	{
		$this->__config= new config();
		$this->set('eanprefix',$this->__config->get('eanPrefix'));
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