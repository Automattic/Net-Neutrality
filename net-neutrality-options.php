<div class="card">
	<?php
		// TODO: This is deprecated. Replace with get_screen_icon();
		//screen_icon();
	?>
	<h2>
		<?php esc_html_e( 'Fight for Net Neutrality', 'net-neutrality-wpcom' );?>
	</h2>

	<form method="post" action="options.php">
		<?php
			settings_fields( 'net_neutrality_options' );
		?>

		<p>
			<?php echo
				sprintf(
					wp_kses(
						__(
							'The FCC wants to repeal Net Neutrality rules. Without net neutrality, big cable and telecom companies will be able to divide the Internet into fast and slow lanes. What would the Internet look like without Net Neutrality? Find out by enabling this banner on your site: it shows your support for Net Neutrality by displaying a message on the bottom of your site, and "slowing down" some of your posts. <a target="_blank" href="%s">Learn more about Net Neutrality</a>',
							'net-neutrality-wpcom'
						),
						array( 'a' => array( 'href' => array() ) )
					),
					'https://en.blog.wordpress.com/2017/07/11/join-us-in-the-fight-for-net-neutrality/'
				);
			?>
		</p>

		<p>
			<img src="<?php echo plugins_url( 'screenshot.png', __FILE__ ) ?>" width="188" height="145" alt="Screenshot" />
		</p>

		<input id="net_neutrality_options_enabled" type="checkbox" name="net_neutrality_options[enabled]" <?php checked( 'on', $this->get_option( 'enabled' ) ); ?>/>
		<label for="net_neutrality_options_enabled">
			<?php esc_html_e( 'Protest Enabled?', 'net-neutrality-wpcom' ); ?>
		</label>
		<?php submit_button(); ?>
	</form>

</div>
