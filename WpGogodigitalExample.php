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
	/** @var string */
	private $pluginPath;

	/** @var string */
	private $pluginUrl;

	/** @var string */
	private $menuSlug;

	/** @var string */
	private $menuTitle;

	/** @var string */
	private $pageTitle;

	/** @var int  */
	private $inputExample;

	/**
	 * Class Constructor
	 *
	 * @param string $menuSlug
	 * @param string $menuTitle
	 * @param string $pageTitle
	 */
	public function __construct($menuSlug,$menuTitle,$pageTitle)
	{
		$this->pluginPath = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->pluginUrl  = trailingslashit( plugin_dir_url( __FILE__ ) );

		$this->menuSlug  = $menuSlug;
		$this->menuTitle = $menuTitle;
		$this->pageTitle = $pageTitle;

		/** Set Settings values */
		$this->inputExample = get_option('gogodigital-example-input');

		/** Register Settings */
		add_action( 'admin_init', array($this,'gogodigital_example_register_settings') );

		/** Add Plugin Page */
		add_action( 'admin_menu', array($this,'add_plugin_page') );
	}

	/**
	 * Add Sidebar Menu options page
	 */
	public function add_plugin_page()
	{
		add_menu_page(
			$this->pageTitle,
			$this->menuTitle,
			'manage_options',
			$this->menuSlug,
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Register all input settings
	 */
    public function gogodigital_example_register_settings()
	{
		/** Add input option */
		add_option( 'gogodigital-example-input');

		/** Register input option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-input', 'gogodigital_example_callback' );
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		?>

		<div class="wrap" style="overflow: hidden;">

			<div style="border-right: 1px solid #ddd; float: left; padding-right: 2%;  width: 100%">
                <h1><?php echo $this->pageTitle ?></h1>
                <p><?php echo __( 'Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin', 'gogodigital-example' ) ?></p>
			</div>
			<br/><br/>

			<form method="post" action="options.php">
				<?php settings_fields( 'gogodigital_example_options_group' ); ?>
				<table class="form-table">
					<tr valign="top">
						<td >
							<label style="margin-right: 25px;"><?php echo __( 'Example Input', 'gogodigital-example' ) ?></label>
							<input class="form-control" style="width:250px; padding: 6px;" type="text" id="gogodigital-example-input" name="gogodigital-example-input"  value="<?php echo $this->inputExample ?>" >
						</td>
					</tr>
				</table>
				<div style="margin-top: 15px;">
					<input type="submit" name="save" value="<?php echo __( 'Save Settings', 'gogodigital-example' ) ?>" class="button-primary" />
				</div>
			</form>

			<div style="clear: both"></div>

		</div>

		<?php
	}
}
