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
 *
 * @see https://github.com/tareq1988/wordpress-settings-api-class/blob/master/src/class.settings-api.php
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
	public static function getLabelWidget(string $name, string $value) : string
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
	public static function getSubmitButton(string $name, string $value, string $class = 'button-primary') : string
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
	public static function getFieldDescription(string $name, string $description) : string
	{
		return $description ? '<p class="description" id="'.$name.'-description">'.$description.'</p>' : '';
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
	public static function getInputWidget(string $name, string $value, string $description = '', string $class = 'form-control', string $style = 'min-width: 200px; padding: 6px;') : string
	{
		$html = '<input class="'.$class.'" type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'" style="'.$style.'" />';
		$html .= self::getFieldDescription($name,$description);

		return $html;
	}

	/**
	 * Get Text Area Widget
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $description
	 * @param string $class
	 * @param string $cols
	 * @param string $rows
	 *
	 * @return string
	 */
	public static function getTextAreaWidget(string $name, string $value, string $description = '', string $class = 'form-control', string $cols = '100', string $rows = '10') : string
	{
		$html = '<textarea class="'.$class.'" name="'.$name.'" cols="'.$cols.'" rows="'.$rows.'">';
		$html .= $value;
		$html .= '</textarea>';
		$html .= self::getFieldDescription($name,$description);

		return $html;
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
	public static function getCheckboxWidget(string $name, string $value, string $label, string $description = '') : string
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
	 * Get Media Windget
	 *
	 * @param string $mediaFieldName
	 * @param string $mediaFieldId
	 * @param string $mediaValue
     *
     * @see https://jeroensormani.com/how-to-include-the-wordpress-media-selector-in-your-plugin/
	 */
	public static function getMediaInput(string $mediaFieldName, string $mediaFieldId, string $mediaValue) : void
	{
        self::media_selector_print_scripts($mediaFieldId, $mediaValue);
		wp_enqueue_media();

        $mediaSource = wp_get_attachment_url((int)$mediaValue) ?? '';

		?>
		<div class='image-preview-wrapper'>
			<img id='image-preview' src='<?php echo $mediaSource?>' alt="<?php echo $mediaFieldName?>" title="<?php echo $mediaFieldName?>" width='100' height='100' style='max-height: 100px; width: 100px;'>
		</div>
		<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
		<input type='hidden' name='<?php echo $mediaFieldName?>' id='<?php echo $mediaFieldId?>' value='<?php echo $mediaValue ?>'>
		<?php
	}

	/**
	 * Media Selector Script
     *
     * @param string $mediaFieldId
     * @param string $mediaValue
	 */
    public static function media_selector_print_scripts(string $mediaFieldId, string $mediaValue) : void
    {
		$my_saved_attachment_post_id = (int)$mediaValue;
		?>
        <script type='text/javascript'>

            jQuery( document ).ready( function( $ ) {

                // Uploading files
                let attachment;
                let file_frame;
                let wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                let set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

                jQuery('#upload_image_button').on('click', function( event )
                {
                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( file_frame ) {
                        // Set the post ID to what we want
                        file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                        // Open frame
                        file_frame.open();
                        return;
                    } else {
                        // Set the wp.media post id so the uploader grabs the ID we want when initialised
                        wp.media.model.settings.post.id = set_to_post_id;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.file_frame = wp.media({
                        title: 'Select a image to upload',
                        button: {
                            text: 'Use this image',
                        },
                        multiple: false	// Set to true to allow multiple files to be selected
                    });

                    // When an image is selected, run a callback.
                    file_frame.on( 'select', function() {
                        // We set multiple to false so only get one image from the uploader
                        attachment = file_frame.state().get('selection').first().toJSON();

                        // Do something with attachment.id and/or attachment.url here
                        $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                        $( '#<?php echo $mediaFieldId ?>' ).val( attachment.id );

                        // Restore the main post ID
                        wp.media.model.settings.post.id = wp_media_post_id;
                    });

                    // Finally, open the modal
                    file_frame.open();
                });

                // Restore the main ID when the add media button is pressed
                jQuery( 'a.add_media' ).on( 'click', function() {
                    wp.media.model.settings.post.id = wp_media_post_id;
                });
            });
		</script>
        <?php
	}

	/**
	 * Get Select Widget
	 *
	 * @param string $name
     * @param array|string $currentValue
	 * @param array $values
	 * @param string $description
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelectWidget(string $name, $currentValue, array $values, string $description = '', string $class = 'form-control', string $style = 'min-width: 200px; padding: 3px;') : string
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
	 * Get Select Multiple by Array Widget
	 *
	 * @param string $name
	 * @param array $array
	 * @param array|string $currentValue
	 * @param string $description
	 * @param string $class
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelectMultipleFromArrayWidget(string $name, array $array, $currentValue, string $description = '', string $class = 'form-control', string $style = 'min-width: 200px; padding: 3px 5px') : string
	{
		$html = '<select multiple class="'.$class.'" id="'.$name.'" name="'.$name.'[]" size="10" style="'.$style.'">';

		foreach($array as $key => $value)
		{
			if(is_array($currentValue)) {
				$selected = in_array((string) $value, $currentValue, false) ? 'selected' : '';
			} else {
				$selected = '';
			}

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
     * @param string $currentValue
	 * @param array $values
	 * @param string $description
	 *
	 * @return string
	 */
	public static function getRadioWidget(string $name, string $currentValue, array $values, string $description = '') : string
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
	 * Get Select Pages Widget
	 *
	 * @param string $name
	 * @param string $currentValue
	 * @param array $options
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectPagesWidget(string $name, string $currentValue, array $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], string $description = '', string $class = 'form-control') : string
	{
		$args = [
			'class' => $class,
			'hide_empty' => $options['hide_empty'],
			'id' => $name,
			'multiple' => false,
			'name' => $name,
			'order' => $options['order'],
			'orderby' => $options['orderby'],
			'required' => $options['required'],
			'selected' => $currentValue,
			'show_option_none' => __('None','wordpress')
		];

		add_filter( 'wp_dropdown_cats', array( __CLASS__, 'dropdown_style_filter'), 10, 2 );

		$html = wp_dropdown_pages($args);
		$html .= self::getFieldDescription($name,$description);

		remove_filter('wp_dropdown_pages', array( __CLASS__, 'dropdown_style_filter'));

		return $html;
	}

	/**
	 * Get Select Multiple Pages Widget
	 *
	 * @param string $name
	 * @param array|string $currentValue
	 * @param array $options
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectMultiplePagesWidget(string $name, $currentValue, array $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], string $description = '', string $class = 'form-control') : string
	{
		$args = [
			'class' => $class,
			'hide_empty' => $options['hide_empty'],
			'id' => $name,
			'multiple' => true,
			'name' => $name,
			'order' => $options['order'],
			'orderby' => $options['orderby'],
			'required' => $options['required'],
			'selected' => $currentValue,
			'show_option_none' => __('None','wordpress')
		];

		add_filter( 'wp_dropdown_pages', array( __CLASS__, 'dropdown_multiple_filter'), 10, 2 );

		$html = wp_dropdown_pages($args);
		$html .= self::getFieldDescription($name,$description);

		remove_filter('wp_dropdown_pages', array( __CLASS__, 'dropdown_multiple_filter'));

		return $html;
	}

	/**
	 * Get Select Categories Widget
	 *
	 * @param string $name
	 * @param array|string $currentValue
     * @param array|string $options
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectCategoriesWidget(string $name, $currentValue, $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], string $description = '', string $class = 'form-control') : string
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

		add_filter( 'wp_dropdown_cats', array( __CLASS__, 'dropdown_style_filter'), 10, 2 );

		$html  = wp_dropdown_categories($args);
		$html .= self::getFieldDescription($name,$description);

		remove_filter('wp_dropdown_cats', array( __CLASS__, 'dropdown_style_filter'));

		return $html;
	}

	/**
	 * Get Select Categories Widget
	 *
	 * @param string $name
	 * @param array $currentValue
     * @param array|string $options
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectMultipleCategoriesWidget(string $name, array $currentValue, $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], string $description = '', string $class = 'form-control') : string
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
	public static function getSelectPostTypesWidget(string $name, string $currentValue, bool $addAll = false, string $description = '', string $class = 'form-control', string $style = 'min-width: 200px; padding: 3px;') : string
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
	 * @param string $name
	 * @param string $currentValue
     * @param string|array $options
	 * @param string $description
	 * @param string $class
	 *
	 * @return string
	 */
	public static function getSelectMultipleTypesWidget(string $name, string $currentValue, $options = ['hide_empty' => 0, 'hierarchical' => true, 'order' => 'ASC', 'orderby' => 'NAME', 'required' => false,'taxonomy' => 'category'], string $description = '', string $class = 'form-control') : string
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
	 * Get Select User Roles Widget
	 *
	 * @param string $name
	 * @param string $currentValue
	 * @param string $description
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelectUserRoles(string $name, string $currentValue, string $description = '', string $class = 'form-control', string $style = 'min-width: 200px; padding: 3px;') : string
	{
		global $wp_roles;

		$values = [
			__('None') => 'none'
		];

		$roles = $wp_roles->roles;
		ksort($roles);

		foreach($roles as $key => $value) {
			$values[$value['name']] = $key;
		}

		return self::getSelectWidget($name, $currentValue, $values, $description, $class, $style);
	}

	/**
	 * Get Select Multiple User Roles
	 *
	 * @param string $name
	 * @param array|string $currentValue
	 * @param string $description
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelectMultipleUserRoles(string $name, $currentValue, string $description = '', string $class = 'form-control', string $style = 'min-width: 200px; padding: 3px;') : string
	{
		global $wp_roles;

		$array = [__('All') => 'all'];
		$roles = $wp_roles->roles;
		ksort($roles);

		foreach($roles as $key => $value) {
			$array[$value['name']] = $key;
		}

		return self::getSelectMultipleFromArrayWidget($name, $array, $currentValue, $description, $class, $style);
	}

	/**
	 * Style Dropdown Widget
	 *
	 * @param $output
	 *
	 * @return string|string[]|null
	 */
	public static function dropdown_style_filter( $output )
	{
		return preg_replace( '/<select /', '<select style="min-width: 200px; padding: 3px 5px;" ', $output);
	}

	/**
	 * Set Dropdown Widget as Multiple
	 *
	 * @param string $output
	 * @param array  $r
	 *
	 * @return string|string[]|null
	 * @see https://wordpress.stackexchange.com/questions/216070/wp-dropdown-categories-with-multiple-select
	 */
	public static function dropdown_multiple_filter(string $output, array $r )
	{
		if( isset( $r['multiple'] ) && $r['multiple'] )
		{
			$output = preg_replace( '/^<select/i', '<select size="6" style="min-width: 200px; padding: 3px 5px;" multiple', $output );
			$output = str_replace( "name='{$r['getSelectMultiplePagesWidgetname']}'", "name='{$r['name']}[]'", $output );

			$selected = is_array($r['selected']) ? $r['selected'] : explode( ',', $r['selected'] );

			foreach ( array_map( 'trim', $selected ) as $value ) {
				$output = str_replace( "value=\"{$value}\"", "value=\"{$value}\" selected", $output );
			}
		}

		return $output;
	}
}
