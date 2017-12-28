<?php
/*
Plugin Name: Collapsing Archives
Plugin URI: http://robfelty.com/plugins/collapsing-archives
Description: Allows users to expand and collapse archive links like Blogger. <a href='http://wordpress.org/extend/plugins/collapsing-archives/other_notes'>Manual</a> | <a href='http://wordpress.org/extend/plugins/collapsing-archives/faq'>FAQ</a> 
Author: Robert Felty
Version: 2.0.5
Author URI: http://robfelty.com

Copyright 2007-2017 Robert Felty

This file is part of Collapsing Archives

    Collapsing Archives is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    Collapsing Archives is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Collapsing Archives; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 
$url = get_settings('siteurl');
global $collapsArchVersion;
$collapsArchVersion = '2.0.2';

// LOCALIZATION
function collapsArch_load_domain() {
	load_plugin_textdomain( 'collapsArch', WP_PLUGIN_DIR."/".basename(dirname(__FILE__)), basename(dirname(__FILE__)) );
}
add_action('init', 'collapsArch_load_domain'); 


/****************/
if (!is_admin()) {
  wp_enqueue_script('jquery');
  add_action( 'wp_head', array('collapsArch','get_head'));
} else {
  // call upgrade function if current version is lower than actual version
  $dbversion = get_option('collapsArchVersion');
  if (!$dbversion || $collapsArchVersion != $dbversion)
    collapsArch::init();
}
register_activation_hook(__FILE__, array('collapsArch','init'));

class collapsArch {
	public static function init() {
    global $collapsArchVersion;
    $dbversion = get_option('collapsArchVersion');
    if ($collapsArchVersion != $dbversion) {
      update_option( 'collapsArchVersion', $collapsArchVersion);
    }
    if (!get_option('collapsArchVersion')) {
      add_option( 'collapsArchVersion', $collapsArchVersion);
		}

	}

	public static function get_head() {
    echo "<style type='text/css'>";
    echo collapsArch::set_styles();
    echo "</style>\n";
	}
  public static function set_styles() {
    $widget_options = get_option('widget_collapsarch');
    include('collapsArchStyles.php');
    $css = '';
    $oldStyle=true;
    foreach ($widget_options as $key=>$value) {
      $id = "widget-collapsarch-$key-top";
      if (isset($value['style'])) {
        $oldStyle=false;
        $style = $defaultStyles[$value['style']];
        $css .= str_replace('{ID}', '#' . $id, $style);
      }
    }
    if ($oldStyle)
      $css=stripslashes(get_option('collapsArchStyle'));
    return($css);
  }
  public static function phpArrayToJS($array, $name, $options) {
    /* generates javscript code to create an array from a php array */
    print "try { $name" . 
        "['catTest'] = 'test'; } catch (err) { $name = new Object(); }\n";
    if (!$options['expandYears'] && $options['expandMonths']) {
      $lastYear = -1;
      foreach ($array as $key => $value){
        $parts = explode('-', $key);
        $label = $parts[0];
        $year = $parts[1];
        $moreparts = explode(':', $key);
        $widget = $moreparts[1];
        if ($year != $lastYear) {
          if ($lastYear>0)
            print  "';\n";
          print $name . "['$label-$year:$widget'] = '" . 
              addslashes(str_replace("\n", '', $value));

          $lastYear=$year;
        } else {
          print addslashes(str_replace("\n", '', $value));
        }
      }
      print  "';\n";
    } else {
      foreach ($array as $key => $value){
        print $name . "['$key'] = '" . 
            addslashes(str_replace("\n", '', $value)) . "';\n";
      }
    }
  }
}
include_once( 'collapsArchList.php' );
function collapsArch($args='') {
  global $collapsArchItems;
  include('defaults.php');
  $options=wp_parse_args($args, $defaults);
  if (!is_admin()) {
    if (!$options['number'] || $options['number']=='') 
      $options['number']=1;
    $archives = list_archives($options);
    extract($options);
    include('symbols.php');
    $archives .= "<li style='display:none'><script type=\"text/javascript\">\n";
    $archives .= "// <![CDATA[\n";
      $archives .= '/* These variables are part of the Collapsing Archives Plugin
   * version: 2.0.5
   * revision: $Id: collapsArch.php 1715352 2017-08-18 14:30:00Z robfelty $
   * Copyright 2008 Robert Felty (robfelty.com)
           */' ."\n";

    print $archives;
    // now we create an array indexed by the id of the ul for posts
    collapsArch::phpArrayToJS($collapsArchItems, 'collapsItems', $options);
    include_once('collapsFunctions.js');
      echo "addExpandCollapse('widget-collapsarch-$number-top'," . 
          "'$expandSym', '$collapseSym', " . $accordion . ")";
    print "// ]]>\n</script></li>\n";
  }
}
$version = get_bloginfo('version');
if (preg_match('/^(2\.[8-9]|[3-9]\..*)/', $version)) 
  include('collapsArchWidget.php');
?>
