<?php

/**
 * Plugin Name: Gogodigital Example
 * Description: Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin
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
$pageTitle = __( 'Gogodigital Example', 'gogodigital-example' );

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
