<?php

/*

Plugin Name: Divi Ghoster

Plugin URI: https://aspengrovestudios.com/product/divi-ghoster/

Description: White label Divi and Extra with your own brand.

Version: 2.1.7

Author: Aspen Grove Studios

Author URI: http://aspengrovestudios.com/

License: GPL

*/


if (!defined('ABSPATH'))

	die();



require dirname(__FILE__).'/includes/functions.php';
require dirname(__FILE__).'/updater/updater.php';

/*require plugin_dir_path( __FILE__ ) . 'ags-update-checker/ags-update-checker.php';

$MyUpdateChecker = PucFactory::buildUpdateChecker(

'http://aspengrovestudios.com/ags-update-server/?action=get_metadata&slug=divi-ghoster',

__FILE__, 

'divi-ghoster' 

);*/



// Disable Ultimate Ghoster on plugin activation/deactivation

register_activation_hook(__FILE__, 'agsdg_ultimate_ghoster_disable');

register_deactivation_hook(__FILE__, 'agsdg_ultimate_ghoster_disable');



/*

function agsdg_activate() {

	$settings = get_option('agsdg_settings');

	if ($settings == false) {

		$settings = agsdg_initialize_settings();

	}

	if ($settings['ultimate_ghoster'] == 'yes') {

		global $agsdg_supported_themes;

		$currentTheme = wp_get_theme()->get_template();

		if (!in_array($currentTheme, $agsdg_supported_themes) || get_option('permalink_structure', '') == '') {

			// If Ultimate Ghoster is enabled and the current theme is not supported or permalinks are set to Plain, disable Ultimate Ghoster

			agsdg_ultimate_ghoster_disable($settings);
			

		} else {

			// Flush rewrite rules if Ultimate Ghoster is enabled

			agsdg_rewrite_rule();

			flush_rewrite_rules();
			
			// Make symlink - will fail silently if it already exists
			$themesRoot = get_theme_root();
			@symlink($themesRoot.'/'.$currentTheme, $themesRoot.'/'.$settings['theme_slug']);
			
			// Add fallback - will fail silently if it already exists
			agsdg_fallback();

		}

	}

}

register_activation_hook( __FILE__, 'agsdg_activate' );

*/



function admin_enqueue_scripts_dg($hook)

{

	if ($hook == 'toplevel_page_divi_ghoster') {

		wp_enqueue_media();

		wp_enqueue_script('agsdg_admin_page', plugins_url('js/admin-page.js', __FILE__), array('jquery'), '1.1', true);

		wp_enqueue_script('agsdg_jq_checkbox', plugins_url('js/jquery.checkbox.min.js', __FILE__), array('jquery'), false, true);

		wp_enqueue_style('agsdg_jq_checkbox', plugins_url('css/jquery.checkbox.css', __FILE__));

	}

    wp_enqueue_style('dg_admin', plugins_url('css/admin.css', __FILE__));

}

add_action('admin_enqueue_scripts', 'admin_enqueue_scripts_dg');



function load_wp_login_style_dg()

{

    wp_enqueue_style('wp_login_css_dg', plugins_url('/css/custom-login.css', __FILE__), '', '1.1', '');

}

add_action('login_head', 'load_wp_login_style_dg');



function agsdg_branding_name_render($args) {

    $options = get_option('agsdg_settings');

    $val     = $options['branding_name'];

?><input type="text" size="45" name="agsdg_settings[branding_name]" value="<?php echo htmlspecialchars($val); ?>" class="agsdg_settings_field"><?php

}

function agsdg_branding_name_settings_section_callback() { echo '<span class="agsdg_settings_section_heading">'.__('Branding Name', 'ags-ghoster').'</span>'; }

function agsdg_branding_image_render() {

    $options = get_option('agsdg_settings');

    $val     = $options['branding_image'];

?><input id="image-url" type="text" name="agsdg_settings[branding_image]" size="45" value="<?php echo htmlspecialchars($val); ?>" class="agsdg_settings_field" />

  <strong style='font-weight:600;'>&nbsp;Or&nbsp;</strong>

  <input id="upload-button" type="button" class="button dg-button" value="Upload Image" />

<?php

}

function agsdg_branding_image_settings_section_callback() { echo '<span class="agsdg_settings_section_heading">'.__('Branding Image', 'ags-ghoster').'</span>'; }



function agsdg_theme_slug_render() {

    $options = get_option('agsdg_settings');

    $val     = $options['theme_slug'];

?><input type="text" size="45" name="agsdg_settings[theme_slug]" value="<?php echo htmlspecialchars($val); ?>" class="agsdg_settings_field">

<?php

}

function agsdg_theme_slug_settings_section_callback() { echo '<span class="agsdg_settings_section_heading">'.__('Theme URL Slug (see documentation)', 'ags-ghoster').'</span>'; }



