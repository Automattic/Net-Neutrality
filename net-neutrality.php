<?php

/*
 * Plugin Name: Net Neutrality by WordPress.com
 * Description: Slow your site down to fight for net neutrality.
 * Author:      Automattic
 * Version:     0.0.1
 * Author URI:  http://wordpress.com
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: net-neutrality-wpcom
 */

defined( 'ABSPATH' ) or die( 'No direct access here.' );

// TODO: Better attribution
// Based off the Net_Neutrality plugin by DLLH

class Net_Neutrality {

	public $defaults = array( 'enabled' => false );

	/**
	 * Singleton
	 */
	static function init() {

		static $instance = false;

		if ( $instance ) {
			return $instance;
		}

		$instance = new Net_Neutrality;

		return $instance;
	}

	function __construct() {

		// TODO: Settings for admins only?
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_footer', array( $this, 'ribbon' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
	}

	function get_version() {

		$file_data = get_file_data( __FILE__, array( 'v' => 'Version' ) );

		return $file_data['v'];
	}

	function admin_menu() {
		$this->screen_id = add_options_page(
			_x( 'Fight for Net Neutrality', 'page title', 'net-neutrality-wpcom' ),
			_x( 'Fight for Net Neutrality', 'menu title', 'net-neutrality-wpcom' ),
			'manage_options',
			'net-neutrality',
			array( $this, 'options' )
		);
	}

	function get_option( $key ) {
		if ( ! isset( $this->defaults[ $key ] ) ) {
			return false;
		}

		$options = get_option( 'net_neutrality_options' );

		return empty( $options[ $key ] ) ? $this->defaults[ $key ] : $options[ $key ];
	}

	function options() {
		require_once( dirname( __FILE__ ) . '/net-neutrality-options.php' );
	}

	function validate( $input ) {
		if ( ! is_array( $input ) ) {
			return array();
		}

		$input = array_intersect_key( $input, $this->defaults );
		$input = wp_parse_args( $input, $this->defaults );

		if ( 'on' !== $input['enabled'] ) {
			$input['enabled'] = 'off';
		}

		return $input;
	}

	function admin_init() {
		register_setting( 'net_neutrality_options', 'net_neutrality_options', array( $this, 'validate' ) );
	}

	function show_ribbon() {

		if ( time() > strtotime( '2017-07-12 23:59:59' ) ) {
			return false;
		}

		return 'on' === $this->get_option( 'enabled', false );
	}

	function enqueue_style() {

		if ( ! $this->show_ribbon() ) {
			return false;
		}

		$v = $this->get_version();

		$yep_still_loading = wp_kses(
			/* translators: use only <em>, other HTML tags will be stripped */
			esc_html__( 'Yep&nbsp;… <em>still</em> loading&nbsp;…', 'net-neutrality-wpcom' ),
			array( 'em' => array() )
		);

		$will_happen_string = wp_kses(
			/* translators: use only <br> and <button id>, other HTML tags will be stripped */
			esc_html__( 'This is what will happen without Net Neutrality. <br><button id="net-neutrality-stop">Make it stop!</button>', 'net-neutrality-wpcom' ),
			array( 'br' => array(), 'button' => array( 'id' => array() ) )
		);

		wp_enqueue_style( 'net-neutrality', plugins_url( 'net-neutrality.css', __FILE__ ), array(), $v );
		wp_register_script( 'net-neutrality-js', plugins_url( 'net-neutrality.js', __FILE__ ), array( 'jquery' ), $v, true );
		wp_localize_script( 'net-neutrality-js', 'netNeutrality', array(
			'strings' => array(
				'loading'         => esc_html__( 'Loading&nbsp;…', 'net-neutrality-wpcom' ),
				'stillLoading'    => esc_html__( 'Still loading&nbsp;…', 'net-neutrality-wpcom' ),
				'yepStillLoading' => $yep_still_loading,
				'willHappen'      => $will_happen_string,
			)
		) );
		wp_enqueue_script( 'net-neutrality-js' );
	}

	function ribbon() {

		if ( ! $this->show_ribbon() ) {
			return false;
		}

		?>
		<div id="net-neutrality-overlay" style="display: none;">
			<div id="net-neutality-overlay-content">
				<p><?php esc_html_e( "Isn’t this frustrating?", 'net-neutrality-wpcom' ); ?></p>
				<p><?php esc_html_e( 'Help keep the internet free of slow lanes by supporting net neutrality.', 'net-neutrality-wpcom' ); ?></p>
				<p>
					<a id="net-neutrality-overlay-action" href="http://battleforthenet.com" target="_blank">
						<?php esc_html_e( 'Learn more and take&nbsp;action', 'net-neutrality-wpcom' ); ?>
					</a>
					<br />
					<button id="net-neutrality-overlay-close">
						<?php esc_html_e( 'Close', 'net-neutrality-wpcom' ); ?>
					</button>
				</p>
			</div>
		</div>

		<div id="net-neutrality-ribbon" style="display: none;">
			<a href="http://battleforthenet.com" target="_blank">
				<?php esc_html_e( 'Learn more and take action to protect Net Neutrality', 'net-neutrality-wpcom' ); ?>
			</a>
		</div>

		<?php
	}

}

add_action( 'init', array( 'Net_Neutrality', 'init' ) );
