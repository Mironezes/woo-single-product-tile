<?php
/*
Plugin Name: Single Product Tile Widget For WooCommerce
Description: Display a chosen single product tile with this handy widget.
Version: 1.0.0
Author: Alexey Suprun
License: GPL2
WC requires at least: 3.0.0
WC tested up to: 3.8.0
Text Domain: woo-single-product-tile
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !function_exists('get_plugin_data') ){
	    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

if ( !function_exists( 'wspt_version' ) ) {
	function wspt_version() {
		$wspt_plugin_data = get_plugin_data( __FILE__ );
		$wspt_plugin_version = $wspt_plugin_data['Version'];
		return $wspt_plugin_version;
	}
}

//widget
require_once('widget/wspt-widget.php');
?>
