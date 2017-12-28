<?php
if (!defined('ABSPATH'))
	die();
include_once(ABSPATH . '/wp-admin/includes/plugin.php');

global $agsdg_supported_themes, $agsdg_theme, $agsdg_theme_slug;
$agsdg_supported_themes = array('Divi', 'Extra');

/*function agsdg_hidden_plugins() {
	global $agsdg_theme, $agsdg_hidden_plugins;
	
	if (!isset($agsdg_hidden_plugins)) {
		switch ($agsdg_theme) {
			case 'Divi':
				$agsdg_hidden_plugins = array(
					'divi-ghoster/divi-ghoster.php' => 1,
					'aspen-footer-editor/divi-footer-editor.php' => 1,
					'divi-switch/divi-switch.php' => 1,
					'divi-booster/divi-booster.php' => 1,
					'divi-dashboard-welcome/divi-dashboard-welcome.php' => 1,
					'divi-100-back-to-top/back-to-top.php' => 1
				);
			case 'Extra':
				$agsdg_hidden_plugins = array(
					'divi-ghoster/divi-ghoster.php' => 1,
					'aspen-footer-editor/divi-footer-editor.php' => 1,
					'divi-switch/divi-switch.php' => 1,
					'divi-booster/divi-booster.php' => 1,
					'divi-dashboard-welcome/divi-dashboard-welcome.php' => 1,
					//'divi-100-back-to-top/back-to-top.php' => 1
				);
		}
	}
	return $agsdg_hidden_plugins;
	
}*/


