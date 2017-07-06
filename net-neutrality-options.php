<div class="wrap">
	<?php
		// TODO: This is deprecated. Replace with get_screen_icon();
		//screen_icon();
	?>
	<h2>Fight for Net Neutrality</h2>

	<form method="post" action="options.php">
		<?php
			settings_fields( 'net_neutrality_options' );
		?>

		<p>The FCC is proposing rules that would allow big cable and telecom companies to divide the internet into fast and slow lanes. What would the Internet look like if these rules take effect? Find out by enabling this banner on your site: it shows your support for real net neutrality rules by displaying a message on the bottom of your site, and "slowing down" some of your posts.</p>

		<p><img src="<?php echo plugins_url( 'screenshot.png', __FILE__ ) ?>" width="188" height="145" alt="Screenshot" /></p>

		<input id="net_neutrality_options_enabled" type="checkbox" name="net_neutrality_options[enabled]" <?php checked( 'on', $this->get_option( 'enabled' ) ); ?>/> <label for="net_neutrality_options_enabled">Protest Enabled?</label>
		<?php submit_button(); ?>
	</form>

</div>