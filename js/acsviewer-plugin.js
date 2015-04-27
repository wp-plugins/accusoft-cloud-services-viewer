(function($, wp)
{
	tinymce.PluginManager.requireLangPack('acsviewer');
  tinymce.create('tinymce.plugins.AcsViewerPlugin',
	{
		init : function(ed,url)
		{
			ed.addCommand('mceAcsViewer', function()
			{
				ed.windowManager.open(
				{
          title: 'Create your Viewer',
					file : ajaxurl + '?action=acsviewer_dialog_window',
					width : 1000 + parseInt(ed.getLang('acsviewer.delta_width',0)),
					height : 800 + parseInt(ed.getLang('acsviewer.delta_height',0)),
					inline : 1,
        },
				{
					plugin_url : url,
          wp: wp,
          jQuery : $
				})
			});
			ed.addButton('acsviewer',
			{
				title : 'Accusoft Cloud Services Viewer',
				cmd : 'mceAcsViewer',
				image : url.substr(0,url.indexOf("plugins/accusoft-cloud-services-viewer") + 38) + '/images/acsviewer.png',
        stateSelector: 'img'
			});
    },
		createControl : function(n,cm)
		{
			return null
		},
		getInfo : function()
		{
			return {
					longname : 'Accusoft Cloud Services Viewer',
					author : 'Accusoft Corporation',
					authorurl : 'http://www.accusoft.com',
					infourl : 'http://www.accusoft.com/cloud-services/viewer/',
					version : "1.7"
			};
		}
	});

	tinymce.PluginManager.add('acsviewer',tinymce.plugins.AcsViewerPlugin)
})(jQuery, wp);
