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

require_once 'WpWidgets.php';

/**
 * Class WpGogodigitalExample
 */
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
		$this->pluginPath  = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->pluginUrl   = trailingslashit( plugin_dir_url( __FILE__ ) );

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

		/** Add Example Select Option */
		add_option( 'gogodigital-example-checkbox');

		/** Register Example Input Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-input', 'gogodigital_example_callback' );

		/** Register Example Input Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-radio', 'gogodigital_example_callback' );

		/** Register Example Select Optio */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-select', 'gogodigital_example_callback' );

		/** Register Example Select Optio */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-checkbox', 'gogodigital_example_callback' );
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		$widgetClass = new WpWidgets();

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
	                        <?php echo $widgetClass::getLabelWidget('gogodigital-example-input',__( 'Example Input', 'gogodigital-example' )) ?>
                        </th>
						<td>
							<?php echo $widgetClass::getInputWidget('gogodigital-example-input',$this->inputExample,__( 'Example Input Description', 'gogodigital-example' )) ?>
						</td>
					</tr>
                    <tr valign="top">
                        <th scope="row">
	                        <?php echo $widgetClass::getLabelWidget('gogodigital-example-select',__( 'Example Select', 'gogodigital-example' )) ?>
                        </th>
                        <td>
	                        <?php echo $widgetClass::getSelectWidget('gogodigital-example-select',$this->selectExample,[
		                        'Select Value 1' => 'selectvalue1',
		                        'Select Value 2' => 'selectvalue2',
		                        'Select Value 3' => 'selectvalue3'
	                        ],__( 'Example Select Description', 'gogodigital-example' )) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
							<?php echo $widgetClass::getLabelWidget(
							        'gogodigital-example-radio',
                                    __( 'Example Radio', 'gogodigital-example' )
                            ) ?>
                        </th>
                        <td>
                            <?php echo $widgetClass::getRadioWidget('gogodigital-example-radio',$this->radioExample,[
                                'Radio Value 1' => 'radiovalue1',
                                'Radio Value 2' => 'radiovalue2',
                                'Radio Value 3' => 'radiovalue3'
                            ],__( 'Example Radio Description', 'gogodigital-example' )) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
							<?php echo $widgetClass::getLabelWidget(
							        'gogodigital-example-checkbox',
                                    __( 'Example Checkbox', 'gogodigital-example' )
                            ) ?>
                        </th>
                        <td>
                            <?php echo $widgetClass::getCheckboxWidget(
                                    'gogodigital-example-checkbox',
                                    1,
	                                __( 'Example Checkbox', 'gogodigital-example' ),
                                    __( 'Example Checkbox Description', 'gogodigital-example' )
                            ) ?>
                        </td>
                    </tr>
				</table>
				<div style="margin-top: 15px;">
					<?php echo $widgetClass::getSubmitButton(
					        'save',
                            __( 'Save Settings', 'gogodigital-example' )
                    ) ?>
				</div>
			</form>

			<div style="clear: both"></div>

		</div>

		<?php
	}
}
