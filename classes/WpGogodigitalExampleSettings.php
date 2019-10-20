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

require_once 'WpGogodigitalExampleWidgets.php';

/**
 * Class WpGogodigitalExampleSettings
 */
class WpGogodigitalExampleSettings
{
	/** @var string */
	private $pluginPath;

	/** @var string */
	private $pluginUrl;

	/** @var string */
	private $exampleDescription;

	/** @var string */
	private $exampleMenuSlug;

	/** @var string */
	private $exampleMenuTitle;

	/** @var string */
	private $examplePageTitle;

	/** @var string */
	private $inputExample;

	/** @var string */
	private $radioExample;

	/** @var string */
	private $selectExample;

	/** @var string */
	private $checkboxExample;

	/** @var string */
	private $selectPostTypesExample;

	/** @var string */
	private $selectCategoriesExample;

	/**
	 * Class Constructor
	 *
	 * @param string $exampleMenuSlug
	 * @param string $exampleMenuTitle
	 * @param string $examplePageTitle
	 * @param string $exampleDescription
	 */
	public function __construct($exampleMenuSlug = '', $exampleMenuTitle = '', $examplePageTitle ='', $exampleDescription ='')
	{
		/** Set Plugin info */
		$this->pluginPath = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->pluginUrl  = trailingslashit( plugin_dir_url( __FILE__ ) );

		/** Set Plugin values */
		$this->exampleMenuSlug    = $exampleMenuSlug;
		$this->exampleMenuTitle   = $exampleMenuTitle;
		$this->examplePageTitle   = $examplePageTitle;
		$this->exampleDescription = $exampleDescription;

		/** Set Settings values */
		$this->inputExample = get_option('gogodigital-example-input');
		$this->radioExample = get_option('gogodigital-example-radio');
		$this->selectExample = get_option('gogodigital-example-select');
		$this->checkboxExample = get_option('gogodigital-example-checkbox');
		$this->selectPostTypesExample = get_option('gogodigital-example-select-post-type');
		$this->selectCategoriesExample = get_option('gogodigital-example-select-category');

		/** Register Settings */
		add_action( 'admin_init', array($this,'gogodigital_example_register_settings') );
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

		/** Add Slider Select Post Type Option */
		add_option( 'gogodigital-example-select-post-type');

		/** Add Slider Select Category Option */
		add_option( 'gogodigital-example-select-category');

		/** Register Example Input Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-input', 'gogodigital_example_callback' );

		/** Register Example Input Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-radio', 'gogodigital_example_callback' );

		/** Register Example Select Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-select', 'gogodigital_example_callback' );

		/** Register Example Checkbox Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-checkbox', 'gogodigital_example_callback' );

		/** Register Example Select Post Types Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-select-post-type', 'gogodigital_example_callback' );

		/** Register Example Select Categories Option */
		register_setting( 'gogodigital_example_options_group', 'gogodigital-example-select-category', 'gogodigital_example_callback' );
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		$widgetClass = new WpGogodigitalExampleWidgets();
		$active_tab  = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'settings';
	?>

		<div class="wrap" style="overflow: hidden;">

			<div>
                <h1><?php echo $this->examplePageTitle ?></h1>
                <p><?php echo __( 'Gogodigital Example plugin just a simple example to develop a new Wordpress Plugin', 'gogodigital-example' ) ?></p>
			</div>

            <div class="settings-errors">
	            <?php settings_errors(); ?>
            </div>

            <h2 class="nav-tab-wrapper">
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=settings" class="nav-tab <?php echo $active_tab === 'settings' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'Settings', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=shortcode" class="nav-tab <?php echo $active_tab === 'shortcode' ? 'nav-tab-active' : ''; ?>">
		            <?php echo __( 'Shortcode', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=about" class="nav-tab <?php echo $active_tab === 'about' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'About', 'gogodigital-example' ) ?>
                </a>
            </h2>

			<form class="form-table" method="post" action="options.php">

                <?php if($active_tab === 'settings'): ?>

                    <?php settings_fields( 'gogodigital_example_options_group' ); ?>

                    <h2>Input Widgets</h2>

                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <?php echo $widgetClass::getLabelWidget('gogodigital-example-input',__( 'Example Input', 'gogodigital-example' )) ?>
                            </th>
                            <td>
                                <?php echo $widgetClass::getInputWidget('gogodigital-example-input',$this->inputExample,__( 'Example Input Description', 'gogodigital-example' )) ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php echo $widgetClass::getLabelWidget('gogodigital-example-select',__( 'Example Select', 'gogodigital-example' )) ?>
                            </th>
                            <td>
                                <?php echo $widgetClass::getSelectWidget('gogodigital-example-select',$this->selectExample,[
                                    'Select Value 1' => 'selectvalue1',
                                    'Select Value 2' => 'selectvalue2',
                                    'Select Value 3' => 'selectvalue3'
                                ], __( 'Example Select Description', 'gogodigital-example' )) ?>
                            </td>
                        </tr>
                        <tr>
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
                                ], __( 'Example Radio Description', 'gogodigital-example' )) ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <?php echo $widgetClass::getLabelWidget(
                                    'gogodigital-example-checkbox',
                                    __( 'Example Checkbox', 'gogodigital-example' )
                                ) ?>
                            </th>
                            <td>
                                <?php echo $widgetClass::getCheckboxWidget(
                                    'gogodigital-example-checkbox',
	                                $this->checkboxExample,
                                    __( 'Example Checkbox', 'gogodigital-example' ),
                                    __( 'Example Checkbox Description', 'gogodigital-example' )
                                ) ?>
                            </td>
                        </tr>
                    </table>

                    <hr style="border-bottom: 1px solid #ccc;">

                    <h2>Posts Widgets</h2>

                    <table class="form-table">
                        <tr>
                            <th scope="row">
				                <?php echo $widgetClass::getLabelWidget('gogodigital-example-select-post-type',__( 'Post Types Select', 'gogodigital-example' )) ?>
                            </th>
                            <td>
		                        <?php echo $widgetClass::getSelectPostTypesWidget('gogodigital-example-select-post-type',$this->selectPostTypesExample) ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
			                    <?php echo $widgetClass::getLabelWidget('gogodigital-example-select-category',__( 'Post Categories', 'gogodigital-example' )) ?>
                            </th>
                            <td>
			                    <?php echo $widgetClass::getSelectCategoriesWidget('gogodigital-example-select-category',$this->selectCategoriesExample) ?>
                            </td>
                        </tr>
                    </table>

                <?php elseif($active_tab === 'shortcode'): ?>

                    <h3><?php echo __( 'Shortcode', 'gogodigital-example' )?></h3>

                    <pre style="padding: 16px 10px; overflow: auto; line-height: 1.45; background-color: #f6f8fa; border-radius: 3px;">echo do_shortcode('[helloworld]');</pre>

				<?php elseif($active_tab === 'about'): ?>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

                <?php endif ?>

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
