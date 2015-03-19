<?php

if (!defined('ACSVIEWER_WP_PLUGIN_NAME'))
    define('ACSVIEWER_WP_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('ACSVIEWER_WP_PLUGIN_URL'))
{
	define('ACSVIEWER_WP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

function acsviewer_mce_addbuttons()
{
	// Permissions Check
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	// Add button to TinyMCE Editor
	if ( get_user_option('rich_editing') == 'true')
	{
		add_filter("mce_external_plugins", "acsviewer_add_tinymce_plugin");
		add_filter('mce_buttons', 'acsviewer_register_mce_button');
	}
}

function acsviewer_register_mce_button($buttons)
{
	array_push($buttons, "separator", "acsviewer");
	return $buttons;
}

function acsviewer_add_tinymce_plugin($plugin_array)
{
	$plugin_array['acsviewer'] = ACSVIEWER_WP_PLUGIN_URL.'js/acsviewer-plugin.js';
	return $plugin_array;
}

function acsviewer_dialog_window()
{
  global $wp_version;
	define('JS_PLUGIN_URL', includes_url() . '/js');

	// Get ACS Viewer License Key
  $licenseKey = get_option('licenseKey');

  // Display Form
?>
<!DOCTYPE html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			<title>Accusoft Cloud Services Viewer</title>
      <link href="<?php echo ACSVIEWER_WP_PLUGIN_URL ?>/css/mcColorPicker.css" type="text/css" rel="stylesheet" />
      <link href="<?php echo ACSVIEWER_WP_PLUGIN_URL ?>/css/acsviewer.css" type="text/css" rel="stylesheet" />

      <script type="text/javascript" src="<?php echo JS_PLUGIN_URL ?>/jquery/jquery.js"></script>
		</head>
		
		<body>

			<form id="formAcsViewer" method="post" class="acsviewer-form">
      <?php if (strlen(trim($licenseKey)) > 0)
			{
        ?>
          <input type="hidden" id="licenseKey" name="licenseKey" value="<?php echo $licenseKey ?>" />
        <?php
              }
?>
      <small>All fields are required. If these setting look confusing, please <a href="http://www.accusoft.com/cloud-services/viewer/how-to-embed-the-viewer/#optional-parameters" target="_blank">visit our help page.</a></small>
			<table class="form-table">
<?php if (strlen(trim($licenseKey)) == 0) { ?>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Key:</strong><br /></label></td>
            <td valign="top"><input name="licenseKey" type="text" class="opt dwl" id="licenseKeyInput" style="width:200px;" value="<?php echo $licenseKey ?>" /></td>
					</tr>
<?php } ?>
				<tr>
					<td align="right" class="gray dwl_gray"><label><strong>Your Document URL:</strong></label></td>
					<td valign="top"><input name="viewerDocument" type="text" id="viewerDocument" size="40" /></td>
				</tr>
				<tr>
					<td align="right" class="gray dwl_gray"><label><strong>Viewer Type:</strong></label></td>
					<td valign="top">
						<input type="radio" value="html5" name="viewerType" onclick="javascript:pcSettings(this.value)" checked="checked" /> <span>HTML5</span>
						<input type="radio" value="slideshow" name="viewerType" onclick="javascript:pcSettings(this.value)" /> <span>Slideshow</span>
					</td>
				</tr>
				<tr>
					<td align="right" class="gray dwl_gray"><label><strong>Viewer Width:</strong></label></td>
					<td valign="top"><input name="viewerWidth" type="text" id="viewerWidth" size="6" value="600" /><span class="pixel">px</span></td>
				</tr>
				<tr>
					<td align="right" class="gray dwl_gray"><label><strong>Viewer Height:</strong></label></td>
					<td valign="top"><input name="viewerHeight" type="text" id="viewerHeight" size="6" value="800" /><span class="pixel">px</span></td>
				</tr>
			</table>
			<div id="documentViewer" class="show">
				<table>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Print Button:</strong></label></td>
						<td valign="top">
							<input type="radio" name="viewerPrintButton" value="Yes" checked="checked" /> <span>Yes</span>
							<input type="radio" name="viewerPrintButton" value="No" /> <span>No</span>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Toolbar Color:</strong></label></td>
						<td valign="top">
							<input type="text" id="viewerToolbarColor" name="viewerToolbarColor" value="#CCCCCC" class="color" />
						</td>
					</tr>
				</table>
			</div>
			<div id="slideshowViewer" class="hide">
				<table>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Animation Type:</strong></label></td>
						<td valign="top">
							<select id="viewerAnimType" name="viewerAnimType">
							<option value="slide">Slide</option>
							<option value="fade">Fade</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Animation Duration:</strong></label></td>
						<td valign="top">
							<input type="text" id="viewerAnimDuration" name="viewerAnimDuration" value="450" /><em>(Note: # in milliseconds)</em>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Animation Speed:</strong></label></td>
						<td valign="top">
							<input type="text" id="viewerAnimSpeed" name="viewerAnimSpeed" value="4000" /><em>(Note: # in milliseconds)</em>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Start Automatically:</strong></label></td>
						<td valign="top">
							<select id="viewerAutomatic" name="viewerAutomatic">
							<option value="yes">Yes</option>
							<option value="no">No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Show Controls:</strong></label></td>
						<td valign="top">
							<select id="viewerShowControls" name="viewerShowControls">
							<option value="yes">Yes</option>
							<option value="no">No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Center Controls: (if shown)</strong></label></td>
						<td valign="top">
							<select id="viewerCenterControls" name="viewerCenterControls">
							<option value="yes">Yes</option>
							<option value="no">No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Allow Keyboard Navigation:</strong></label></td>
						<td valign="top">
							<select id="viewerKeyboardNav" name="viewerKeyboardNav">
							<option value="yes">Yes</option>
							<option value="no">No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right" class="gray dwl_gray"><label><strong>Pause on Hover:</strong></label></td>
						<td valign="top">
							<select id="viewerHoverPause" name="viewerHoverPause">
							<option value="yes">Yes</option>
							<option value="no">No</option>
							</select>
						</td>
					</tr>
				</table>
			</div>
			
			<fieldset>
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td colspan="2">
							<label>Shortcode Preview</label>
							<textarea name="shortcode" rows="4" id="shortcode"></textarea>
						</td>
					</tr>
				</table>
			</fieldset>
			
			<div class="mceActionPanel">
				<div class="fl"><input type="button" id="insert" class="btn btn-primary" name="insert" value="Insert" onclick="AcsViewerInsertDialog.insert();" /></div>
         <div class="fr"><input type="button" id="cancel" name="cancel" value="Cancel" onclick="AcsViewerInsertDialog.close();"/></div>
			  </div>
      </form>

      <script type="text/javascript" src="<?php echo ACSVIEWER_WP_PLUGIN_URL ?>/js/acsviewer-dialog.js"></script>
      <script type="text/javascript" src="<?php echo ACSVIEWER_WP_PLUGIN_URL ?>/js/mcColorPicker.js"></script>

		</body>
</html>

<?php exit();

}
