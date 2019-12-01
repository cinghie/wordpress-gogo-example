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
	private $selectMultiplePostTypesExample;

	/** @var string */
	private $selectCategoriesExample;

	/** @var string */
	private $selectMultipleCategoriesExample;

    /** @var array */
    private $settingsOptions;

    /** @var array */
    private $postsOptions;

    /** @var WpGogodigitalExampleWidgets */
    private $widgetClass;

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
		/** Set Plugin values */
		$this->exampleMenuSlug    = $exampleMenuSlug;
		$this->exampleMenuTitle   = $exampleMenuTitle;
		$this->examplePageTitle   = $examplePageTitle;
		$this->exampleDescription = $exampleDescription;

        /** Set Options */
        $this->settingsOptions = get_option('gogodigital_example_settings_options');
        $this->postsOptions = get_option('gogodigital_example_post_fields_options');

        /** Set WidgetClass */
        $this->widgetClass = new WpGogodigitalExampleWidgets();

		/** Set Settings values */
		$this->inputExample = $this->settingsOptions['gogodigital-example-input'];
		$this->radioExample = $this->settingsOptions['gogodigital-example-radio'];
		$this->selectExample = $this->settingsOptions['gogodigital-example-select'];
		$this->checkboxExample = $this->settingsOptions['gogodigital-example-checkbox'];

		$this->selectPostTypesExample = $this->postsOptions['gogodigital-example-select-post-type'];
		$this->selectMultiplePostTypesExample = $this->postsOptions['gogodigital-example-select-multiple-post-type'];
		$this->selectCategoriesExample = $this->postsOptions['gogodigital-example-select-category'];
		$this->selectMultipleCategoriesExample = $this->postsOptions['gogodigital-example-select-multiple-category'];

		/** Adding Translations */
        add_action( 'init', array( $this, 'load_textdomain' ) );

		/** Register Settings */
		add_action( 'admin_init', array($this,'gogodigital_example_register_settings') );
	}

    /**
     * Load translations
     */
    public function load_textdomain() {
        load_plugin_textdomain('gogodigital-example', false, basename( __DIR__ ).'/languages' );
    }

	/**
	 * Register all input settings
	 */
    public function gogodigital_example_register_settings()
	{
        /**
         * Register Simple Fields Options
         */
        register_setting(
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_sanitize'
        );

        add_settings_section(
            'gogodigital_example_settings_section',
            '',
            '',
            'gogodigital_example_settings_options'
        );

        add_settings_field(
            'gogodigital-example-input',
            __( 'Example Input', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_input_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

        add_settings_field(
            'gogodigital-example-select',
            __( 'Example Select', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_select_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

        add_settings_field(
            'gogodigital-example-radio',
            __( 'Example Radio', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_radio_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

        add_settings_field(
            'gogodigital-example-checkbox',
            __( 'Example Select', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_checkbox_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

		/**
		 * Register Post Fields Options
		 */
		register_setting(
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_sanitize'
		);

		add_settings_section(
			'gogodigital_example_post_fields_section',
			'',
			'',
			'gogodigital_example_post_fields_options'
		);

		add_settings_field(
			'gogodigital-example-select-post-type',
			__( 'Post Types Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_post_fields_select_post_type_callback'),
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_section'
		);

		add_settings_field(
			'gogodigital-example-select-multiple-post-type',
			__( 'Post Types Multiple Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_post_fields_select_multiple_post_type_callback'),
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_section'
		);

		add_settings_field(
			'gogodigital-example-select-category',
			__( 'Post Categories Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_post_fields_select_category_callback'),
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_section'
		);

		add_settings_field(
			'gogodigital-example-select-multiple-category',
			__( 'Post Categories Multiple Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_post_fields_select_category_multiple_callback'),
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_section'
		);
	}

    /**
     * Input Callback
     */
    public function gogodigital_example_settings_input_callback()
    {
        echo $this->widgetClass::getInputWidget(
            'gogodigital_example_settings_options[gogodigital-example-input]',
            $this->inputExample,
            __( 'Example Input Description', 'gogodigital-example' )
        );
    }

    /**
     * Radio Callback
     */
    public function gogodigital_example_settings_radio_callback()
    {
        echo $this->widgetClass::getRadioWidget(
            'gogodigital_example_settings_options[gogodigital-example-radio]',
            $this->radioExample,
            [
                'Radio Value 1' => 'radiovalue1',
                'Radio Value 2' => 'radiovalue2',
                'Radio Value 3' => 'radiovalue3'
            ],
            __( 'Example Radio Description', 'gogodigital-example' )
        );
    }

    /**
     * Select Callback
     */
    public function gogodigital_example_settings_select_callback()
    {
        echo $this->widgetClass::getSelectWidget(
            'gogodigital_example_settings_options[gogodigital-example-select]',
            $this->selectExample,
            [
                'Select Value 1' => 'selectvalue1',
                'Select Value 2' => 'selectvalue2',
                'Select Value 3' => 'selectvalue3'
            ],
            __( 'Example Select Description', 'gogodigital-example' )
        );
    }

    /**
     * Checkbox Callback
     */
    public function gogodigital_example_settings_checkbox_callback()
    {
        echo $this->widgetClass::getCheckboxWidget(
            'gogodigital_example_settings_options[gogodigital-example-checkbox]',
            $this->checkboxExample,
            __( 'Example Checkbox', 'gogodigital-example' ),
            __( 'Example Checkbox Description', 'gogodigital-example' )
        );
    }

	/**
	 * Simple Inputs Sanitize
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function gogodigital_example_settings_sanitize($input)
	{
		$output = array();

		if( isset( $input['gogodigital-example-input'] ) ) {
			$new_input['gogodigital-example-input'] = sanitize_text_field( $input['gogodigital-example-input'] );
		}

		return $output;
	}

	/**
	 * Select Category Callback
	 */
	public function gogodigital_example_post_fields_select_category_callback()
	{
		$this->widgetClass::getSelectCategoriesWidget(
			'gogodigital_example_post_fields_options[gogodigital-example-select-category]',
			$this->selectCategoriesExample
		);
	}

	/**
	 * Select Multiple Category Callback
	 */
	public function gogodigital_example_post_fields_select_category_multiple_callback()
	{
		$this->widgetClass::getSelectMultipleCategoriesWidget(
			'gogodigital_example_post_fields_options[gogodigital-example-select-multiple-category]',
			$this->selectMultipleCategoriesExample
		);
	}

    /**
     * Select PostTypes Callback
     */
    public function gogodigital_example_post_fields_select_post_type_callback()
    {
        echo $this->widgetClass::getSelectPostTypesWidget(
            'gogodigital_example_post_fields_options[gogodigital-example-select-post-type]',
            $this->selectPostTypesExample
        );
    }

    /**
     * Select Multiple PostTypes Callback
     */
    public function gogodigital_example_post_fields_select_multiple_post_type_callback()
    {
        $this->widgetClass::getSelectMultipleCategoriesWidget(
            'gogodigital_example_post_fields_options[gogodigital-example-select-multiple-post-type]',
            $this->selectMultiplePostTypesExample
        );
    }

	/**
	 * Post Fields Sanitize
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function gogodigital_example_post_fields_sanitize($input)
	{
		$output = array();

		return $output;
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		$active_tab  = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'inputs';
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
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=inputs" class="nav-tab <?php echo $active_tab === 'inputs' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'Simple Fields', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=posts" class="nav-tab <?php echo $active_tab === 'posts' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'Post Fields', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=woocommerce" class="nav-tab <?php echo $active_tab === 'woocommerce' ? 'nav-tab-active' : ''; ?>">
		            <?php echo __( 'Woocommerce Fields', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=users" class="nav-tab <?php echo $active_tab === 'users' ? 'nav-tab-active' : ''; ?>">
		            <?php echo __( 'Users Fields', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=shortcode" class="nav-tab <?php echo $active_tab === 'shortcode' ? 'nav-tab-active' : ''; ?>">
		            <?php echo __( 'Shortcode', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=about" class="nav-tab <?php echo $active_tab === 'about' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'About', 'gogodigital-example' ) ?>
                </a>
            </h2>

			<form class="form-table" method="post" action="options.php">

                <?php if($active_tab === 'inputs'): ?>

                    <?php
                        settings_fields( 'gogodigital_example_settings_options' );
                        do_settings_sections( 'gogodigital_example_settings_options' );
                    ?>

                <?php elseif($active_tab === 'posts'): ?>

                    <?php
                        settings_fields( 'gogodigital_example_post_fields_options' );
                        do_settings_sections( 'gogodigital_example_post_fields_options' );
                    ?>

                <?php elseif($active_tab === 'shortcode'): ?>

                    <h3><?php echo __( 'Shortcode', 'gogodigital-example' )?></h3>

                    <pre style="padding: 16px 10px; overflow: auto; line-height: 1.45; background-color: #f6f8fa; border-radius: 3px;">echo do_shortcode('[helloworld]');</pre>

                <?php elseif($active_tab === 'about'): ?>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

                <?php endif ?>

                <?php submit_button(__( 'Save', 'gogodigital-example' )) ?>

			</form>

			<div style="clear: both"></div>

		</div>

		<?php
	}
}
