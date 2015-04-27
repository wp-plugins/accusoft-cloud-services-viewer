<?php

/*
Plugin Name: ACS Viewer
Plugin URI: http://www.accusoft.com/cloud-services/viewer/
Description: ACS Viewer enables you to offer high-speed document viewing without worrying about additional hardware or installing software.  The documents stay on your servers, so you can delete, update, edit and change them anytime. We don't keep copies of your documents, so they are always secure!
Author: Accusoft <cloudservices@accusoft.com>
Author URI: http://www.accusoft.com/
Version: 1.7
License: GPL2
*/
define (ACCUSOFT_SERVER, '//api.accusoft.com');
define (ACCUSOFT_PATH, '/v1/viewer/');
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

function acsviewer_getdocument($atts, $content)
{
  $licenseKey = get_option('licenseKey');
  parse_str(html_entity_decode($content), $params);

  if($params['server']) {
      $server = $params['server'];
      unset($params['server']);
  } else {
      $server = ACCUSOFT_SERVER.ACCUSOFT_PATH;
  }

  if ($atts) {
      foreach ($atts as $key => $value) {
          if (!$params[$key]) {
              $params[$key] = $value;
          }
      }
  }
  $params = supportLegacy($params);

  if(!$params['key']) {
      $params['key'] = $licenseKey;
  }
  $viewerCode = $server."?";
  if($params) {
      foreach ($params as $key => $value) {
          $viewerCode .= $key . "=" . $value . "&";
      }
  }
    $viewerCode = rtrim($viewerCode, "&");

    if (strcmp($params['viewertype'],'slideshow') != 0) {
        if (preg_match('/.+%$/', $params['viewerheight'])) {
            $iframeHeight = intval($params['viewerheight'])/100 * 800;
        } else {
            $iframeHeight = $params['viewerheight'] + 40;
        }
        if (preg_match('/.+%$/', $params['viewerwidth'])) {
            $iframeWidth = $params['viewerwidth'];
        } else {
            $iframeWidth = $params['viewerwidth'] + 20;
        }
    } else {
        if (preg_match('/.+%$/', $params['viewerheight'])) {
            $iframeHeight = intval($params['viewerheight'])/100 * 600;
        } else {
            $iframeHeight = $params['viewerheight'] + 20;
        }
        if (preg_match('/.+%$/', $params['viewerwidth'])) {
            $iframeWidth = $params['viewerWidth'];
        } else {
            $iframeWidth = $params['viewerwidth'] + 20;
        }
    }

    $code = "<iframe src=\"".$viewerCode."\" width=\"".$iframeWidth."\" height=\"".$iframeHeight."\" frameborder =0 seemless></iframe>";
//    $code = "<iframe src=\"".$viewerCode."\" width=\"100%\" height=\"100%\" frameborder =0 seemless></iframe>";

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

add_action('admin_enqueue_scripts', 'enqueue_scripts_styles_admin');
function enqueue_scripts_styles_admin(){
    wp_enqueue_media();
}

function supportLegacy($atts)
{
    if($atts['type']) {
        $atts['viewertype'] = $atts['type'];
        unset($atts['type']);
    }
    if ($atts['width']) {
        $atts['viewerwidth'] = $atts['width'];
        unset($atts['width']);
    }
    if($atts['height']) {
        $atts['viewerheight'] = $atts['height'];
        unset($atts['height']);
    }
    if($atts['color']) {
        $atts['lowerToolbarColor'] = $atts['color'];
        unset($atts['color']);
    }
    if ($atts['print'] == "No") {
        if (strlen($atts['hidden']) > 0) {
            $atts['hidden'] .= ',print';
        } else {
            $atts['hidden'] = 'print';
        }
        unset($atts['print']);
    }
    return $atts;

}
