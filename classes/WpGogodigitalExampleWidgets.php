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

/**
 * Class WpGogodigitalExampleWidgets
 */
class WpGogodigitalExampleWidgets
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
	 * @param string $label
	 * @param string $description
	 *
	 * @return string
	 */
	public static function getCheckboxWidget($name, $value, $label, $description = '')
	{
		$checked = $value ? 'checked="checked"' : '';

		$html = '<fieldset><label for="users_can_register">';
		$html .= '<input type="checkbox" id="'.$name.'" name="'.$name.'" value="1" '.$checked.' />';
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
	public static function getInputWidget($name, $value, $description = '', $class = 'form-control', $style = 'min-width: 200px; padding: 6px;')
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
	public static function getSelectWidget($name, $currentValue, $values, $description = '', $class = 'form-control', $style = 'min-width: 200px; padding: 3px;')
	{
		$html = '<select class="'.$class.'" id="'.$name.'" name="'.$name.'" style="'.$style.'">';

		foreach($values as $key => $value)
		{
			$selected = (string)$currentValue === (string)$value ? 'selected' : '';
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

	/**
	 * Get Select Post Types Widget
	 *
	 * @param string $name
	 * @param string $currentValue
	 * @param bool $addAll
	 * @param string $description
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelectPostTypesWidget($name, $currentValue, $addAll = false, $description = '', $class = 'form-control', $style = 'min-width: 200px; padding: 3px;')
	{
		$values = [];

		if($addAll) {
			$values['all'] = 'all';
		}

		foreach(get_post_types('') as $type) {
			$values[$type] = $type;
		}

		return self::getSelectWidget($name, $currentValue, $values, $description, $class, $style);
	}

	/**
	 * Get Select Categories Widget
	 *
	 * @param string|array $options
	 * @param string $name
	 * @param string $currentValue
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectCategoriesWidget($name, $currentValue, $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], $description = '', $class = 'form-control')
	{
		$args = [
			'class' => $class,
			'hide_empty' => $options['hide_empty'],
			'hierarchical' => true,
			'id' => $name,
			'multiple' => false,
			'name' => $name,
			'order' => $options['order'],
			'orderby' => $options['orderby'],
			'required' => $options['required'],
			'selected' => $currentValue,
			'show_option_none' => __('None','wordpress'),
			'taxonomy' => $options['taxonomy']
		];

		add_filter( 'wp_dropdown_cats', array( __CLASS__, 'dropdown_multiple_filter'), 10, 2 );

		$html  = wp_dropdown_categories($args);
		$html .= self::getFieldDescription($name,$description);

		remove_filter('wp_dropdown_cats', array( __CLASS__, 'dropdown_style_filter'));

		return $html;
	}

	/**
	 * Get Select Categories Widget
	 *
	 * @param string|array $options
	 * @param string $name
	 * @param string $currentValue
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectMultipleCategoriesWidget($name, $currentValue, $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], $description = '', $class = 'form-control')
	{
		$args = [
			'class' => $class,
			'hide_empty' => $options['hide_empty'],
			'hierarchical' => true,
			'id' => $name,
			'multiple' => true,
			'name' => $name,
			'order' => $options['order'],
			'orderby' => $options['orderby'],
			'required' => $options['required'],
			'selected' => $currentValue,
			'show_option_none' => __('None','wordpress'),
			'taxonomy' => $options['taxonomy']
		];

		add_filter( 'wp_dropdown_cats', array( __CLASS__, 'dropdown_multiple_filter'), 10, 2 );

		$html  = wp_dropdown_categories( $args );
		$html .= self::getFieldDescription($name,$description);

		remove_filter( 'wp_dropdown_cats', array( __CLASS__, 'dropdown_multiple_filter') );

		return $html;
	}

	/**
	 * Style Dropdown Widget
	 *
	 * @param $output
	 *
	 * @return string|string[]|null
	 */
	public function dropdown_style_filter($output )
	{
		$output = preg_replace( '/<select (.*?) >/', '<select style="min-width: 200px; padding: 3px 5px;">', $output);

		return $output;
	}

	/**
	 * Set Dropdown Widget as Multiple
	 *
	 * @param string $output
	 * @param array $r
	 *
	 * @return string|string[]|null
	 * @see https://wordpress.stackexchange.com/questions/216070/wp-dropdown-categories-with-multiple-select
	 */
	public function dropdown_multiple_filter( $output, $r )
	{
		if( isset( $r['multiple'] ) && $r['multiple'] )
		{
			$output = preg_replace( '/^<select/i', '<select size="6" style="min-width: 200px; padding: 3px 5px;" multiple', $output );
			$output = str_replace( "name='{$r['name']}'", "name='{$r['name']}[]'", $output );

			$selected = is_array($r['selected']) ? $r['selected'] : explode( ',', $r['selected'] );

			foreach ( array_map( 'trim', $selected ) as $value ) {
				$output = str_replace( "value=\"{$value}\"", "value=\"{$value}\" selected", $output );
			}
		}

		return $output;
	}
}
