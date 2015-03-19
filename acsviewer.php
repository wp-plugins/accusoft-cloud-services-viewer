<?php

/*
Plugin Name: ACS Viewer
Plugin URI: http://www.accusoft.com/cloud-services/viewer/
Description: ACS Viewer enables you to offer high-speed document viewing without worrying about additional hardware or installing software.  The documents stay on your servers, so you can delete, update, edit and change them anytime. We don't keep copies of your documents, so they are always secure!
Author: Accusoft <cloudservices@accusoft.com>
Author URI: http://www.accusoft.com/
Version: 1.6
License: GPL2
*/

include_once('acsviewer-functions.php');

register_activation_hook( __FILE__, 'acsviewer_plugin_activate' );
function acsviewer_plugin_activate() {
}

add_action('admin_notices', 'acsviewer_admin_notices');
function acsviewer_admin_notices() {
}

register_deactivation_hook(__FILE__, 'acsviewer_plugin_deactivate');
function acsviewer_plugin_deactivate() {
}

function acsviewer_getdocument($atts)
{
  $licenseKey = get_option('licenseKey');

	extract(shortcode_atts(array(
		'key' => '',
		'document' => '',
		'type' => '',
		'width' => '',
		'height' => '',
		'print' => '',
		'color' => '',
		'animtype' => '',
		'animduration' => '',
		'animspeed' => '',
		'automatic' => '',
		'showcontrols' => '',
		'centercontrols' => '',
		'keyboardnav' => '',
		'hoverpause' => ''
	), $atts));
	$integration = "wordpress";

  if(!empty($licenseKey)) { $key = $licenseKey; }
	
	if (strcmp($type,"slideshow") != 0)
	{
		$viewerCode = "//connect.ajaxdocumentviewer.com/?key=".$key."&viewertype=".$type."&document=".$document."&viewerheight=".$height."&viewerwidth=".$width."&printButton=".$print."&toolbarColor=".$color."&integration=".$integration;
		$iframeWidth = $width + 20;
		$iframeHeight = $height + 40;
	}
	else
	{
		$viewerCode = "//connect.ajaxdocumentviewer.com/?key=".$key."&viewertype=".$type."&document=".$document."&viewerheight=".$height."&viewerwidth=".$width."&animtype=".$animtype."&animduration=".$animduration."&animspeed=".$animspeed."&automatic=".$automatic."&showcontrols=".$showcontrols."&centercontrols=".$centercontrols."&keyboardnav=".$keyboardnav."&hoverpause=".$hoverpause."&integration=".$integration;
		$iframeWidth = $width + 20;
		$iframeHeight = $height + 20;
	}
        if ($type == "flash" && $width < 650) {
	    $code = "<div id=\"widtherror\" width=\"600\" height=\"100\">Prizm Viewer Error: Please choose a width of 650px or greater for your Prizm Flash Viewer, or select the HTML5 viewer if you need a smaller size</div>";
        }
        else {
  	    $code = "<iframe src=\"".$viewerCode."\" width=\"".$iframeWidth."\" height=\"".$iframeHeight."\" frameborder =0 seemless></iframe>";
        }
	return $code;
}

// Activate Shortcode to Retrive Document with ACS Viewer
add_shortcode('acsviewer', 'acsviewer_getdocument');

// Add ACS Viewer Dialog button to Tiny MCEEditor
add_action('admin_init','acsviewer_mce_addbuttons');

// Add ACS Viewer Dialog window to Tiny MCEEditor
add_action('wp_ajax_acsviewer_dialog_window', 'acsviewer_dialog_window');

// Add an Option to Settings Menu for ACS Viewer
add_action('admin_menu', 'acsviewer_settings_page');

function acsviewer_settings_page()
{
	global $acsviewer_settings_page;

	$acsviewer_settings_page = add_options_page('ACS Viewer', 'ACS Viewer', 'manage_options', basename(__FILE__), 'acsviewer_settings');

}
if (!defined('ACSVIEWER_WP_PLUGIN_NAME'))
    define('ACSVIEWER_WP_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

function acsviewer_settings()
{
	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) die(t('An error occurred.'));
	if (! user_can_access_admin_page()) wp_die('You do not have sufficient permissions to access this page');

	require(ABSPATH. 'wp-content/plugins/'. ACSVIEWER_WP_PLUGIN_NAME .'/acsviewer-settings.php');
}
