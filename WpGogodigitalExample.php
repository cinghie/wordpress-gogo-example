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

	/** @var string */
	private $inputExample;

	/** @var string */
	private $radioExample;

	/** @var string */
	private $selectExample;

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
		$this->radioExample = get_option('gogodigital-example-radio');
		$this->selectExample = get_option('gogodigital-example-select');

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
		/** Add Example Input Option */
		add_option( 'gogodigital-example-input');

		/** Add Example Radio Option */
		add_option( 'gogodigital-example-radio');

		/** Add Example Select Option */
		add_option( 'gogodigital-example-select');

		/** Register Example Input Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-input', 'gogodigital_example_callback' );

		/** Register Example Input Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-radio', 'gogodigital_example_callback' );

		/** Register Example Select Optio */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-select', 'gogodigital_example_callback' );
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		?>

		<div class="wrap" style="overflow: hidden;">

			<div>
                <h1><?php echo $this->pageTitle ?></h1>
                <p><?php echo __( 'Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin', 'gogodigital-example' ) ?></p>
			</div>

			<form class="form-table" method="post" action="options.php">
				<?php settings_fields( 'gogodigital_example_options_group' ); ?>
				<table class="form-table">
					<tr valign="top">
                        <th scope="row">
                            <label for="gogodigital-example-input"><?php echo __( 'Example Input', 'gogodigital-example' ) ?></label>
                        </th>
						<td>
							<input class="form-control" type="text" id="gogodigital-example-input" name="gogodigital-example-input" value="<?php echo $this->inputExample ?>" style="min-width: 250px; padding: 6px;">
						</td>
					</tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="gogodigital-example-select"><?php echo __( 'Example Select', 'gogodigital-example' ) ?></label>
                        </th>
                        <td>
                            <select class="form-control" id="gogodigital-example-select" name="gogodigital-example-select" style="min-width: 250px; padding: 3px;">
                                <option value='1' <?php if ($this->selectExample === '1') { echo 'selected'; } else { echo ''; } ?>>Select Value 1</option>
                                <option value='2' <?php if ($this->selectExample === '2') { echo 'selected'; } else { echo ''; } ?>>Select Value 2</option>
                                <option value='3' <?php if ($this->selectExample === '3') { echo 'selected'; } else { echo ''; } ?>>Select Value 3</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="gogodigital-example-select"><?php echo __( 'Example Radio', 'gogodigital-example' ) ?></label>
                        </th>
                        <td>
                            <p>
                                <input type="radio" id="gogodigital-example-radio" name="gogodigital-example-radio" value="radiovalue1"<?php if ( $this->radioExample === 'radiovalue1' ) echo ' checked'; ?> />
                                <label for="gogodigital-example-radio">Radio Value 1</label>
                            </p>
                            <p>
                                <input type="radio" id="gogodigital-example-radio" name="gogodigital-example-radio" value="radiovalue2"<?php if ( $this->radioExample === 'radiovalue2' ) echo ' checked'; ?> />
                                <label for="gogodigital-example-radio">Radio Value 2</label>
                            </p>
                            <p>
                                <input type="radio" id="gogodigital-example-radio" name="ogodigital-example-radio" value="radiovalue3"<?php if ( $this->radioExample === 'radiovalue3' ) echo ' checked'; ?> />
                                <label for="gogodigital-example-radio">Radio Value 3</label>
                            </p>
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
