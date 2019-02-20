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

class WpWidgets
{

	/**
	 * Get Label Widget
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return string
	 */
	public static function getLabelWidget($name,$value)
	{
		return '<label for="'.$name.'">'.$value.'</label>';
	}

	/**
	 * Get Simple Input Widget
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getInputWidget($name, $value, $class = 'form-control', $style = 'min-width: 250px; padding: 6px;')
	{
		return '<input class="'.$class.'" type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'" style="'.$style.'"';
	}

}
