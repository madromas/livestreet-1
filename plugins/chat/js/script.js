/* -------------------------------------------------------
 *
 *   LiveStreet (1.x)
 *   Plugin Chat (free) (v.0.1)
 *   Copyright В© 2013 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
 * ---------------------------------------------------------
 */
var ls = ls || {};
ls.chat = ( function ($) {
    this.opacitykey = true;
    this.current_id = 0;
    this.chathide = 0;
    this.chatbox = null;
    this.chattop = null;
    this.workchat = false;
    this.date = new Date();

    this.set_cookes = function(name, value) {
        if (!ls.chat.date)ls.chat.date = new Date();
        document.cookie = name + "=" + escape(value) + "; expires=" + ls.chat.date.toGMTString() + "; path=/"
    };

    this.get_cookes = function(name) {
        var name = name + "=";
        var length = document.cookie.length;
        var begin = 0;
        var value;
        while (begin < length) {
            value = begin + name.length;
            if (document.cookie.substring(begin, value) == name) {
                var value_end = document.cookie.indexOf(";", value);
                if (value_end == -1) value_end = length;
                //return value_end;
                return unescape(document.cookie.substring(value, value_end));
            }
            begin = document.cookie.indexOf(" ", begin) + 1;
            if (begin == 0)break
        }
        return null;
    };

    this.get_chat = function() {
        if (ls.chat.workchat) {
            ls.ajax(aRouter['chat_ajax'] + 'getlist', {}, function (result) {
                    $('#chat-content').removeClass('load');
                    if (!result.bStateError) {
                        data = result.aList;
                        for (var i = 0; i < data.length; i++) {
                            if (ls.chat.current_id < parseInt(data[i].chat_id)) {
                                ls.chat.current_id = parseInt(data[i].chat_id);
                                //alert(mid);
                                var li_tpl;
                                if (ls.chat.current_id % 2 == 1)li_tpl = ' class="chatline"'; else li_tpl = '';
                                $('#chat-content > ul').html($('#chat-content > ul').html() + '<li' + li_tpl + '><strong title="' + data[i].date_add + '" rel="notooltip" onclick="if(SYSTEM_LOGIN){if ($(\'#chat-form input:first-child\').val() != \'\') $(\'#chat-form input:first-child\').val($(\'#chat-form input:first-child\').val()+this.innerHTML);else $(\'#chat-form input:first-child\').val(this.innerHTML);$(\'#chat-form input:first-child\').focus();}">' + data[i].user_login + '</strong>: ' + data[i].chat_text + '</li>');
                                $('#chat-content').scrollTop($('#chat-content > ul').height())
                            }
                        }
                    } else {
                        ls.msg.error(result.sMsgTitle, result.sMsg);
                    }
                }
            )
            window.setTimeout(ls.chat.get_chat, 52000)
        }
    };

    this.init = function(){
        ls.chat.date.setTime(ls.chat.date.getTime() + 30000000000);
        ls.chat.chatbox = $('#chat');
        ls.chat.chatbox.animate({opacity:'0.5'}, 1);
        ls.chat.chattop = ls.chat.get_cookes('chattop');
        if (ls.chat.chattop!=null) {
            ls.chat.chatbox.css('top', ls.chat.chattop + 'px');
            var chatleft = ls.chat.get_cookes('chatleft');
            if (chatleft){
                ls.chat.chatbox.css('left', chatleft + 'px')
            }
        } else {
            ls.chat.set_cookes('chatleft', ls.chat.chatbox.offset().left);
            ls.chat.set_cookes('chattop', document.getElementById('chat').offsetTop)
        }
        ls.chat.chathide = ls.chat.get_cookes('chathide');
        ls.chat.workchat = true;
        if (ls.chat.chathide!=0 && ls.chat.chathide!=null) {
            $('#chat-close').attr('title', 'Развернуть').addClass('inv');
            ls.chat.chatbox.css('top', $(window).height() - 17 + 'px');
            ls.chat.workchat = false
        }
        ls.chat.current_id = 0;
        ls.chat.get_chat();
    };

    return this;

}).call(ls.chat || {}, jQuery);

ls.chat.init();

ls.chat.chatbox.draggable({handle:$('#chat-header'), stop:function () {
    if (ls.chat.chatbox.offset().left >= $(window).width() - 10)ls.chat.chatbox.css('left', $(window).width() - 10 + 'px');
    if (document.getElementById('chat').offsetTop >= $(window).height() - (ls.chat.chatbox.height() + 10)) {
        ls.chat.set_cookes('chathide', 1);
        ls.chat.chatbox.css('top', $(window).height() - 20 + 'px');
        $('#chat-close').attr('title', 'Развернуть').addClass('inv');
        ls.chat.workchat = false
    } else {
        if (document.getElementById('chat').offsetTop < 0)ls.chat.chatbox.css('top', '0px');
        ls.chat.set_cookes('chattop', document.getElementById('chat').offsetTop);
        ls.chat.set_cookes('chathide', 0);
        $('#chat-close').attr('title', 'Свернуть').removeClass('inv');
        ls.chat.workchat = true;
        ls.chat.get_chat()
    }
    ls.chat.set_cookes('chatleft', ls.chat.chatbox.offset().left)
}});
ls.chat.chatbox.mouseenter(function () {
    ls.chat.chatbox.stop().animate({opacity:'1'}, 250);
    ls.chat.opacitykey = false;
});
ls.chat.chatbox.mouseleave(function () {
    if (!ls.chat.opacitykey)ls.chat.chatbox.stop().animate({opacity:'0.5'}, 250);
    ls.chat.opacitykey = true;
});
$('#chat-close').click(function () {
    if (document.getElementById('chat').offsetTop >= $(window).height() - 25) {
        ls.chat.chatbox.css('top', ls.chat.get_cookes('chattop') + 'px');
        $('#chat-close').attr('title', 'Свернуть').removeClass('inv');
        ls.chat.set_cookes('chathide', 0);
        ls.chat.workchat = true;
        var chatleft = ls.chat.get_cookes('chatleft');
        if (chatleft!=null && chatleft!=undefined) {
            ls.chat.chatbox.css('left', chatleft + 'px');
        }
        ls.chat.get_chat();
    } else {
        ls.chat.chatbox.css('top', $(window).height() - 20 + 'px');
        $('#chat-close').attr('title', 'Развернуть').addClass('inv');
        ls.chat.set_cookes('chathide', 1);
        ls.chat.workchat = false;
    }
});
$('#chat-form').submit(function () {
    var text = $('#chat_text').val();
    if (text != "") {
        $('#chat_text').val('');
        ls.ajax(aRouter['chat_ajax'] + 'add', {
                'text':text
            }, function (result) {
                if (!result.bStateError) {
                    ls.chat.get_chat();
                } else {
                    ls.msg.error(result.sMsgTitle, result.sMsg);
                }
            }
        )
        $('#chat_text').focus()
    }
    return false
});