$agsdg_settings = get_option('agsdg_settings');
if ($agsdg_settings == false) {
	$agsdg_settings = agsdg_initialize_settings();
}
if ($agsdg_settings['ultimate_ghoster'] == 'yes') {
	add_filter('template_directory_uri', 'agsdg_template_directory_uri', 10, 3);
	add_filter('stylesheet_directory_uri', 'agsdg_template_directory_uri', 10, 3);
	add_filter('script_loader_tag', 'adsdg_script_tag', 10, 2);
	add_filter('style_loader_tag', 'adsdg_script_tag', 10, 2);

	global $pagenow;
	if ($pagenow != 'options.php' || empty($_POST['option_page']) || $_POST['option_page'] != 'agsdg_pluginPage') {
		// Add the Ultimate Ghoster rewrite rule, except when we're saving plugin options
		add_action('init', 'agsdg_rewrite_rule');
	}
	
	if ($pagenow == 'plugin-editor.php') {
		add_action('init', 'agsdg_init_plugin_editor');
	} else if ($pagenow == 'update-core.php') {

	add_filter('upgrader_post_install', 'agsdg_post_update', 10, 2);
	
	add_action('permalink_structure_changed', 'agsdg_permalink_structure_changed', 10, 2);
	
	add_action('template_redirect', 'agsdg_template_redirect');
	
	add_filter('wp_prepare_themes_for_js', 'adsdg_themes_for_js');
	
	// Set up theme global variable based on Ultimate Ghoster theme
	$agsdg_theme = get_option('adsdg_ultimate_theme');
	
}
if (empty($agsdg_theme)) {
	// Set up theme global variable based on currently active theme - also in agsdg_initialize_settings()
	$agsdg_theme = wp_get_theme()->get_template();
	if (!in_array($agsdg_theme, $agsdg_supported_themes)) {
		$agsdg_theme = 'Divi';
	}
}
$agsdg_theme_slug = strtolower($agsdg_theme);

unset($agsdg_settings);

function agsdg_cm()
{
	global $agsdg_theme, $agsdg_theme_slug, $menu, $submenu, $pagenow, $plugin_page;
	
	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}
	// Add Ghoster menu item
	if ($settings['ultimate_ghoster'] != 'yes' || ($pagenow == 'admin.php' && $plugin_page == 'divi_ghoster')) {
		add_menu_page($agsdg_theme.' Ghoster', $agsdg_theme.' Ghoster', 'manage_options', 'divi_ghoster', 'agsdg_menu_page');
	}
	
	if (!isset($submenu['et_'.$agsdg_theme_slug.'_options']))
		return;
	
	foreach ($menu as $menuItem) {
		if ($menuItem[2] == 'et_'.$agsdg_theme_slug.'_options') {
			$menuExists = true;
			break;
		}
	}
	if (empty($menuExists)) {
		return;
	}
	
	global $_wp_submenu_nopriv, $_parent_pages, $_registered_pages, $wp_filter;
		
		switch ($agsdg_theme) {
			case 'Divi':
				// Remove Aspen Footer Editor
				if ($pagenow != 'admin.php' || $plugin_page != 'aspen-footer-editor') {
					remove_submenu_page('et_divi_options', 'aspen-footer-editor');
				}
				break;
			case 'Extra':
				// Remove Divi Switch
				if ($pagenow != 'admin.php' || $plugin_page != 'divi-switch-settings') {
					remove_submenu_page('et_divi_options', 'admin.php?page=divi-switch-settings');
				}
				// Remove Divi Booster
				if ($pagenow != 'admin.php' || $plugin_page != 'wtfdivi_settings') {
					remove_submenu_page('et_divi_options', 'wtfdivi_settings');
				}
				// Remove Aspen Footer Editor
				if ($pagenow != 'admin.php' || $plugin_page != 'aspen-footer-editor') {
					remove_submenu_page('et_divi_options', 'aspen-footer-editor');
				}
				break;
		}
		
		$hookName = add_menu_page($params['name'], $params['name'], 'switch_themes', $params['slug']);
		$oldHookName = get_plugin_page_hookname($oldSlug, '');
		foreach (array('', 'load-', 'admin_print_scripts-', 'admin_head-') as $prefix) {
			if (!empty($wp_filter[$prefix.$oldHookName])) {
				foreach ($wp_filter[$prefix.$oldHookName] as $priority => $hooks) {
					foreach ($hooks as $hook) {
						add_action($prefix.$hookName, $hook['function'], $priority, $hook['accepted_args']);
					}
				}
			}
		}
		
		
		// Copy submenu items
		$submenu[$newSlug] = $submenu[$oldSlug];
		foreach ($submenu[$newSlug] as $i => $subMenuItem) {
			
			if ($oldSubmenuSlug == $oldSlug) {
				$submenu[$newSlug][$i][2] = $params['slug'];
			} else if ($oldSubmenuSlug == 'et_'.$agsdg_theme_slug.'_role_editor') {
				$submenu[$newSlug][$i][2] = 'et_' . $settings['theme_slug'] . '_role_editor';
			}
			
			$hookName = get_plugin_page_hookname($submenu[$newSlug][$i][2], $params['slug']);
			foreach (array('', 'load-', 'admin_print_scripts-', 'admin_head-') as $prefix) {
			unset($_registered_pages[$oldHookName]);
			$_registered_pages[$hookName] = 1;
			
			$_parent_pages[$submenu[$newSlug][$i][2]] = $newSlug;
		}
		if (isset($_wp_submenu_nopriv[$oldSlug]))
			$_wp_submenu_nopriv[$newSlug] = $_wp_submenu_nopriv[$oldSlug];
		
		remove_menu_page($oldSlug);
		unset($submenu[$oldSlug]);
}
add_action('admin_menu', 'agsdg_cm', 9999);

function agsdg_admin_init() {
	/** Settings **/
	if ($settings === false) {
		$settings = agsdg_initialize_settings();
	}
	
	register_setting('agsdg_pluginPage', 'agsdg_settings', 'agsdg_sanitize_settings');
	
    add_settings_section('agsdg_pluginPage_section_branding_name', __('<hr/>', 'ags-ghoster'), 'agsdg_branding_name_settings_section_callback', 'agsdg_pluginPage');
	add_settings_field('agsdg_branding_name', '<label class="agsdg_settings_label">'.__('Enter Branding Name<br />(example: Acme Web Designs)', 'ags-ghoster').'</label>', 'agsdg_branding_name_render', 'agsdg_pluginPage', 'agsdg_pluginPage_section_branding_name');
	
	add_settings_section('agsdg_pluginPage_section_branding_image', __('<hr/>', 'ags-ghoster'), 'agsdg_branding_image_settings_section_callback', 'agsdg_pluginPage');
    add_settings_field('agsdg_branding_image', '<label class="agsdg_settings_label">'.__('Enter Branding Image<br />(Recommended: 36px by 36px)', 'ags-ghoster').'</label>', 'agsdg_branding_image_render', 'agsdg_pluginPage', 'agsdg_pluginPage_section_branding_image');
	
	add_settings_section('agsdg_pluginPage_section_theme_slug', __('<hr/>', 'ags-ghoster'), 'agsdg_theme_slug_settings_section_callback', 'agsdg_pluginPage');
    add_settings_field('agsdg_theme_slug', '<label class="agsdg_settings_label">'.__('Enter Slug Text (example: acme_web_designs)', 'ags-ghoster').'</label>', 'agsdg_theme_slug_render', 'agsdg_pluginPage', 'agsdg_pluginPage_section_theme_slug');
	
	add_settings_section('agsdg_pluginPage_section_ultimate_ghoster', __('<hr/>', 'ags-ghoster'), 'agsdg_ultimate_ghoster_settings_section_callback', 'agsdg_pluginPage');
    add_settings_field('agsdg_ultimate_ghoster', '<label class="agsdg_settings_label">'.__('Ultimate Ghoster', 'ags-ghoster').'</label>', 'agsdg_ultimate_ghoster_render', 'agsdg_pluginPage', 'agsdg_pluginPage_section_ultimate_ghoster');
}
add_action('admin_init', 'agsdg_admin_init');

if (is_admin()) {
	add_filter('gettext', 'agsdg_translate_text');
	add_filter('ngettext', 'agsdg_translate_text');
}
function agsdg_translate_text($translated) {
	global $agsdg_theme;
	
	if (empty($agsdg_theme))
		return $translated;
	
	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}
	
    $translated = preg_replace(($agsdg_theme == 'Divi' ? '/(Divi\b)/' : '/('.$agsdg_theme.'\b|Divi\b)/'), $settings['branding_name'], $translated);
	
	// Revert back for certain strings
	//if ($agsdg_theme == 'Divi') {
		if (is_plugin_active('divi-switch/divi-switch.php')) {
			$translated = preg_replace('/('.$settings['branding_name'].' Switch\b)/', "Divi Switch", $translated);
		}
		if (is_plugin_active('divi-booster/divi-booster.php')) {
			$translated = preg_replace('/('.$settings['branding_name'].' Booster\b)/', "Divi Booster", $translated);
		}
	//}
	
    return $translated;
}

