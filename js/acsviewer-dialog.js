if(top.tinymce.majorVersion < '4') {
       tinyMCEPopup.requireLangPack();
}	
var AcsViewerInsertDialog =
{
	init : function()
	{
		jQuery('input[name=viewerType], input[name=viewerPrintButton], #viewerDocument').on("click", function()
		{
      buildShortcode();
		});
		jQuery('#licenseKey, #viewerWidth, #viewerHeight, #viewerToolbarColor, #viewerDocument, #viewerAnimDuration, #viewerAnimSpeed').on("blur", function()
		{
			buildShortcode();
		});
		jQuery('#viewerAnimType, #viewerAutomatic, #viewerShowControls, #viewerCenterControls, #viewerKeyboardNav, #viewerHoverPause, #viewerDocument').change(function()
		{
			buildShortcode();
		});	
	},
	insert : function()
	{
      // insert the contents from the input into the document
      if(top.tinymce.majorVersion < '4') {
        tinyMCEPopup.editor.execCommand("mceInsertContent", false, jQuery("#shortcode").val());
        tinyMCEPopup.close();
      }
      else {
        top.tinymce.activeEditor.insertContent(jQuery("#shortcode").val());
        top.tinymce.activeEditor.windowManager.close(this);
      }

	},
  close : function()
  {
     if(top.tinymce.majorVersion == '4') {
        top.tinymce.activeEditor.windowManager.close(this);
     }
  }
};

function pcSettings(viewerType)
{
	if (viewerType == "slideshow")
	{
		jQuery("#slideshowViewer").removeClass("hide").addClass("show");
		jQuery("#documentViewer").removeClass("show").addClass("hide");
	}
	else
	{
		jQuery("#slideshowViewer").removeClass("show").addClass("hide");
		jQuery("#documentViewer").removeClass("hide").addClass("show");
	}
  buildShortcode();
}

function buildShortcode()
{
	var shortcode = 'acsviewer';			
	var licenseKey = jQuery("#licenseKey").val();
  var licenseKeyInput = '';
  if(jQuery("#licenseKeyInput").length > 0) {
    licenseKeyInput = jQuery("#licenseKeyInput").val();
  }
	var viewerType = jQuery("input[name=viewerType]:checked").val();
	var document = jQuery("#viewerDocument").val();
	var viewerWidth = jQuery("#viewerWidth").val();
	var viewerHeight = jQuery("#viewerHeight").val();
	var toolbarColor = jQuery("#viewerToolbarColor").val();
	toolbarColor = toolbarColor.replace("#","");
	var printButton = jQuery("input[name=viewerPrintButton]:checked").val();
	
	var animType = jQuery("#viewerAnimType").val();
	var animDuration = jQuery("#viewerAnimDuration").val();
	var animSpeed = jQuery("#viewerAnimSpeed").val();
	var automatic = jQuery("#viewerAutomatic").val();
	var showControls = jQuery("#viewerShowControls").val();
	var centerControls = jQuery("#viewerCenterControls").val();
	var keyboardNav = jQuery("#viewerKeyboardNav").val();
	var hoverPause = jQuery("#viewerHoverPause").val();
	
	if (licenseKeyInput.length > 0)
	{
		shortcode += ' key="' + licenseKeyInput + '"';
	}
	
	if (viewerType.length > 0)
	{
		shortcode += ' type="' + viewerType + '"';
	}
	
	if (document.length > 0)
	{
		shortcode += ' document="' + document + '"';
	}
	
	if (viewerWidth.length > 0)
	{
		shortcode += ' width="' + viewerWidth + '"';
	}
	
	if (viewerHeight.length > 0)
	{
		shortcode += ' height="' + viewerHeight + '"';
	}
	
	if (viewerType != 'slideshow')
	{
		if (printButton.length > 0)
		{
			shortcode += ' print="' + printButton + '"';
		}
		
		if (toolbarColor.length > 0)
		{
			shortcode += ' color="' + toolbarColor + '"';
		}
	}
	else
	{
		if (animType.length > 0)
		{
			shortcode += ' animtype="' + animType + '"';
		}
		
		if (animDuration.length > 0)
		{
			shortcode += ' animduration="' + animDuration + '"';
		}
		
		if (animSpeed.length > 0)
		{
			shortcode += ' animspeed="' + animSpeed + '"';
		}
		
		if (automatic.length > 0)
		{
			shortcode += ' automatic="' + automatic + '"';
		}
		
		if (showControls.length > 0)
		{
			shortcode += ' showcontrols="' + showControls + '"';
		}
		
		if (centerControls.length > 0)
		{
			shortcode += ' centercontrols="' + centerControls + '"';
		}
		
		if (keyboardNav.length > 0)
		{
			shortcode += ' keyboardnav="' + keyboardNav + '"';
		}
		
		if (hoverPause.length > 0)
		{
			shortcode += ' hoverpause="' + hoverPause + '"';
		}
	}
	
	jQuery('#shortcode').val('['+shortcode+']');
}

if(top.tinymce.majorVersion < '4') {
      tinyMCEPopup.onInit.add(AcsViewerInsertDialog.init, AcsViewerInsertDialog);
}
else {
      AcsViewerInsertDialog.init();
}
