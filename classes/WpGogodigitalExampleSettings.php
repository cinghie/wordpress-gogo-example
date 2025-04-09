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
	/**
     * @var string
     */
	private $exampleDescription;

	/**
     * @var string
     */
	private $exampleMenuSlug;

	/**
     * @var string
     */
	private $exampleMenuTitle;

	/**
     * @var string
     */
	private $examplePageTitle;

	/**
     * Fields Examples
	 *
	 * @var array
	 */
	private $settingsOptions;

	/**
     * @var string
     */
	private $inputExample;

	/**
     * @var string
     */
	private $textAreaExample;


	/**
     * @var string
     */
	private $editorExample;

	/**
     * @var string
     */
	private $radioExample;

	/**
     * @var string
     */
	private $selectExample;

	/**
     * @var string
     */
	private $checkboxExample;

	/**
     * @var string
     */
	private $toggleSwitchExample;

	/**
     * @var string
     */
	private $mediaExample;

	/**
     * Post Fields Examples
	 *
	 * @var array
	 */
	private $postsOptions;

	/**
     * @var string
     */
	private $selectPagesExample;

	/**
     * @var string
     */
	private $selectMultiplePagesExample;

	/**
     * @var string
     */
	private $selectCategoriesExample;

	/**
     * @var string
     */
	private $selectMultipleCategoriesExample;

	/**
     * @var string
     */
	private $selectPostTypesExample;

	/**
     * @var string
     */
	private $selectMultiplePostTypesExample;

	/**
     * User Fields Examples
     *
	 * @var array
	 */
	private $usersOptions;

	/**
     * @var string
     */
	private $selectUserRolesExample;

	/**
     * @var string
     */
	private $selectMultipleUserRolesExample;

    /**
     * @var WpGogodigitalExampleWidgets
     */
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
		$this->exampleMenuSlug = $exampleMenuSlug;
		$this->exampleMenuTitle = $exampleMenuTitle;
		$this->examplePageTitle = $examplePageTitle;
		$this->exampleDescription = $exampleDescription;

        /** Set Options */
        $this->settingsOptions = get_option('gogodigital_example_settings_options') ?: [];
        $this->postsOptions = get_option('gogodigital_example_post_fields_options') ?: [];
        $this->usersOptions = get_option('gogodigital_example_user_roles_options') ?: [];

        /** Set WidgetClass */
        $this->widgetClass = new WpGogodigitalExampleWidgets();

		/** Set Settings Examples values */
		$this->inputExample = $this->settingsOptions['gogodigital-example-input'] ?? '';
		$this->textAreaExample = $this->settingsOptions['gogodigital-example-textarea'] ?? '';
		$this->editorExample = $this->settingsOptions['gogodigital-example-editor'] ?? '';
		$this->radioExample = $this->settingsOptions['gogodigital-example-radio'] ?? '';
		$this->selectExample = $this->settingsOptions['gogodigital-example-select'] ?? '';
		$this->checkboxExample = $this->settingsOptions['gogodigital-example-checkbox'] ?? '';
		$this->toggleSwitchExample = $this->settingsOptions['gogodigital-example-toggleswitch'] ?? '';
		$this->mediaExample = $this->settingsOptions['gogodigital-example-media'] ?? 0;

		/** Set Post Examples values */
		$this->selectPagesExample = $this->postsOptions['gogodigital-example-select-pages'] ?? '';
		$this->selectMultiplePagesExample = $this->postsOptions['gogodigital-example-select-multiple-pages'] ?? [];
		$this->selectPostTypesExample = $this->postsOptions['gogodigital-example-select-post-type'] ?? '';
		$this->selectMultiplePostTypesExample = $this->postsOptions['gogodigital-example-select-multiple-post-type'] ?? [];
		$this->selectCategoriesExample = $this->postsOptions['gogodigital-example-select-category'] ?? '';
		$this->selectMultipleCategoriesExample = $this->postsOptions['gogodigital-example-select-multiple-category'] ?? [];

		/** Set Users Examples values */
		$this->selectUserRolesExample = $this->usersOptions['gogodigital-example-select-user-roles'] ?? '';
		$this->selectMultipleUserRolesExample = $this->usersOptions['gogodigital-example-select-multiple-user-roles'] ?? [];

		/** Register Settings */
		add_action( 'admin_init', array($this,'gogodigital_example_register_settings') );
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
	        array($this,'gogodigital_example_settings_sanitize')
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
            'gogodigital-example-textarea',
            __( 'Example Text Area', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_textarea_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

        add_settings_field(
            'gogodigital-example-editor',
            __( 'Example Editor', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_editor_callback'),
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

        add_settings_field(
            'gogodigital-example-toggleswitch',
            __( 'Toggle Switch', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_toggleswitch_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

        add_settings_field(
            'gogodigital-example-media',
            __( 'Example Media', 'gogodigital-example' ),
            array($this,'gogodigital_example_settings_media_callback'),
            'gogodigital_example_settings_options',
            'gogodigital_example_settings_section'
        );

		/**
		 * Register Post Fields Options
		 */
		register_setting(
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_options',
			array($this,'gogodigital_example_post_fields_sanitize')
		);

		add_settings_section(
			'gogodigital_example_post_fields_section',
			'',
			'',
			'gogodigital_example_post_fields_options'
		);

		add_settings_field(
			'gogodigital-example-select-pages',
			__( 'Pages Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_post_fields_select_pages_callback'),
			'gogodigital_example_post_fields_options',
			'gogodigital_example_post_fields_section'
		);

		add_settings_field(
			'gogodigital-example-select-multiple-pages',
			__( 'Pages Multiple Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_post_fields_select_multiple_pages_callback'),
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

		/**
		 * Register Users Fields Options
		 */
		register_setting(
			'gogodigital_example_user_roles_options',
			'gogodigital_example_user_roles_options',
			array($this,'gogodigital_example_user_roles_sanitize')
		);

		add_settings_section(
			'gogodigital_example_user_roles_section',
			'',
			'',
			'gogodigital_example_user_roles_options'
		);

		add_settings_field(
			'gogodigital-example-select-user-roles',
			__( 'User Roles Select', 'gogodigital-example' ),
			array($this,'gogodigital_example_users_roles_select_callback'),
			'gogodigital_example_user_roles_options',
			'gogodigital_example_user_roles_section'
		);

		add_settings_field(
			'gogodigital-example-select-multiple-user-roles',
			__( 'User Roles Select Multiple', 'gogodigital-example' ),
			array($this,'gogodigital_example_users_roles_select_multiple_callback'),
			'gogodigital_example_user_roles_options',
			'gogodigital_example_user_roles_section'
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
     * TextArea Callback
     */
    public function gogodigital_example_settings_textarea_callback()
    {
        echo $this->widgetClass::getTextAreaWidget(
            'gogodigital_example_settings_options[gogodigital-example-textarea]',
            $this->textAreaExample,
            __( 'Example Text Area Description', 'gogodigital-example' )
        );
    }

    /**
     * TextArea Callback
     */
    public function gogodigital_example_settings_editor_callback()
    {
        $this->widgetClass::getEditorWidget(
            'gogodigital_example_settings_options[gogodigital-example-editor]',
            $this->editorExample,
            __( 'Example Editor Description', 'gogodigital-example' )
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
	            __( 'Radio Value 1', 'gogodigital-example' ) => 'radiovalue1',
	            __( 'Radio Value 2', 'gogodigital-example' ) => 'radiovalue2',
	            __( 'Radio Value 3', 'gogodigital-example' ) => 'radiovalue3'
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
                __( 'Select Value 1', 'gogodigital-example' ) => 'selectvalue1',
                __( 'Select Value 2', 'gogodigital-example' ) => 'selectvalue2',
                __( 'Select Value 3', 'gogodigital-example' ) => 'selectvalue3'
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
     * ToggleSwitch Callback
     */
    public function gogodigital_example_settings_toggleswitch_callback()
    {
        echo $this->widgetClass::getToggleSwitchWidget(
            'gogodigital_example_settings_options[gogodigital-example-toggleswitch]',
            $this->toggleSwitchExample,
            '',
            __( 'Example Toggle Switch Description', 'gogodigital-example' )
        );
    }

    /**
     * Media Callback
     */
    public function gogodigital_example_settings_media_callback()
    {
        echo $this->widgetClass::getMediaInput(
            'gogodigital_example_settings_options[gogodigital-example-media]',
            'gogodigital-example-media',
            $this->mediaExample
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
			$output['gogodigital-example-input'] = sanitize_text_field( $input['gogodigital-example-input'] );
		}

		if( isset( $input['gogodigital-example-textarea'] ) ) {
			$output['gogodigital-example-textarea'] = sanitize_textarea_field( $input['gogodigital-example-textarea'] );
		}

		if( isset( $input['gogodigital-example-editor'] ) ) {
			$output['gogodigital-example-editor'] = $this->widgetClass->sanitize_editor_field( $input['gogodigital-example-textarea'] );
		}

		if( isset( $input['gogodigital-example-select'] ) ) {
			$output['gogodigital-example-select'] = sanitize_text_field( $input['gogodigital-example-select'] );
		}

		if( isset( $input['gogodigital-example-radio'] ) ) {
			$output['gogodigital-example-radio'] = sanitize_text_field( $input['gogodigital-example-radio'] );
		}

		if( isset( $input['gogodigital-example-checkbox'] ) ) {
			$output['gogodigital-example-checkbox'] = sanitize_text_field( $input['gogodigital-example-checkbox'] );
		}

		if( isset( $input['gogodigital-example-toggleswitch'] ) ) {
			$output['gogodigital-example-toggleswitch'] = sanitize_text_field( $input['gogodigital-example-toggleswitch'] );
		}

		if( isset( $input['gogodigital-example-media'] ) ) {
			$output['gogodigital-example-media'] = sanitize_text_field( $input['gogodigital-example-media'] );
		}

		return $output;
	}

	/**
	 * Select Pages Callback
	 */
	public function gogodigital_example_post_fields_select_pages_callback()
	{
		$this->widgetClass::getSelectPagesWidget(
			'gogodigital_example_post_fields_options[gogodigital-example-select-pages]',
			$this->selectPagesExample
		);
	}

	/**
	 * Select Multiple Pages Callback
	 */
	public function gogodigital_example_post_fields_select_multiple_pages_callback()
	{
		$this->widgetClass::getSelectMultiplePagesWidget(
			'gogodigital_example_post_fields_options[gogodigital-example-select-multiple-pages]',
			$this->selectMultiplePagesExample
		);
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
        $this->widgetClass::getSelectMultipleTypesWidget(
            'gogodigital_example_post_fields_options[gogodigital-example-select-multiple-post-type]',
            $this->selectMultiplePostTypesExample
        );
    }

	/**
	 * Simple Inputs Sanitize
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function gogodigital_example_post_fields_sanitize($input)
	{
		$output = array();

		if( isset( $input['gogodigital-example-select-pages'] ) ) {
			$output['gogodigital-example-select-pages'] = sanitize_text_field( $input['gogodigital-example-select-pages'] );
		}

		if( isset( $input['gogodigital-example-select-multiple-pages'] ) ) {
			$output['gogodigital-example-select-multiple-pages'] = $this->widgetClass->recursive_sanitize_text_field( $input['gogodigital-example-select-multiple-pages'] );
		}

		if( isset( $input['gogodigital-example-select-category'] ) ) {
			$output['gogodigital-example-select-category'] = sanitize_text_field( $input['gogodigital-example-select-category'] );
		}

		if( isset( $input['gogodigital-example-select-multiple-category'] ) ) {
			$output['gogodigital-example-select-multiple-category'] = $this->widgetClass->recursive_sanitize_text_field( $input['gogodigital-example-select-multiple-category'] );
		}

		if( isset( $input['gogodigital-example-select-post-type'] ) ) {
			$output['gogodigital-example-select-post-type'] = sanitize_text_field( $input['gogodigital-example-select-post-type'] );
		}

		if( isset( $input['gogodigital-example-select-multiple-post-type'] ) ) {
			$output['gogodigital-example-select-multiple-post-type'] = $this->widgetClass->recursive_sanitize_text_field( $input['gogodigital-example-select-multiple-post-type'] );
		}

		return $output;
	}

    /**
     * Select Multiple PostTypes Callback
     */
    public function gogodigital_example_users_roles_select_callback()
    {
        echo $this->widgetClass::getSelectUserRoles(
            'gogodigital_example_user_roles_options[gogodigital-example-select-user-roles]',
            $this->selectUserRolesExample
        );
    }

    /**
     * Select Multiple PostTypes Callback
     */
    public function gogodigital_example_users_roles_select_multiple_callback()
    {
        echo $this->widgetClass::getSelectMultipleUserRoles(
            'gogodigital_example_user_roles_options[gogodigital-example-select-multiple-user-roles]',
            $this->selectMultipleUserRolesExample
        );
    }

	/**
	 * Post Fields Sanitize
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function gogodigital_example_user_roles_sanitize($input)
	{
		$output = array();

		if( isset( $input['gogodigital-example-select-user-roles'] ) ) {
			$output['gogodigital-example-select-user-roles'] = sanitize_text_field( $input['gogodigital-example-select-user-roles'] );
		}

		if( isset( $input['gogodigital-example-select-multiple-user-roles'] ) ) {
			$output['gogodigital-example-select-multiple-user-roles'] = $this->widgetClass->recursive_sanitize_text_field( $input['gogodigital-example-select-multiple-user-roles'] );
		}

		return $output;
	}

	/**
	 * Create Plugin Admin Page
	 */
	public function create_admin_page()
	{
		$active_tab = isset($_GET['tab']) && esc_html($_GET['tab']) ? esc_html($_GET['tab']) : 'inputs';
	?>

        <style>
            .wp-core-ui select, input {
                padding-left: 8px!important;
            }
            .wp-core-ui .button-primary {
                padding: 2px 10px!important;
            }
            .form-table tr {
                border-bottom: 1px solid #f3f3f3;
            }
            .form-table th {
                line-height: 2;
            }
            .form-table td {
                padding: 8px;
                line-height: 1;
            }
            .nav-tab-active {
                border-bottom: 1px solid #f1f1f1;
                background: #fff;
                color: #000;
            }
            pre {
                background-color: #F1F1F1;
                border: 1px solid transparent;
                border-radius: 4px;
                margin-right: 50px;
                padding: 15px 25px;
            }
            .toggle {
                --width: 80px;
                --height: calc(var(--width) / 3);

                position: relative;
                display: inline-block;
                width: var(--width);
                height: var(--height);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
                border-radius: var(--height);
                cursor: pointer;
            }
            .toggle input {
                display: none;
            }
            .toggle .slider {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border-radius: var(--height);
                background-color: #ccc;
                transition: all 0.4s ease-in-out;
            }
            .toggle .slider::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: calc(var(--height));
                height: calc(var(--height));
                border-radius: calc(var(--height) / 2);
                background-color: #fff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
                transition: all 0.4s ease-in-out;
            }
            .toggle input:checked + .slider {
                background-color: #2196F3;
            }
            .toggle input:checked + .slider::before {
                transform: translateX(calc(var(--width) - var(--height)));
            }
            .toggle .labels::after {
                content: attr(data-off);
                font-size: 14px;
                position: absolute;
                right: 25%;
                top: 3px;
                color: #4d4d4d;
                opacity: 1;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
                transition: all 0.4s ease-in-out;
            }
            .toggle .labels::before {
                content: attr(data-on);
                position: absolute;
                font-size: 14px;
                left: 25%;
                top: 3px;
                color: #ffffff;
                opacity: 0;
                text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
                transition: all 0.4s ease-in-out;
            }
            .toggle input:checked~.labels::after {
                opacity: 0;
            }
            .toggle input:checked~.labels::before {
                opacity: 1;
            }
        </style>

		<div class="wrap" style="overflow: hidden;">

			<div>
                <h1><?php echo $this->examplePageTitle ?></h1>
                <p><?php echo $this->exampleDescription ?></p>
			</div>

            <div class="settings-errors">
	            <?php settings_errors(); ?>
            </div>

            <h2 class="nav-tab-wrapper">
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=inputs" class="nav-tab <?php echo $active_tab === 'inputs' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'Simple Fields', 'gogodigital-example' ) ?>
                </a>
                <a href="?page=<?php echo $this->exampleMenuSlug ?>&tab=posts" class="nav-tab <?php echo $active_tab === 'posts' ? 'nav-tab-active' : ''; ?>">
                    <?php echo __( 'Post/Page Fields', 'gogodigital-example' ) ?>
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

			<form class="form-table" method="post" action="options.php" style="background: #FFF; padding: 10px 25px;">

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

                <?php elseif($active_tab === 'users'): ?>

	                <?php
                        settings_fields( 'gogodigital_example_user_roles_options' );
                        do_settings_sections( 'gogodigital_example_user_roles_options' );
                    ?>

                <?php elseif($active_tab === 'woocommerce'): ?>



                <?php elseif($active_tab === 'shortcode'): ?>

                    <h3>Wordpress <?php echo __( 'Shortcode', 'gogodigital-example' )?></h3>

                    <pre style="padding: 16px 10px; overflow: auto; line-height: 1.45; background-color: #f6f8fa; border-radius: 3px;">[helloworld]</pre>

                    <h3>PHP <?php echo __( 'Shortcode', 'gogodigital-example' )?></h3>

                    <pre style="padding: 16px 10px; overflow: auto; line-height: 1.45; background-color: #f6f8fa; border-radius: 3px;">echo do_shortcode('[helloworld]');</pre>

                <?php elseif($active_tab === 'about'): ?>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

                <?php endif ?>

                <?php submit_button( __( 'Save', 'gogodigital-example' ) ) ?>

			</form>

			<div style="clear: both"></div>

		</div>

		<?php
	}
}