function replace_admin_menu_icons_css()
{
	global $agsdg_theme;

	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}
	
	// Do not output the admin CSS if the currently active theme is not the one that Ghoster has been applied to
	if (wp_get_theme()->get_template() != $agsdg_theme) {
		return;
	}

	echo('<style>');
	
	$settings = get_option('agsdg_settings');
	
    if (!empty($settings['branding_image'])) {
?>
	#adminmenu #toplevel_page_et_<?php echo $settings['theme_slug']; ?>_options div.wp-menu-image::before,
	background: url(<?php
        echo $settings['branding_image'];
?>) no-repeat !important;
	content:'' !important;
    margin-top: 6px !important;
	max-width:22px !important;
	max-height:22px !important;
	width: 100%;
	background-size: contain!important;
}
    #et_pb_layout .hndle:before, #et_pb_toggle_builder:before
    {
		color:transparent !important;
		background: url(<?php
        echo $settings['branding_image'];
?>) no-repeat  !important;
        background-size: contain!important;
		max-height: 33px;
		max-width: 36px;
		width: 100%;
	}
	
    #et_pb_layout h3:before
    {
    background-image: url(<?php
        echo $settings['branding_image'];
?>) no-repeat  !important;
    }
    #et_settings_meta_box .hndle.ui-sortable-handle::before{
    color:transparent !important;
    background: url(<?php
        echo $settings['branding_image'];
?>) no-repeat !important;	
    max-height: 26px;
    max-width: 26px;
    margin: 9px 0px 0px 0px;
    background-size: contain!important;
    }
