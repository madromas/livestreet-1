var ls = ls || {};

/**
* Различные настройки
*/
ls.settings = (function ($) {

	this.getMarkitup = function() {
		return {
			onShiftEnter:  	{keepDefault:false, replaceWith:'<br />\n'},
			onCtrlEnter:  	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
			onTab:    		{keepDefault:false, replaceWith:'    '},
			nameSpace:          "markItUp", // Useful to prevent multi-instances CSS conflict
			markupSet:  [
			{name:'Цвет текста', className:'editor-color', openWith:'<font color="[![Color]!]">', closeWith:'</font>', dropMenu: [
          {name:'', openWith:'<font color="orange">', closeWith:'</font>', className:'col1-2' },
          {name:'', openWith:'<font color="red">', closeWith:'</font>', className:'col1-3' },
          {name:'', openWith:'<font color="blue">', closeWith:'</font>', className:'col2-1' },
          {name:'', openWith:'<font color="purple">', closeWith:'</font>', className:'col2-2' },
          {name:'', openWith:'<font color="green">', closeWith:'</font>', className:'col2-3' },
          {name:'', openWith:'<font color="gray">', closeWith:'</font>', className:'col3-2' },
          {name:'', openWith:'<font color="black">', closeWith:'</font>', className:'col3-3' }
            ]},
		  {separator:'---------------' },
				{name:'H4', className:'editor-h4', openWith:'<h4>', closeWith:'</h4>' },
				{name:'H5', className:'editor-h5', openWith:'<h5>', closeWith:'</h5>' },
				{name:'H6', className:'editor-h6', openWith:'<h6>', closeWith:'</h6>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_b'), className:'editor-bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
				{name: ls.lang.get('panel_i'), className:'editor-italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },
				{name: ls.lang.get('panel_s'), className:'editor-stroke', key:'S', openWith:'<s>', closeWith:'</s>' },
				{name: ls.lang.get('panel_u'), className:'editor-underline', key:'U', openWith:'<u>', closeWith:'</u>' },
				{name: ls.lang.get('panel_quote'), className:'editor-quote', key:'Q', replaceWith: function(m) { if (m.selectionOuter) return '<blockquote>'+m.selectionOuter+'</blockquote>'; else if (m.selection) return '<blockquote>'+m.selection+'</blockquote>'; else return '<blockquote></blockquote>' } },
				{name: ls.lang.get('panel_code'), className:'editor-code', openWith:'<code>', closeWith:'</code>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_list'), className:'editor-ul', openWith:'    <li>', closeWith:'</li>', multiline: true, openBlockWith:'<ul>\n', closeBlockWith:'\n</ul>' },
				{name: ls.lang.get('panel_list'), className:'editor-ol', openWith:'    <li>', closeWith:'</li>', multiline: true, openBlockWith:'<ol>\n', closeBlockWith:'\n</ol>' },
				{name: ls.lang.get('panel_list_li'), className:'editor-li', openWith:'<li>', closeWith:'</li>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_image'), className:'editor-picture', key:'P', beforeInsert: function(h) { jQuery('#window_upload_img').jqmShow(); } },
				{name: ls.lang.get('panel_video'), className:'editor-video', replaceWith:'<video>[!['+ls.lang.get('panel_video_promt')+':!:http://]!]</video>' },
				{name: ls.lang.get('panel_url'), className:'editor-link', key:'L', openWith:'<a href="[!['+ls.lang.get('panel_url_promt')+':!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
				{name: ls.lang.get('panel_user'), className:'editor-user', replaceWith:'<ls user="[!['+ls.lang.get('panel_user_promt')+']!]" />' },
				{name: ls.lang.get('panel_vid'), className:'editor-vid', replaceWith:'<vid>[!['+ls.lang.get('panel_vid_promt')+':!:http://]!]</vid>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_clear_tags'), className:'editor-clean', replaceWith: function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
				{name: ls.lang.get('panel_cut'), className:'editor-cut', replaceWith: function(markitup) { if (markitup.selection) return '<cut name="'+markitup.selection+'">'; else return '<cut>' }},
			    {separator:'---------------' },
				{name: ls.lang.get('panel_spoiler'), className: 'editor-spoiler', replaceWith:'<spoiler title="Скрытый текст">[!['+ls.lang.get('panel_spoiler_promt')+']!]</spoiler>' },
			]
		}
	};

	this.getMarkitupComment = function() {
		return {
			onShiftEnter:  	{keepDefault:false, replaceWith:'<br />\n'},
			onTab:    		{keepDefault:false, replaceWith:'    '},
			markupSet:  [
				{name: ls.lang.get('panel_b'), className:'editor-bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
				{name: ls.lang.get('panel_i'), className:'editor-italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },
				{name: ls.lang.get('panel_s'), className:'editor-stroke', key:'S', openWith:'<s>', closeWith:'</s>' },
				{name: ls.lang.get('panel_u'), className:'editor-underline', key:'U', openWith:'<u>', closeWith:'</u>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_quote'), className:'editor-quote', key:'Q', replaceWith: function(m) { if (m.selectionOuter) return '<blockquote>'+m.selectionOuter+'</blockquote>'; else if (m.selection) return '<blockquote>'+m.selection+'</blockquote>'; else return '<blockquote></blockquote>' } },
				{name: ls.lang.get('panel_code'), className:'editor-code', openWith:'<code>', closeWith:'</code>' },
				{name: ls.lang.get('panel_image'), className:'editor-picture', key:'P', beforeInsert: function(h) { jQuery('#window_upload_img').jqmShow(); } },
				{name: ls.lang.get('panel_url'), className:'editor-link', key:'L', openWith:'<a href="[!['+ls.lang.get('panel_url_promt')+':!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
				{name: ls.lang.get('panel_user'), className:'editor-user', replaceWith:'<ls user="[!['+ls.lang.get('panel_user_promt')+']!]" />' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_clear_tags'), className:'editor-clean', replaceWith: function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
			    {separator:'---------------' },
				{name: ls.lang.get('panel_spoiler'), className: 'editor-spoiler', replaceWith:'<spoiler title="Скрытый текст">[!['+ls.lang.get('panel_spoiler_promt')+']!]</spoiler>' },
			]
		}
	};

	this.getTinymce = function() {
		return {
			mode : 									"specific_textareas",
			editor_selector : 						"mce-editor",
			theme : 								"advanced",
			content_css : 							DIR_STATIC_SKIN + "/css/reset.css" + "," + DIR_STATIC_SKIN + "/css/tinymce.css?" + new Date().getTime(),
			theme_advanced_toolbar_location : 		"top",
			theme_advanced_toolbar_align : 			"left",
			theme_advanced_buttons1 : 				"lshselect,bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo,|,lslink,unlink,lsvideo,lsimage,pagebreak,code",
			theme_advanced_buttons2 : 				"",
			theme_advanced_buttons3 : 				"",
			theme_advanced_statusbar_location : 	"bottom",
			theme_advanced_resizing : 				true,
			theme_advanced_resize_horizontal : 		0,
			theme_advanced_resizing_use_cookie : 	0,
			theme_advanced_path : 					false,
			object_resizing : 						true,
			force_br_newlines :						true,
			forced_root_block : 					'', // Needed for 3.x
			force_p_newlines : 						false,
			plugins : 								"lseditor,safari,inlinepopups,media,pagebreak,autoresize",
			convert_urls : 							false,
			extended_valid_elements : 				"embed[src|type|allowscriptaccess|allowfullscreen|width|height]",
			pagebreak_separator :					"<cut>",
			media_strict : 							false,
			language : 								TINYMCE_LANG,
			inline_styles:							false,
			formats : {
				underline : 	{inline : 'u', exact : true},
				strikethrough : {inline : 's', exact : true}
			}
		}
	};

	this.getTinymceComment = function() {
		return {
			mode : 									"textareas",
			theme : 								"advanced",
			content_css : 							DIR_STATIC_SKIN + "/css/reset.css" + "," + DIR_STATIC_SKIN + "/css/tinymce.css?" + new Date().getTime(),
			theme_advanced_toolbar_location : 		"top",
			theme_advanced_toolbar_align : 			"left",
			theme_advanced_buttons1 : 				"bold,italic,underline,strikethrough,lslink,lsquote",
			theme_advanced_buttons2 : 				"",
			theme_advanced_buttons3 : 				"",
			theme_advanced_statusbar_location : 	"bottom",
			theme_advanced_resizing : 				true,
			theme_advanced_resize_horizontal : 		0,
			theme_advanced_resizing_use_cookie : 	0,
			theme_advanced_path : 					false,
			object_resizing : 						true,
			force_br_newlines : 					true,
			forced_root_block : 					'', // Needed for 3.x
			force_p_newlines : 						false,
			plugins : 								"lseditor,safari,inlinepopups,media,pagebreak,autoresize",
			convert_urls : 							false,
			extended_valid_elements : 				"embed[src|type|allowscriptaccess|allowfullscreen|width|height]",
			pagebreak_separator :					"<cut>",
			media_strict : 							false,
			language : 								TINYMCE_LANG,
			inline_styles:							false,
			formats : {
				underline : 	{inline : 'u', exact : true},
				strikethrough : {inline : 's', exact : true}
			},
			setup : function(ed) {
				// Display an alert onclick
				ed.onKeyPress.add(function(ed, e) {
					key = e.keyCode || e.which;
					if(e.ctrlKey && (key == 13)) {
						$('#comment-button-submit').click();
						return false;
					}
				});
			}
		}
	};

	return this;
}).call(ls.settings || {},jQuery);
