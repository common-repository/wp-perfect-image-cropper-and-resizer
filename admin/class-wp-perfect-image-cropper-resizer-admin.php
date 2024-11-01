<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://expresstech.io/
 * @since      1.0.0
 *
 * @package    Wp_Perfect_Image_Cropper_Resizer
 * @subpackage Wp_Perfect_Image_Cropper_Resizer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Perfect_Image_Cropper_Resizer
 * @subpackage Wp_Perfect_Image_Cropper_Resizer/admin
 * @author     Express Tech <hi@expresstech.io>
 */
class Wp_Perfect_Image_Cropper_Resizer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'etpicr';

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Perfect_Image_Cropper_Resizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Perfect_Image_Cropper_Resizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-perfect-image-cropper-resizer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Perfect_Image_Cropper_Resizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Perfect_Image_Cropper_Resizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-perfect-image-cropper-resizer-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Perfect Image Cropper Settings', 'etpicr' ),
			__( 'Perfect Image Cropper', 'etpicr' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/wp-perfect-image-cropper-resizer-admin-display.php';
	}

	public function register_setting() {
		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'etpicr' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		// add_settings_field(
		// 	$this->option_name . '_position',
		// 	__( 'Text position', 'etpicr' ),
		// 	array( $this, $this->option_name . '_position_cb' ),
		// 	$this->plugin_name,
		// 	$this->option_name . '_general',
		// 	array( 'label_for' => $this->option_name . '_position' )
		// );

		add_settings_field(
			$this->option_name . '_maxwidth',
			__( 'Max Width', 'etpicr' ),
			array( $this, $this->option_name . '_maxwidth_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_maxwidth' )
		);

		add_settings_field(
			$this->option_name . '_maxheight',
			__( 'Max Height', 'etpicr' ),
			array( $this, $this->option_name . '_maxheight_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_maxheight' )
		);

		add_settings_field(
			$this->option_name . '_posttype',
			__( 'Crop Images In', 'etpicr' ),
			array( $this, $this->option_name . '_posttype_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_posttype' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_posttype', array( $this, $this->option_name . '_sanitize_posttype' ) );
		register_setting( $this->plugin_name, $this->option_name . '_maxwidth', 'intval' );
		register_setting( $this->plugin_name, $this->option_name . '_maxheight', 'intval' );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function etpicr_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'outdated-notice' ) . '</p>';
	}

	
	public function etpicr_maxwidth_cb() {
		$val = get_option( $this->option_name . '_maxwidth' );
		echo '<input type="text" name="' . $this->option_name . '_maxwidth' . '" id="' . $this->option_name . '_maxwidth' . '" value="' . $val . '"> '. __( 'px', 'etpicr' );
	}

	public function etpicr_maxheight_cb() {
		$val = get_option( $this->option_name . '_maxheight' );
		echo '<input type="text" name="' . $this->option_name . '_maxheight' . '" id="' . $this->option_name . '_maxheight' . '" value="' . $val . '"> '. __( 'px', 'etpicr' );
	}

	/**
	 * Render the radio input field for position option
	 *
	 * @since  1.0.0
	 */
	public function etpicr_position_cb() {
		$position = get_option( $this->option_name . '_position' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before" <?php checked( $position, 'before' ); ?>>
					<?php _e( 'Before the content', 'etpicr' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" value="after" <?php checked( $position, 'after' ); ?>>
					<?php _e( 'After the content', 'etpicr' ); ?>
				</label>
			</fieldset>
		<?php
	}

	public function etpicr_posttype_cb() { 

		$posttype = get_option( $this->option_name . '_posttype' );
		// echo $posttype;exit;
		?>
		<select name='<?php echo $this->option_name . '_posttype' ?>'>
			<option value='post' <?php selected( $posttype, 'post' ); ?>>Post</option>
			<option value='page' <?php selected( $posttype, 'page' ); ?>>Page</option>
			<option value='product' <?php selected( $posttype, 'product' ); ?>>Product</option>
		</select>

	<?php

	}


	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function etpicr_sanitize_posttype( $posttype ) {
		if ( in_array( $posttype, array( 'post', 'page' , 'product' ), true ) ) {
	        return $posttype;
	    }
	}

}