#et_settings_meta_box .hndle:before
{
    color:transparent !important;
    background: url(<?php
        echo $settings['branding_image'];
?>) no-repeat !important;	
    height:36px;
    width:36px;
    margin:6px 0px 0px 0px;
}
#epanel-logo{
	content: url(<?php echo $settings['branding_image']; ?>) !important;
	width:143px; 
	height:65px;
}
#epanel-title {
	background-color: transparent !important;
}
#epanel-title:before {
	display: none;
}
#epanel-header:before {
	display: block;
	float: left;
	vertical-align: top;
	background: url(<?php echo $settings['branding_image']; ?>) no-repeat !important;
    content: '' !important;
	width: 32px !important;
    height: 32px !important;
	margin-top: -4px;
	margin-right: 10px;
    background-size: contain !important;
	background-position: left 0px center !important;
}
.et_pb_roles_title:before {
	background: url(<?php echo $settings['branding_image']; ?>) no-repeat !important;
    content: '' !important;
    width: 32px !important;
    height: 32px !important;
    background-size: contain !important;
	background-position: left 0px center !important;
}
<?php } // /!empty($settings['branding_image'])
<?php
}
add_action('admin_head', 'replace_admin_menu_icons_css');

function agsdg_plugin_list($plugins)
{
	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}
}
add_filter('all_plugins', 'agsdg_plugin_list');

/** Login screen customizer **/

add_action('customize_register', 'agsdg_wp_admin_area_customization');
function agsdg_wp_admin_area_customization($wp_customize)
{
	// Check color control dependency
	if (class_exists('ET_Color_Alpha_Control')) {
		$colorControl = 'ET_Color_Alpha_Control';
	} else if (class_exists('ET_Divi_Customize_Color_Alpha_Control')) {
		$colorControl = 'ET_Divi_Customize_Color_Alpha_Control';
	} else {
		return;
	}

    $wp_customize->add_section('wp_admin_area_custom_settings', array(
        'title' => 'Login Customizer'
    ));
    $wp_customize->add_setting('login_area_bg_image', array());
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'login_area_bg_image', array(
        'label' => __('Background Image', 'agsdg'),
        'section' => 'wp_admin_area_custom_settings'
    )));
    $wp_customize->add_setting('login_form_alignment', array(
        'default' => 'none',
        'transport' => 'refresh'
    ));
    $wp_customize->add_control('login_form_alignment', array(
        'label' => 'Login Form Alignment',
        'section' => 'wp_admin_area_custom_settings',
        'placeholder' => 'Align the login logo',
        'default' => 'none',
        'type' => 'radio',
        'choices' => array(
            'left' => 'Left',
            'none' => 'Center',
            'right' => 'Right'
        )
    ));
    $wp_customize->add_section('wp_admin_area_custom_settings', array(
        'title' => 'Login Customizer'
    ));
    $wp_customize->add_setting('login_area_logo_image', array());
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'login_area_logo_image', array(
        'label' => __('Login Logo (in place of WP logo)', 'ags-ghoster'),
        'section' => 'wp_admin_area_custom_settings'
    )));
    $wp_customize->add_section('wp_admin_area_custom_settings', array(
        'title' => 'Login Customizer'
    ));
    $colors   = array();
    $colors[] = array(
        'slug' => 'login_background_color',
        'default' => '#',
        'label' => __('Background Color', 'ags-ghoster')
    );
    $colors[] = array(
        'slug' => 'content_link_color',
        'default' => '#999',
        'label' => __('Links Color', 'ags-ghoster')
    );
    $colors[] = array(
        'slug' => 'form_background_color',
        'default' => '#ffffff',
        'label' => __('Form Background Color', 'ags-ghoster')
    );
    $colors[] = array(
        'slug' => 'background_color_tint',
        'default' => 'rgba(0, 0, 0, 0)',
        'label' => __('Background Image Tint', 'ags-ghoster')
    );
    $colors[] = array(
        'slug' => 'login_submit_color',
        'default' => '#00a0d2',
        'label' => __('Submit Button Color', 'ags-ghoster')
    );
	
	foreach ($colors as $color) {
		$wp_customize->add_setting($color['slug'], array(
			'default' => $color['default'],
			'type' => 'option',
			'capability' => 'edit_theme_options'
		));
		$wp_customize->add_control(new $colorControl($wp_customize, $color['slug'], array(
			'label' => $color['label'],
			'section' => 'wp_admin_area_custom_settings',
			'settings' => $color['slug']
		)));
	}
}

