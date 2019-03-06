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

/**
 * Class WpWidgets
 */
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
	public static function getLabelWidget($name, $value)
	{
		return '<label for="'.$name.'">'.$value.'</label>';
	}

	/**
	 * Get Submit Button
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSubmitButton($name, $value, $class = 'button-primary')
	{
		return '<input class="'.$class.'" type="submit" name="'.$name.'" value="'.$value.'" />';
	}

	/**
	 * Get Field Description Widget
	 *
	 * @param string $name
	 * @param string $description
	 *
	 * @return string
	 */
	public static function getFieldDescription($name, $description)
	{
		return $description ? '<p class="description" id="'.$name.'-description">'.$description.'</p>' : '';
	}

	/**
	 * Get Checkbox Widget
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $label
	 * @param string $description
	 *
	 * @return string
	 */
	public static function getCheckboxWidget($name, $value, $label, $description = '')
	{
		$checked = get_option($name) ? 'checked="checked"' : '';

		$html = '<fieldset><label for="users_can_register">';
		$html .= '<input type="checkbox" id="'.$name.'" name="'.$name.'" value="'.$value.'" '.$checked.' />';
		$html .= $label.'</label>';
		$html .= self::getFieldDescription($name,$description);
		$html .= '</fieldset>';

		return $html;
	}

	/**
	 * Get Simple Input Widget
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $description
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getInputWidget($name, $value, $description = '', $class = 'form-control', $style = 'min-width: 250px; padding: 6px;')
	{
		$html = '<input class="'.$class.'" type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'" style="'.$style.'" />';
		$html .= self::getFieldDescription($name,$description);

		return $html;
	}

	/**
	 * Get Select Widget
	 *
	 * @param string $name
	 * @param array $values
	 * @param string $currentValue
	 * @param string $description
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelectWidget($name, $currentValue, $values, $description = '', $class = 'form-control', $style = 'min-width: 250px; padding: 3px;')
	{
		$html = '<select class="'.$class.'" id="'.$name.'" name="'.$name.'" style="'.$style.'">';

		foreach($values as $key => $value)
		{
			$selected = $currentValue === $value ? 'selected' : '';
			$html .= '<option value="'.$value.'" '.$selected.'>'.$key.'</option>';
		}

		$html .= '</select>';
		$html .= self::getFieldDescription($name,$description);

		return $html;
	}

	/**
	 * Get Radio Widget
	 *
	 * @param string $name
	 * @param array $values
	 * @param string $currentValue
	 * @param string $description
	 *
	 * @return string
	 */
	public static function getRadioWidget($name, $currentValue, $values, $description = '')
	{
		$html = '';

		foreach($values as $key => $value)
		{
			$checked = $currentValue === $value ? ' checked' : '';
			$html .= '<p>';
			$html .= '<input type="radio" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$checked.' />';
			$html .= '<label for="'.$name.'">'.$key.'</label>';
			$html .= '</p>';
		}

		$html .= self::getFieldDescription($name,$description);

		return $html;
	}
}
