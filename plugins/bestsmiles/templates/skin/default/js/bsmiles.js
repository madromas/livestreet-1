$(document).ready(function(){
	$.getJSON(DIR_WEB_ROOT + '/bestsmiles/list/', {security_ls_key: LIVESTREET_SECURITY_KEY}, function(data, tS){
		if(data){
			//вызываем функцию по замену смайлов в тексте
			setSmile(data.aSmiles);
		};
	});

	function setSmile(smiles) {
		selector = '.text, .stream-comment-preview, .blog-description, .profile-info-about p';
		if(bsFlowOn) {
			selector += ', .flow-block-content';
		}	
		$(selector).each(function(index){
			sText = $(this).html();
			if(sText != null) {
				//$(this).html(sText.replace(/\{([a-zA-Z0-9-;:\/\%][\*\)\(_]*.)+\}/g, function(str, smile){
				$(this).html(sText.replace(/([:;A-Z0-9%]*[_]?[\/\\a-zA-Z-\)\(\*]*)+/g, function(str, smile){
					//если смайлик есть в списке
					if(smiles[smile] != undefined) {
						return "<span class='smile' style='background-position:" + smiles[smile] + "'></span>";
					} else {
						return str;
					}
				}));
			}
		});
	}

	//После добавления комментария заменяем смайлики в нем на изображения
	ls.hook.add('ls_comments_add_after',function() {
		$.getJSON(DIR_WEB_ROOT + '/bestsmiles/list/', {security_ls_key: LIVESTREET_SECURITY_KEY}, function(data, tS){
			if(data){
				setSmile(data.aSmiles);
			};
		});
	});
});

(function($){
	//список смайлов
	var smiles;
	
	var methods = {
		init: function(settings) {
			methods.initMarkitup.apply(this, arguments);
		},
		
		//markitup
		//init
		initMarkitup: function(settings){
			//Меняем настройки markitup
			settings.markupSet.push({
				separator: '-'
			});
			settings.markupSet.push({
				name: "Смайлики",
				className: "bsEditor",
				beforeInsert: function(action) {
					$(action.textarea).bestsmiles('toggle');
				}
			});
		},
		
		//переключение
		toggle: function() {
			return this.each(function(){
				var list = methods.getList.apply(this);
				list.toggleClass('smilesHide');
			});
		},
		
		
		//получаем список
		getList: function() {
			var textarea = $(this);
			var tid = textarea.attr('id');
			var lid = 'bsAllList_' + tid;
			var list = $('#bsAllList_' + tid);

			if(list.size()){
				return list;
			}

			list = $('<div class="bsAllList smilesHide"/>').attr('id', lid).insertBefore(textarea);
			var listWrap = $('<div></div>').width('auto').insertBefore(textarea);

			if(!smiles){
				$.getJSON(DIR_WEB_ROOT + '/bestsmiles/list/', {security_ls_key: LIVESTREET_SECURITY_KEY}, function(data, tS){
					if(data){
						smiles = data.aSmiles;
						methods.insertSmiles.apply(textarea, [list]);
					};
				});
			}
			
			return list.appendTo(listWrap);
		},

		//вставка смайлов
		insertSmiles: function(list){
			var textarea = $(this);
			//очищаем
			list.empty();

			$.each(smiles, function(smile, pos){
				var smileIm = $("<span class='smile' style='background-position:" + pos + "'></span>");
				//<a>, т.к. нужен атрибут title
				var button = $("<a href='#'></a>").attr('title', smile).data({'bsSmile': smile, 'bsArea': textarea.attr('id')});
				
				button.click(function(){
					$.markItUp({
						replaceWith: $(this).data('bsSmile'),
						target: '#' +$(this).data('bsArea')
					});
					return false;
				});

				//выполняем функции
				button.append(smileIm);
				list.append(button);
			});
		}
		
	};

	$.fn.bestsmiles = function(method) {
		if(method === 'methods') {
			return methods;
		} 
		else if(methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} 
		else if(typeof method === 'object' || !method){
			return methods.init.apply(this, arguments);
		}		
	
	};
	
	$.bsStart = function(){
		if(typeof $.fn.markItUp == 'function'){
			ls.hook.inject([jQuery.fn, 'markItUp'], function(settings, extraSettings){
				this.bestsmiles('methods').initMarkitup(settings || {markupSet : []});
			});
		}
	};
})(jQuery);



$(function($){
	$.bsStart();
});