add_action('login_head', 'get_login_area_bg_image_dg');
function get_login_area_bg_image_dg()
{
    $default = '';
    $value   = get_theme_mod('login_area_bg_image', $default);
    if ($value !== $default) {
        echo '<style type="text/css"> 
	.login, body, html { background-image: url(" ' . get_theme_mod('login_area_bg_image') . ' ")!important;
	} </style>';
    }
}
function custom_login_logo_dg()
{
    $default = '';
    $value   = get_theme_mod('login_area_logo_image', $default);
    if ($value !== $default) {
        echo '<style type="text/css">
    h1 a {
     background-image: url(" ' . $value . ' ") !important;
    }
  </style>';
    }
}
add_action('login_head', 'custom_login_logo_dg');
function custom_login_area_logo_image_dg()
{
    return get_bloginfo('url');
}
add_filter('login_headerurl', 'custom_login_area_logo_image_dg');
function custom_login_area_logo_image_title_dg()
{
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'custom_login_area_logo_image_title_dg');
add_action('login_head', 'get_login_area_alighment_dg');
function get_login_area_alighment_dg()
{
    $default = '';
    $value   = get_theme_mod('login_form_alignment', $default);
    if ($value !== $default) {
        echo '<style type="text/css"> 
	#login { float: ' . get_theme_mod('login_form_alignment') . '!important;
	} </style>';
    }
}
add_action('login_head', 'get_login_area_color_dg');
function get_login_area_color_dg()
{
    echo '<style> .login #backtoblog a, #login form p label, .login #nav a, .login h1 a {
	color: ' . get_option('content_link_color') . '!important; } 
	
	
	    .login:before {
			background : ' . get_option('login_background_color') . '!important; }
	.login form {
		background: ' . get_option('form_background_color') . '!important;
	}
	.login:after { 
	background: ' . get_option('background_color_tint') . ' !important;
		
	}
	
	.wp-core-ui .button-primary {
		background: ' . get_option('login_submit_color') . '!important;
	}
	</style>';
}



function agsdg_rewrite_rule($slug=null) {
		$settings = get_option('agsdg_settings');
		if ($settings == false) {
			$settings = agsdg_initialize_settings();
		}
		add_rewrite_rule('wp-content/themes/'.$settings['theme_slug'].'/(.*)$', 'wp-content/themes/'.$agsdg_theme.'/$1');
}



function adsdg_script_tag($tag, $handle) {
	global $agsdg_theme_slug;

	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}

	if (stripos($handle, $agsdg_theme_slug) !== false) {
		$newHandle = str_ireplace(array($agsdg_theme_slug.'-', '-'.$agsdg_theme_slug), array($settings['theme_slug'].'-', '-'.$settings['theme_slug']), $handle);
		if ($newHandle != $handle) {
			$tag = str_ireplace(array('id=\''.$handle, 'id="'.$handle), array('id=\''.$newHandle, 'id="'.$newHandle), $tag);
		}
	}
	return $tag;
}

