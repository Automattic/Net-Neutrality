<?php

/*
 * Plugin Name: Net Neutrality by WordPress.com
 * Description: Slow your site down to fight for net neutrality.
 * Author: Automattic
 * Version: 1.0.1
 * Author URI: http://wordpress.com
 * License: GPL2+
 * Text Domain: net-neutrality-wpcom
 */


// TODO: Better attribution
// Based off the Net_Neutrality plugin by DLLH

class Net_Neutrality {

	public $defaults = array( 'enabled' => false );

	/**
	 * Singleton
	 */
	static function init() {

		static $instance = false;

		if ( $instance )
			return $instance;

		$instance = new Net_Neutrality;

		return $instance;
	}

	function __construct() {

		add_action( 'wp_footer', array( $this, 'ribbon' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		// TODO: Probably load this in the header to minimize flashing content?
		add_action( 'wp_footer', array( $this, 'enqueue_style' ), 11 );
	}

	function admin_menu() {
		$this->screen_id = add_options_page(
			'Fight for Net Neutrality',
			'Fight for Net Neutrality',
			'manage_options',
			'net-neutrality',
			array( $this, 'options' )
		);
	}

	function get_option( $key ) {
		if ( ! isset( $this->defaults[ $key ] ) ) {
			return;
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

		if ( 'on' != $input['enabled'] ) {
			$input['enabled'] = 'off';
		}

		return $input;
	}

	function admin_init() {
		wp_register_style( 'net-neutrality', plugins_url( 'net-neutrality/net-neutrality.css', __FILE__ ) );
		register_setting( 'net_neutrality_options', 'net_neutrality_options', array( $this, 'validate' ) );
	}

	function show_ribbon() {

		if ( time() > strtotime( '2017-07-12 23:59:59' ) ) {
			return;
		}

		return 'on' == $this->get_option( 'enabled' );
	}

	function enqueue_style() {
		if ( ! $this->show_ribbon() ) {
			return;
		}

		$yep_still_loading = wp_kses(
			esc_html__( 'Yep... <em>still</em> loading...', 'net-neutrality-wpcom' ),
			array( 'em' => array() )
		);

		$will_happen_string = wp_kses(
			esc_html__( 'This is what will happen without Net Neutrality. <br><button id="net-neutrality-stop">Make it stop!</button>', 'net-neutrality-wpcom' ),
			array( 'br' => array(), 'strong' => array() )
		);

		wp_enqueue_style( 'net-neutrality', plugins_url( 'net-neutrality.css', __FILE__ ), array(), '20140904' );
		wp_register_script( 'net-neutrality-js', plugins_url( 'net-neutrality.js', __FILE__ ), array( 'jquery' ), '20140904' );
		wp_localize_script( 'net-neutrality-js', 'netNeutrality', array(
			'strings' => array(
				'loading'         => esc_html__( 'Loading...', 'net-neutrality-wpcom' ),
				'stillLoading'    => esc_html__( 'Still loading...', 'net-neutrality-wpcom' ),
				'yepStillLoading' => $yep_still_loading,
				'willHappen'      => $will_happen_string,
			)
		) );
		wp_enqueue_script( 'net-neutrality-js' );
	}

	function ribbon() {
		if ( ! $this->show_ribbon() ) {
			return;
		}

		?>
		<div id="net-neutrality-overlay" style="display: none;">
			<div id="net-neutality-overlay-content">
				<p><?php esc_html_e( "Isn't this frustrating?", 'net-neutrality-wpcom' ); ?></p>
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