function agsdg_ultimate_ghoster_render() {

    $options = get_option('agsdg_settings');

    $val     = $options['ultimate_ghoster'];

?><input name="agsdg_settings[ultimate_ghoster]" type="checkbox"<?php echo($options['ultimate_ghoster'] == 'yes' ? ' checked="checked"' : ''); ?>>

<?php

}

function agsdg_ultimate_ghoster_settings_section_callback() { echo '<span class="agsdg_settings_section_heading">'.__('Ultimate Ghoster', 'ags-ghoster').'</span>'; }



function agsdg_sanitize_settings($settings) {

	global $agsdg_theme, $agsdg_theme_slug;

	$currentSettings = get_option('agsdg_settings');



	// Make sure Branding Name is set

	if (empty($settings['branding_name'])) {

		add_settings_error('branding_name', 'branding_name_empty', __('The Branding Name field may not be empty.', 'ags-ghoster'));

		$settings['branding_name'] = (empty($currentSettings['branding_name']) ? $agsdg_theme : $currentSettings['branding_name']);

	}

	

	// Make sure Theme Slug is set, is not the theme default, and does not contain invalid characters

	if (empty($settings['theme_slug'])) {

		add_settings_error('theme_slug', 'theme_slug_empty', __('The Theme Slug field may not be empty.', 'ags-ghoster'));

		$settings['theme_slug'] = (empty($currentSettings['theme_slug']) ? 'ghost_'.$agsdg_theme_slug : $currentSettings['theme_slug']);

	} else if (strcasecmp($settings['theme_slug'], $agsdg_theme_slug) == 0) {

		add_settings_error('theme_slug', 'theme_slug_empty', __('The Theme Slug must be something other than the default', 'ags-ghoster').' &quot;'.$agsdg_theme_slug.'&quot;.');

		$settings['theme_slug'] = (empty($currentSettings['theme_slug']) ? 'ghost_'.$agsdg_theme_slug : $currentSettings['theme_slug']);

	} else {

		$newSlug = preg_replace('/[^A-Za-z0-9_\-]+/', '', $settings['theme_slug']);

		if ($newSlug != $settings['theme_slug']) {

			add_settings_error('theme_slug', 'theme_slug_invalid_chars', __('The theme slug may only contain letters, numbers, dashes, and underscores.', 'ags-ghoster'));

			$settings['theme_slug'] = $newSlug;

		}

	}

	

	// Handle Ultimate Ghoster setting

	if (!empty($settings['ultimate_ghoster'])) {

		$settings['ultimate_ghoster'] = 'no';
		
		if (get_option('permalink_structure', '') == '') {

			add_settings_error('ultimate_ghoster', 'ultimate_ghoster_plain_permalinks', __('Ultimate Ghoster cannot be enabled while your permalink structure is set to Plain. Please change your permalink structure in Settings &gt; Permalinks.', 'ags-ghoster'));

			
		// Check for existence of the pre_agsdg stylesheet (indicating that Ultimate was previously enabled) and, if found, restore the theme before continuing
		} else if ((!file_exists(get_theme_root().'/'.$agsdg_theme.'/style.pre_agsdg.css') || agsdg_restore_theme_meta()) &&
					agsdg_change_theme_meta($settings['branding_name'], ($currentSettings['ultimate_ghoster'] == 'yes'))
					&& agsdg_change_all_child_themes($settings['branding_name'], ($currentSettings['ultimate_ghoster'] == 'yes'))) {

			$settings['ultimate_ghoster'] = 'yes';

			update_option('adsdg_ultimate_theme', $agsdg_theme);

			add_settings_error('ultimate_ghoster', 'ultimate_ghoster_enabled', __('Settings saved; Ultimate Ghoster is enabled.', 'ags-ghoster'), 'updated');

		} else {

			add_settings_error('ultimate_ghoster', 'ultimate_ghoster_enable_error', __('An error occurred while enabling Ultimate Ghoster; please try again. If the problem persists, you may need to re-install your theme.', 'ags-ghoster'));

		}

	}

	

	if (empty($settings['ultimate_ghoster']) || $settings['ultimate_ghoster'] == 'no') {

		$settings['ultimate_ghoster'] = 'no';

		delete_option('adsdg_ultimate_theme');

		

		if ($currentSettings['ultimate_ghoster'] == 'yes') {

			// Restore style.css if Ultimate Ghoster was previously enabled

			if (agsdg_restore_theme_meta()) {

				add_settings_error('ultimate_ghoster', 'ultimate_ghoster_disabled', __('Ultimate Ghoster has been disabled.', 'ags-ghoster'), 'updated');

			} else {

				add_settings_error('ultimate_ghoster', 'ultimate_ghoster_disable_error', __('An error occurred while disabling Ultimate Ghoster. Please try enabling and disabling it again.', 'ags-ghoster'));

			}

			

		}

	}

	

	// Flush rewrite rules if needed

	if (($settings['theme_slug'] != $currentSettings['theme_slug'] || $settings['ultimate_ghoster'] != $currentSettings['ultimate_ghoster']) &&
			($settings['ultimate_ghoster'] == 'yes' || $currentSettings['ultimate_ghoster'] == 'yes')) {
		
		if ($settings['ultimate_ghoster'] == 'yes') {

			agsdg_rewrite_rule($settings['theme_slug']);
			
			if ($currentSettings['ultimate_ghoster'] == 'yes') {
				// Remove old symlink
				agsdg_remove_theme_symlink($currentSettings['theme_slug']);

				

				// Remove old fallback

				agsdg_fallback_remove();
			}
			
			// Make symlink - will fail silently if it already exists
			$themesRoot = get_theme_root();
			
			@symlink($themesRoot.'/'.$agsdg_theme, $themesRoot.'/'.$settings['theme_slug']);
			
			// Implement fallback if needed
			agsdg_fallback($settings['theme_slug']);
			
		} else {
			// Remove fallback
			agsdg_fallback_remove();
		
			// Remove symlink
			agsdg_remove_theme_symlink($currentSettings['theme_slug']);
		}
		

		flush_rewrite_rules();

	}

	

	return $settings;

}