function agsdg_change_theme_meta($newThemeName, $isUpdate, $childTheme=false) {
	global $agsdg_theme;
	$themeRoot = (empty($childTheme) ? get_theme_root().'/'.$agsdg_theme.'/' : $childTheme->get_stylesheet_directory().'/');
	$stylesheetFile = $themeRoot.'style.css';
	if (!$isUpdate) {
		// Backup original stylesheet
		if (file_exists($themeRoot.'style.pre_agsdg.css') || !@copy($stylesheetFile, $themeRoot.'style.pre_agsdg.css')) {
			return false;
		}
	}
	$stylesheetContents = @file_get_contents($themeRoot.'style.pre_agsdg.css');
	if ($stylesheetContents === false)
		return false;
		
	$commentStartPos = strpos($stylesheetContents, '/*');
	$commentEndPos = strpos($stylesheetContents, '*/');
	if ($commentStartPos === false || $commentEndPos === false)
		return false;
	
	$comment = trim(substr($stylesheetContents, $commentStartPos + 2, ($commentEndPos - $commentStartPos)));
	
	$newComment = '';
	//$newComment2 = '';
	foreach (explode("\n", $comment) as $commentLine) {
		$commentLine = trim($commentLine);
		if (empty($commentLine)) {
			continue;
		}
		if ($commentLine[0] == '*' || $commentLine[0] == '#')
			$commentLine = trim(substr($commentLine, 1));
	
		$colonPos = strpos($commentLine, ':');
		if ($colonPos !== false) {
			$beforeColon = substr($commentLine, 0, $colonPos);
				if ($beforeColon == 'Theme Name') {
					$newComment .= 'Theme Name: '.$newThemeName."\n";
				} else if ($beforeColon == 'Version' || $beforeColon == 'License' || $beforeColon == 'License URI') {
					$newComment .= $commentLine."\n";
				} /*else if ($beforeColon != 'Description' && $beforeColon != 'Tags') {
					$newComment2 .= 'Original '.$beforeColon.' - '.substr($commentLine, $colonPos + 1)."\n";
				}*/
		}
	}
		$stylesheetContents = ($commentStartPos > 0 ? substr($stylesheetContents, 0, $commentStartPos) : '')."/*\n".$newComment.'*/'

	// Add new header, save stylesheet
	if (!file_put_contents($stylesheetFile, $stylesheetContents))
		return false;
	
	// Remove theme screenshot
	if (
		(file_exists($themeRoot.'screenshot.jpg') && !@rename($themeRoot.'screenshot.jpg', $themeRoot.'_screenshot.jpg')) ||
		(file_exists($themeRoot.'screenshot.png') && !@rename($themeRoot.'screenshot.png', $themeRoot.'_screenshot.png'))
	) {
		return false;
	}
	return true;
}

function agsdg_restore_theme_meta() {
	global $agsdg_theme;
	
	$themeRoot = get_theme_root().'/'.$agsdg_theme.'/';
	if (!@rename($themeRoot.'style.pre_agsdg.css', $themeRoot.'style.css') ||
		!(!file_exists($themeRoot.'_screenshot.jpg') || @rename($themeRoot.'_screenshot.jpg', $themeRoot.'screenshot.jpg')) ||
		!(!file_exists($themeRoot.'_screenshot.png') || @rename($themeRoot.'_screenshot.png', $themeRoot.'screenshot.png'))
	) {
		return false;
	}
	return true;
}

