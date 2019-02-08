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
	/** @var int  */
	private $inputExample;

	/** @var $options  */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		/** Add Plugin Page */
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );

		/** Set input settings values */
		$this->inputExample = get_option('gogodigital-example-input');
	}

	/**
	 * Add Sidebar Menu options page
	 */
	public function add_plugin_page()
	{
		add_menu_page(
			'Gogodigital Plugin Example Admin',
			'Example',
			'manage_options',
			'gogodigital-example-plugin',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		?>

		<div class="wrap" style="overflow: hidden;">

			<div style="border-right: 1px solid #ddd; float: left; padding-right: 2%;  width: 100%">
				<h1>Gogodigital Plugin Example</h1>
			</div>
			<br/><br/>

			<form method="post" action="options.php">
				<?php settings_fields( 'gogodigital_example_options_group' ); ?>
				<table>
					<tr valign="top">
						<td >
							<h4>Example Input</h4>
							<input class="form-control" style="width:250px; padding: 6px;" type="text" id="gogodigital-example-input" name="gogodigital-example-input"  value="<?php echo $this->inputExample ?>" >
						</td>
					</tr>
				</table>
				<div style="margin-top: 15px;">
					<input type="submit" name="save_apikey" value="Salva Impostazioni" class="button-primary" />
				</div>
			</form>

			<div style="clear: both"></div>

		</div>

		<?php
	}
}
