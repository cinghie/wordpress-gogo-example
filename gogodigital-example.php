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
$menuSlug  = 'gogodigital-example-plugin';
$menuTitle = __( 'Example', 'gogodigital-example' );
$pageTitle = __( 'Gogodigital Example', 'gogodigital-example' );

/**
 * Create Plugin Page
 */
if( is_admin() ) {

	/** Add Plugin Page Menu */
	add_action('admin_menu', 'add_plugin_page');

	/** Add Plugin Settings Link on Plugin Page  */
	add_filter('plugin_action_links', 'gogodigital_example_action_links', 10, 2);

	$pluginPage = new WpGogodigitalExampleSettings($menuSlug,$menuTitle,$pageTitle);

} else {

	$helloWorld = new WpGogodigitalExample();

	add_shortcode( 'togglemenu', array($helloWorld,'gogodigital_hello_world_shortcode') );
}

/**
 * Add Sidebar Menu options page
 */
function add_plugin_page()
{
	global $admin_page_hooks,$pageTitle, $menuSlug, $menuTitle;

	if ( !isset( $admin_page_hooks[ 'gogodigital_plugin_panel' ] ) )
	{
		add_menu_page(
			$pageTitle,
			'Gogodigital',
			'manage_options',
			'gogodigital-panel',
			array( new WpGogodigitalExampleSettings($menuSlug,$menuTitle,$pageTitle), 'create_admin_page' ),
			gogodigital_plugin_get_logo(),
			apply_filters( 'gogodigital_plugins_menu_item_position', '62' )
		);
	}

	add_submenu_page( 'gogodigital-panel', $pageTitle, $menuTitle, 'manage_options', $menuSlug, array( new WpGogodigitalExampleSettings($menuSlug,$menuTitle,$pageTitle), 'create_admin_page' ) );
	remove_submenu_page( 'gogodigital-panel', 'gogodigital-panel' );
}

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

/**
 * Get Gogodigital SVG logo
 *
 * @return string
 */
function gogodigital_plugin_get_logo()
{
	return untrailingslashit( plugins_url( '/', __FILE__ ) . '/assets/img/gogodigital-icon.svg');
}
