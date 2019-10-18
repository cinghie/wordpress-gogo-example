<?php

/**
 * Author: Gogodigital S.r.l.s.
 * Author URI: https://www.gogodigital.it
 **/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class WpGogodigitalExample
{
	/**
	 * @param $atts
	 *
	 * @return string
	 */
	function gogodigital_hello_world_shortcode( $atts )
	{
		$a = shortcode_atts( array(
			'name' => 'world'
		), $atts );

		return 'Hello ' . $a['name'] . '!';
	}
}
