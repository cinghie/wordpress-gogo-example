<?php

/**
 * Plugin Name: Gogodigital Example
 * Plugin URI: https://github.com/cinghie/wordpress-gogo-example
 * Description: Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin
 * Author: Gogodigital S.r.l.s.
 * Author URI: https://www.gogodigital.it
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Version: 1.0.0
 * Text Domain: gogodigital-example
 **/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

require_once 'classes/WpGogodigitalExample.php';
require_once 'classes/WpGogodigitalExampleSettings.php';

/**
 * Modify this plugin params
 */
$baseName  = plugin_basename( __FILE__ );
$menuSlug  = 'gogodigital-example-plugin';
$menuTitle = __( 'Example', 'gogodigital-example' );
$pageTitle = __( 'Gogodigital Example', 'gogodigital-example' );

/**
 * Create Plugin Page
 */
if( is_admin() ) {

	$pluginPage = new WpGogodigitalExampleSettings($baseName,$menuSlug,$menuTitle,$pageTitle);

} else {

	$helloWorld = new WpGogodigitalExample();

	add_shortcode( 'togglemenu', array($helloWorld,'gogodigital_hello_world_shortcode') );
}
