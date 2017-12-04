<?php
/*
Plugin Name: WooCommerce AJAX Cart Quantity
Plugin URI: http://www.bryanheadrick.com
Description: Page Caching safe method to display current cart quantity on a menu item
Version: 1.1
Author: Bryan Headrick
Author URI: http://www.bryanheadrick.com
*/
/*

Changelog:
v1.0: Initial release

*/
/*
Credits: 
	This template is based on the template at http://pressography.com/plugins/wordpress-plugin-template/ 
	My changes are documented at http://soderlind.no/archives/2010/03/04/wordpress-plugin-template/
*/

if (!class_exists('wc_ajax_cart_quantity')) {
	class wc_ajax_cart_quantity {
		/**
		* @var string The options string name for this plugin
		*/
		var $optionsName = 'wc_ajax_cart_quantity_options';

		/**
		* @var array $options Stores the options for this plugin
		*/
		var $options = array();
		/**
		* @var string $localizationDomain Domain used for localization
		*/
		var $localizationDomain = "wc_ajax_cart_quantity";

		/**
		* @var string $url The url to this plugin
		*/ 
		var $url = '';
		/**
		* @var string $urlpath The path to this plugin
		*/
		var $urlpath = '';

		//Class Functions
		/**
		* PHP 4 Compatible Constructor
		*/
		function wc_ajax_cart_quantity(){$this->__construct();}

		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
			//Language Setup
			$locale = get_locale();
			$mo = plugin_dir_path(__FILE__) . 'languages/' . $this->localizationDomain . '-' . $locale . '.mo';	
			load_textdomain($this->localizationDomain, $mo);

			//"Constants" setup
			$this->url = plugins_url(basename(__FILE__), __FILE__);
			$this->urlpath = plugins_url('', __FILE__);	
			//Initialize the options
			//Admin menu
			
			//Actions
			//add_action("init", array(&$this,"wc_ajax_cart_quantity_init"));	
			//	add_action( 'wp_enqueue_scripts', array(&$this,'wcajaxcartqty_addscripts') );
                add_action( 'wp_ajax_nopriv_get_ajax_cart_qty', array(&$this,'get_ajax_cart_qty'));
                add_action( 'wp_ajax_get_ajax_cart_qty', array(&$this,'get_ajax_cart_qty'));
        
		}

		function wc_ajax_cart_quantity_init() {

		}

        function get_ajax_cart_qty(){
            global $woocommerce;
            print $woocommerce->cart->cart_contents_count;
            
        }

		} //End Class
} //End if class exists statement


if (isset($_GET['wc_ajax_cart_quantity_javascript'])) {


} else {
	if (class_exists('wc_ajax_cart_quantity')) { 
		$wc_ajax_cart_quantity_var = new wc_ajax_cart_quantity();
	}
}
?>