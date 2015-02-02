<?php

/*
Plugin Name: Advanced Custom Fields: Price
Plugin URI: https://github.com/speccode/acf-field-price
Description: DESCRIPTION
Version: 1.0.0
Author: Maciej Czerpiński
Author URI: http://speccode.com
License: MIT
License URI: http://opensource.org/licenses/MIT
*/

load_plugin_textdomain( 'acf-price', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );

function include_field_types_price( $version ) {

	include_once( 'acf-price-v5.php' );

}
add_action( 'acf/include_field_types', 'include_field_types_price' );

function register_fields_price() {

	include_once( 'acf-price-v4.php' );

}
add_action( 'acf/register_fields', 'register_fields_price' );
