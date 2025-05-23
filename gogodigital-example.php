<?php

/**
 * Plugin Name: Gogodigital Example
 * Plugin URI: https://www.gogodigital.it
 * Description: Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin
 * Version: 1.0.0
 * Author: Gogodigital S.r.l.s.
 * Author URI: https://www.gogodigital.it
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: gogodigital-example
 * Requires at least: 6.1
 * Requires PHP: 7.4
 **/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

if ( !defined( 'GOGODIGITAL_EXAMPLE_BASENAME' ) ) {
	define( 'GOGODIGITAL_EXAMPLE_BASENAME', plugin_basename( __FILE__ ) );
}

if ( !defined( 'GOGODIGITAL_EXAMPLE_PATH' ) ) {
    define( 'GOGODIGITAL_EXAMPLE_PATH', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'GOGODIGITAL_EXAMPLE_URL' ) ) {
	define( 'GOGODIGITAL_EXAMPLE_URL', plugin_dir_url( __FILE__ ) );
}

require_once 'classes/WpGogodigitalExample.php';
require_once 'classes/WpGogodigitalExampleSettings.php';

/**
 * Modify this plugin params
 */
$exampleMenuSlug = 'gogodigital-example-plugin';
$exampleMenuTitle = __( 'Example', 'gogodigital-example' );
$examplePageTitle = __( 'Gogodigital Example', 'gogodigital-example' );
$exampleDescription = __( 'Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin', 'gogodigital-example' );

/**
 * Create Plugin Page
 */
if( is_admin() ) {

	/** Add Plugin Page Menu */
	add_action('admin_menu', 'gogodigital_example_plugin_page');

	/** Add Plugin Settings Link on Plugin Page  */
	add_filter('plugin_action_links', 'gogodigital_example_action_links', 10, 2);

	/** Load Translations */
	add_action( 'plugins_loaded', 'gogodigital_example_load_textdomain' );

} else {

	$helloWorld = new WpGogodigitalExample();

	add_shortcode( 'helloworld', array($helloWorld,'gogodigital_hello_world_shortcode') );
}

/**
 * Load translations
 */
if( !function_exists('gogodigital_example_load_textdomain') )
{
	function gogodigital_example_load_textdomain() {
		load_plugin_textdomain('gogodigital-example', false, dirname( GOGODIGITAL_EXAMPLE_BASENAME ).'/languages/' );
	}
}

/**
 * Add Sidebar Menu options page
 */
if( !function_exists('gogodigital_example_plugin_page') )
{
	function gogodigital_example_plugin_page()
	{
		global $admin_page_hooks, $examplePageTitle, $exampleMenuSlug, $exampleMenuTitle, $exampleDescription;

		if ( !isset( $admin_page_hooks[ 'gogodigital_plugin_panel' ] ) )
		{
			add_menu_page(
				$examplePageTitle,
				'Gogodigital',
				'nosuchcapability',
				'gogodigital-panel',
				null,
				gogodigital_plugin_get_logo(),
				apply_filters( 'gogodigital_plugins_menu_item_position', '62' )
			);

			$admin_page_hooks[ 'gogodigital_plugin_panel' ] = 'gogodigital-plugins';
		}

		add_submenu_page( 'gogodigital-panel', $examplePageTitle, $exampleMenuTitle, 'manage_options', $exampleMenuSlug, array( new WpGogodigitalExampleSettings($exampleMenuSlug,$exampleMenuTitle,$examplePageTitle,$exampleDescription), 'create_admin_page' ) );
		remove_submenu_page( 'gogodigital-panel', 'gogodigital-panel' );
	}
}

/**
 * Settings Button on Plugins Page
 *
 * @param $links
 * @param $file
 *
 * @return string
 */
if( !function_exists('gogodigital_example_action_links') )
{
	function gogodigital_example_action_links($links, $file)
	{
		global $exampleMenuSlug;

		if ($file === GOGODIGITAL_EXAMPLE_BASENAME) {
			$settings_link = '<a href="admin.php?page='.$exampleMenuSlug.'">' . __( 'Settings', 'gogodigital-example' ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}
}

/**
 * Get Gogodigital SVG logo
 *
 * @return string
 */
if( !function_exists('gogodigital_plugin_get_logo') )
{
	function gogodigital_plugin_get_logo()
	{
		return untrailingslashit( plugins_url( '/', __FILE__ ) . '/assets/img/gogodigital-icon.svg');
	}
}