function agsdg_post_update($return, $args) {
	global $agsdg_theme;
	if (isset($args['theme']) && strcasecmp($args['theme'], $agsdg_theme) == 0) {
		$settings = get_option('agsdg_settings');
		if ($settings == false) {
			$settings = agsdg_initialize_settings();
		}
		if (empty($settings['branding_name']) || !agsdg_change_theme_meta($settings['branding_name'], false)) {
			$return = new WP_Error('AGSDG_ERROR');
		} else {
	}
	return $return;
}

function agsdg_template_directory_uri($uri, $template, $themeRootUri) {
	global $agsdg_theme;
	if (strcasecmp($template, $agsdg_theme) == 0) {
		global $agsdg_template_directory_uri;
		if (!isset($agsdg_template_directory_uri)) {
			$settings = get_option('agsdg_settings');
			if ($settings == false) {
				$settings = agsdg_initialize_settings();
			}
			$agsdg_template_directory_uri = $themeRootUri.'/'.$settings['theme_slug'];
		}
		return $agsdg_template_directory_uri;
	}
	return $uri;
}

function agsdg_after_setup_theme() {
	global $themename, $l10n, $agsdg_theme;
	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}
	$themename = $settings['branding_name'];
}
add_filter('after_setup_theme', 'agsdg_after_setup_theme', 9999);

function agsdg_et_pb_load_roles_admin_hook($hook) {
	
	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}

	return get_plugin_page_hookname('et_' . $settings['theme_slug'] . '_role_editor', 'et_' . $settings['theme_slug'] . '_options');
}
add_filter('et_pb_load_roles_admin_hook', 'agsdg_et_pb_load_roles_admin_hook', 9999);
add_filter('et_divi_role_editor_page', 'agsdg_et_role_editor_page', 9999);

function agsdg_initialize_settings() {
	global $agsdg_theme;
	
	if (empty($agsdg_theme)) {
		// Set up theme global variable based on currently active theme - also towards the top of this file
		global $agsdg_supported_themes;
		$agsdg_theme = wp_get_theme()->get_template();
		if (!in_array($agsdg_theme, $agsdg_supported_themes)) {
			$agsdg_theme = 'Divi';
		}
	}
	
	$options = array();
	
	$oldOptions = get_option('dwl_settings');
	$options['branding_name'] = (empty($oldOptions['dwl_text_field_0']) ? $agsdg_theme : $oldOptions['dwl_text_field_0']);
	$options['branding_image'] = get_option('dash_icon_path', '');
	$options['theme_slug'] = get_option('curr_page', 'ghost_divi');
	$options['ultimate_ghoster'] = get_option('hidden_stat', 'no');
	
	update_option('agsdg_settings', $options);
	
	return $options;
}

function agsdg_permalink_structure_changed($oldStructure, $newStructure) {
	// Prevent the user from changing the permalink structure to Plain while Ultimate Ghoster is enabled
	if (empty($newStructure)) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure($oldStructure);
	}
}
	global $agsdg_theme;
	
	if ($themeSlug === null) {
		$themeSlug = $settings['theme_slug'];
	}
	$plugins[''] = agsdg_filter_hidden_plugins($plugins['']);

function agsdg_admin_bar_menu($admin_bar) {
	$visualBuilderNode = $admin_bar->get_node('et-use-visual-builder');
	if (!empty($visualBuilderNode)) {
		$admin_bar->remove_node('et-use-visual-builder');
		$visualBuilderNode = get_object_vars($visualBuilderNode);
		$visualBuilderNode['id'] = 'agsdg-et-use-visual-builder';
		$admin_bar->add_node($visualBuilderNode);
	}
}
add_action('admin_bar_menu', 'agsdg_admin_bar_menu', 9999);

function agsdg_ultimate_ghoster_disable() {
	$settings = get_option('agsdg_settings');
	if ($settings == false) {
		$settings = agsdg_initialize_settings();
	}
	
	/*if ($settings['ultimate_ghoster'] != 'yes') {
		return;
	}*/

	// Update settings
	$settings['ultimate_ghoster'] = 'no';
	update_option('agsdg_settings', $settings);
	delete_option('adsdg_ultimate_theme');
	
	// Restore theme meta
	$result = agsdg_restore_theme_meta();
	
	// Remove fallback (if applicable)
	$result = agsdg_fallback_remove() && $result;
	
	// Remove symlink
	$result = agsdg_remove_theme_symlink($settings['theme_slug']) && $result;
	
	return $result;
}