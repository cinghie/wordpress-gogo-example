<?php

/**
 * Plugin Name: Gogodigital Example Plugin
 * Description: Gogodigital Example Plugin just a simple example plugin to develop a new Wordpress Plugin
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
 * Modify this plugin params
 */
$menuSlug  = 'gogodigital-example-plugin';
$menuTitle = __( 'Example', 'gogodigital-example' );
$pageTitle = __( 'Gogodigital Plugin Example Admin', 'gogodigital-example' );

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
 * Settings Button on Plugins Page
 *
 * @param $links
 * @param $file
 *
 * @return string
 */
function gogodigital_example_action_links($links, $file)
{
	static $this_plugin;

	if (!$this_plugin) {
		$this_plugin = plugin_basename( __FILE__ );
	}

	if ($file === $this_plugin) {
		$settings_link = '<a href="options-general.php?page=gogodigital-example-plugin">' . __( 'Settings', 'gogodigital-example' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

add_filter( 'plugin_action_links', 'gogodigital_example_action_links', 10, 2);

/**
 * Create Plugin Page
 */
if( is_admin() ) {
	$pluginPage = new WpGogodigitalExample($menuSlug,$menuTitle,$pageTitle);
}
