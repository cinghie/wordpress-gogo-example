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
 * Add the field to the checkout page
 */
function customise_checkout_field($checkout)
{
	echo '<div id="customise_checkout_field">';
	woocommerce_form_field('sdi', array(
		'type' => 'text',
		'class' => array(
			'sdi-class form-row-wide'
		) ,
		'label' => __('Codice SDI') ,
		'placeholder' => __('SDI') ,
		'required' => true,
	) , $checkout->get_value('customised_field_name'));
	echo '</div>';
}

add_action('woocommerce_after_checkout_billing_form', 'customise_checkout_field');

/**
 * Create Plugin Page
 */
if( is_admin() ) {
	$pluginPage = new WpGogodigitalExample($menuSlug,$menuTitle,$pageTitle);
}
