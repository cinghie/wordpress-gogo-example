<?php

/**
 * Plugin Name: Gogodigital Example Plugin
 * Description: Example Plugin for Wordpress
 * Author: Gogodigital S.r.l.s.
 * Author URI: https://www.gogodigital.it
 * Version: 1.0.0
 * Text Domain: gogodigital-example
 **/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

require_once 'WpGogodigitalExample.php';

/**
 * Register all input settings
 */
function gogodigital_example_register_settings()
{
	/** Add input option */
	add_option( 'gogodigital-example-input');

	/** Register input option */
	register_setting( 'gogodigital_example_options_group', 'gogodigital-example-input', 'gogodigital_example_callback' );
}

add_action( 'admin_init', 'gogodigital_example_register_settings' );

/**
 * Create Plugin Page
 */
if( is_admin() ) {
	$importer_page = new WpGogodigitalExample();
}
