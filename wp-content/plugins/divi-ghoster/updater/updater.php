<?php
/* This file contains code from the Software Licensing addon by Easy Digital Downloads - GPLv2.0 or higher */
if (!defined('ABSPATH')) exit;

define( 'AGS_GHOSTER_VERSION', '2.1.7' );
define( 'AGS_GHOSTER_FILE', realpath(dirname(__FILE__).'/../divi-ghoster.php') );
define( 'AGS_GHOSTER_STORE_URL', 'https://aspengrovestudios.com/' );
define( 'AGS_GHOSTER_ITEM_NAME', 'Divi Ghoster' ); // Needs to exactly match the download name in EDD
define( 'AGS_GHOSTER_PLUGIN_PAGE', 'admin.php?page=divi_ghoster' );

if( !class_exists( 'AGS_GHOSTER_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

// Load translations
load_plugin_textdomain('aspengrove-updater', false, plugin_basename(dirname(__FILE__).'/lang'));

function AGS_GHOSTER_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'AGS_GHOSTER_license_key' ) );

	// setup the updater
	new AGS_GHOSTER_Plugin_Updater( AGS_GHOSTER_STORE_URL, AGS_GHOSTER_FILE, array(
			'version' 	=> AGS_GHOSTER_VERSION, // current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => AGS_GHOSTER_ITEM_NAME, 	// name of this plugin
			'author' 	=> 'Aspen Grove Studios',  // author of this plugin
			'beta'		=> false
		)
	);

}
add_action( 'admin_init', 'AGS_GHOSTER_updater', 0 );


function AGS_GHOSTER_has_license_key() {
	if (isset($_POST['AGS_GHOSTER_license_key_deactivate'])) {
		require_once(dirname(__FILE__).'/license-key-activation.php');
		AGS_GHOSTER_deactivate_license();
	}
	return (get_option('AGS_GHOSTER_license_status') === 'valid');
}

function AGS_GHOSTER_activate_page() {
	$license = get_option( 'AGS_GHOSTER_license_key' );
	$status  = get_option( 'AGS_GHOSTER_license_status' );
	?>
		<div class="wrap" id="AGS_GHOSTER_license_key_activation_page">
			<form method="post" action="options.php" id="AGS_GHOSTER_license_form">
				<h2>
					<a href="https://aspengrovestudios.com/" target="_blank">
						<img src="<?php echo(plugins_url('ags-logo.png', __FILE__)); ?>" alt="Aspen Grove Studios" />
					</a>
				</h2>
				
				<div id="AGS_GHOSTER_license_form_body">
					<h3>
						<?php echo(esc_html(AGS_GHOSTER_ITEM_NAME)); ?>
						<small>v<?php echo(AGS_GHOSTER_VERSION); ?></small>
					</h3>
					
					<p>
						Thank you for purchasing <?php echo(htmlspecialchars(AGS_GHOSTER_ITEM_NAME)); ?>!<br />
						Please enter your license key below.
					</p>
					
					<?php settings_fields('AGS_GHOSTER_license'); ?>
					<?php if( false !== $license ) {
						// Need to activate license here, only if submitted
						require_once(dirname(__FILE__).'/license-key-activation.php');
						AGS_GHOSTER_activate_license();
					} ?>
					
					<label>
						<span><?php _e('License Key:', 'aspengrove-updater'); ?></span>
						<input name="AGS_GHOSTER_license_key" type="text" class="regular-text"<?php if (!empty($_GET['license_key'])) { ?> value="<?php echo(esc_attr($_GET['license_key'])); ?>"<?php } else if (!empty($license)) { ?> value="<?php echo(esc_attr($license)); ?>"<?php } ?> />
					</label>
					
					<?php
						if (isset($_GET['sl_activation']) && $_GET['sl_activation'] == 'false') {
							echo('<p id="AGS_GHOSTER_license_form_error">'.(empty($_GET['sl_message']) ? esc_html__('An unknown error has occurred. Please try again.', 'aspengrove-updater') : esc_html($_GET['sl_message'])).'</p>');
						}
						
						submit_button('Continue');
					?>
				</div>
			</form>
		</div>
	<?php
}

function AGS_GHOSTER_license_key_box() {
	$status  = get_option( 'AGS_GHOSTER_license_status' );
	?>
		<div id="AGS_GHOSTER_license_key_box">
			<form method="post" id="AGS_GHOSTER_license_form">
				<h2>
					<a href="https://aspengrovestudios.com/" target="_blank">
						<img src="<?php echo(plugins_url('ags-logo.png', __FILE__)); ?>" alt="Aspen Grove Studios" />
					</a>
				</h2>
				
				<div id="AGS_GHOSTER_license_form_body">
					<h3>
						<?php echo(esc_html(AGS_GHOSTER_ITEM_NAME)); ?>
						<small>v<?php echo(AGS_GHOSTER_VERSION); ?></small>
					</h3>
					
					<label>
						<span><?php _e('License Key:', 'aspengrove-updater'); ?></span>
						<input type="text" readonly="readonly" value="<?php echo(esc_html(get_option('AGS_GHOSTER_license_key'))); ?>" />
					</label>
					<?php wp_nonce_field( 'AGS_GHOSTER_license_key_deactivate', 'AGS_GHOSTER_license_key_deactivate' ); ?>
					<?php
						if (isset($_GET['sl_activation']) && $_GET['sl_activation'] == 'false') {
							echo('<p id="AGS_GHOSTER_license_form_error">'.(empty($_GET['sl_message']) ? esc_html__('An unknown error has occurred. Please try again.', 'aspengrove-updater') : esc_html($_GET['sl_message'])).'</p>');
						}
						
						submit_button('Deactivate License Key', '');
					?>
				</div>
			</form>
		</div>
	<?php
}

function AGS_GHOSTER_register_option() {
	// creates our settings in the options table
	register_setting('AGS_GHOSTER_license', 'AGS_GHOSTER_license_key', 'AGS_GHOSTER_sanitize_license' );
}
add_action('admin_init', 'AGS_GHOSTER_register_option');

function AGS_GHOSTER_sanitize_license( $new ) {
	$old = get_option( 'AGS_GHOSTER_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'AGS_GHOSTER_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}