function divi_ghost_options_page()

{

global $agsdg_theme, $agsdg_theme_slug;

?>

<div id="agsdg_main_div">



<?php settings_errors(); ?>





<form action='options.php' method='post'>

	<img id="agsdg_logo" src='<?php echo(plugins_url('logo.png', __FILE__)); ?>' />

<?php

    settings_fields('agsdg_pluginPage');

    do_settings_sections('agsdg_pluginPage');

?>


<em>If you are using a caching plugin, <strong>be sure to clear its cache</strong> after enabling or disabling Ultimate Ghoster!</em><br />

<em>Ultimate Ghoster will not work if the permalink structure is set to Plain in Settings &gt; Permalinks.</em><br />

<em>Enabling Ultimate Ghoster will hide the <?php echo($agsdg_theme); ?> Ghoster plugin. Please copy this URL and save it to disable this feature later: <a href="<?php

    $ghosterUrl = admin_url('admin.php?page=divi_ghoster'); echo($ghosterUrl);

?> "><?php

    echo($ghosterUrl);

?></a></em>

<br/>

<?php if ($agsdg_theme == 'Divi') { ?>

<em>Enabling Ultimate Ghoster will hide &quot;Divi Switch&quot;, &quot;Divi Booster&quot;, and &quot;Aspen Footer Editor&quot; from the Divi menu and the Plugins list. If installed, they can be accessed directly at any time by visiting:

<br />For Divi Switch: <a href="<?php echo admin_url('admin.php?page=divi-switch-settings'); ?> "><?php echo admin_url('admin.php?page=divi-switch-settings'); ?></a>

<br />For Divi Booster: <a href="<?php echo admin_url('admin.php?page=wtfdivi_settings'); ?> "><?php echo admin_url('admin.php?page=wtfdivi_settings'); ?></a>

<br />For Aspen Footer Editor: <a href="<?php echo admin_url('admin.php?page=aspen-footer-editor'); ?> "><?php echo admin_url('admin.php?page=aspen-footer-editor'); ?></a>

</em>

<?php } else if ($agsdg_theme == 'Extra') { ?>

<em>Enabling Ultimate Ghoster will hide &quot;Divi Switch&quot;, &quot;Divi Booster&quot;, and &quot;Aspen Footer Editor&quot; from the Divi menu and the Plugins list. If installed, they can be accessed directly at any time by visiting:

<br />For Divi Switch: <a href="<?php echo admin_url('admin.php?page=divi-switch-settings'); ?> "><?php echo admin_url('admin.php?page=divi-switch-settings'); ?></a>

<br />For Divi Booster: <a href="<?php echo admin_url('admin.php?page=wtfdivi_settings'); ?> "><?php echo admin_url('admin.php?page=wtfdivi_settings'); ?></a>

<br />For Aspen Footer Editor: <a href="<?php echo admin_url('admin.php?page=aspen-footer-editor'); ?> "><?php echo admin_url('admin.php?page=aspen-footer-editor'); ?></a>

</em>

<?php } ?>

<br /><br /><br />

<button id='epanel-save-top' class='save-button button dg-button' name="btnSubmit">Save Changes</button>

<br/><br/>

<hr/>

<br/>

<p class="branding_name">Customize the standard WordPress login page with your own logo, background, and colors with an easy to use interface.</p>

<br/>

<a class="button button-primary" href="<?php echo admin_url('customize.php?et_customizer_option_set=theme'); ?>">Login Customizer</a>

</form>

</div>

<?php AGS_GHOSTER_license_key_box(); ?>

<?php } // end options page ?>