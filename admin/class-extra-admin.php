<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Extra
 * @subpackage Extra/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Extra
 * @subpackage Extra/admin
 * @author     Md Junayed <admin@easeare.com>
 */
class Extra_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// Wp cron schedules https://developer.wordpress.org/reference/hooks/cron_schedules/
		add_filter( 'cron_schedules', [$this,'extra_cron_add_twice_daily'] );
		if ( ! wp_next_scheduled( 'extra_eur_cron' ) ) {
			wp_schedule_event( time(), 'twice_daily', 'extra_eur_cron');
		}
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
		 * defined in Extra_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Extra_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET['page']) && ($_GET['page'] == 'extra' || $_GET['page'] == 'extra-cronjob')){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/extra-admin.css', array(), $this->version, 'all' );
		}
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
		 * defined in Extra_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Extra_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if(isset($_GET['page']) && ($_GET['page'] == 'extra' || $_GET['page'] == 'extra-cronjob')){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/extra-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Menu Register
	 */
	function extra_menu_register(){
		add_submenu_page( 'rednaopdfwpform_pdf_builder','Extra', 'Extra', 'manage_options', 'extra', [$this,'extra_menus_display_callback'] );
	}

	/**
	 * Show notice if pdf builder not exist
	 */
	function subsactivations_admin_noticess(){
		$message = sprintf(
			/* translators: 1: Plugin Name 2: Elementor */
			print_r( '%1$s requires <a href="https://wordpress.org/plugins/pdf-builder-for-wpforms/">%2$s</a> to be installed and activated.', 'extra' ),
			'<strong>' . esc_html__( 'Extra', 'extra' ) . '</strong>',
			'<strong>' . esc_html__( 'PDF Builder', 'extra' ) . '</strong>'
		);
	
		printf( '<div class="notice notice-warning"><p>%1$s</p></div>', $message );
	}

	/**
	 * Menupage display
	 */
	function extra_menus_display_callback(){
		require_once plugin_dir_path( __FILE__ ).'partials/extra-admin-display.php';
	}

	// extra_numar_comanda updatable function (YOU CAN USE THIS FUNCTION ANY WHERE WITH VALUES)
	function extra_numar_comanda($data){
		if(!empty($data)){
			global $wpdb;
			$data_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}extra_v1");

			$numar_comanda = intval($data);
			if($data_id){
				$wpdb->update($wpdb->prefix.'extra_v1', array('numar_comanda' => $numar_comanda), array('ID' => $data_id), array('%f'), array('%d'));
				return true;
			}else{
				$wpdb->insert($wpdb->prefix.'extra_v1', array('numar_comanda' => $numar_comanda), array('%f'));
				return true;
			}

			if(is_wp_error( $wpdb )){
				return false;
			}
		}
	}

	// extra_valoare_tva updatable function (YOU CAN USE THIS FUNCTION ANY WHERE WITH VALUES)
	function extra_valoare_tva($data){
		if(!empty($data)){
			global $wpdb;
			$data_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}extra_v1");

			$valoare_tva = intval($data);
			if($data_id){
				$wpdb->update($wpdb->prefix.'extra_v1', array('valoare_tva' => $valoare_tva), array('ID' => $data_id), array('%f'), array('%d'));
				return true;
			}else{
				$wpdb->insert($wpdb->prefix.'extra_v1', array('valoare_tva' => $valoare_tva), array('%f'));
				return true;
			}

			if(is_wp_error( $wpdb )){
				return false;
			}
		}
	}

	// wp cron schedules
	function extra_cron_add_twice_daily( $schedules ) {
		// Adds once weekly to the existing schedules.
		$schedules['twice_daily'] = array(
            'interval' => 12 * HOUR_IN_SECONDS,
            'display'  => __( 'Twice Daily' ),
        );
		return $schedules;
	}

	/**
	 * Cron job for EUR currency
	 */
	function extra_eur_cron_for_eur(){
		require_once EXTRA_PATH.'includes/bnr.php';
		$bnr = new Bnr();
		$eur = $bnr->getCurrencyValue('EUR');
		global $wpdb;
		$data_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}extra_v1");
	
		if($data_id){
			$wpdb->update($wpdb->prefix.'extra_v1', array('extra_euro' => $eur), array('ID' => $data_id), array('%f'), array('%d'));
		}else{
			$wpdb->insert($wpdb->prefix.'extra_v1', array('extra_euro' => $eur), array('%f'));
		}
		return true;
	}
}
