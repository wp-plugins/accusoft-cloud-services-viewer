'use strict';

if (top.tinymce.majorVersion < '4') {
       tinyMCEPopup.requireLangPack();
}

var args = top.tinymce.activeEditor.windowManager.getParams();
console.log(args.jQuery);
var wp = args.wp;
var $ = args.jQuery;
var context = document.getElementsByTagName("body")[0];

var AcsViewerInsertDialog =
  {
    init : function () {
      console.log($('#viewerheight', context).val());
    },
	  insert : function()
	  {
      // insert the contents from the input into the document
      if(top.tinymce.majorVersion < '4') {
        tinyMCEPopup.editor.execCommand("mceInsertContent", false, $("#codeBox", context).val());
        tinyMCEPopup.close();
      }
      else {
        top.tinymce.activeEditor.insertContent($("#codeBox", context).val());
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




if(top.tinymce.majorVersion < '4') {
      tinyMCEPopup.onInit.add(AcsViewerInsertDialog.init, AcsViewerInsertDialog);
}
else {
      AcsViewerInsertDialog.init();
}

var custom_uploader;

$('#accusoft_upload_button', context).click(function(e) {
    e.preventDefault();

    var $upload_button = $(this);

    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Document',
        button: {
            text: 'Choose Document'
        },
        multiple: false
    });

    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on('select', function() {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        $upload_button.closest('body').find('#document').val(attachment.url);
        $upload_button.closest('body').find('#document').trigger("input");
    });

    //Open the uploader dialog
    custom_uploader.open();

});

$('a[href="#collapseFour"]', context).on("click", function () {
  console.log("test");
  AcsViewerInsertDialog.insert();
});

$('#cancelButton', context).on("click", function () {
  AcsViewerInsertDialog.close();
});