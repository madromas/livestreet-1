{if $oUserCurrent}
<script type="text/javascript">var SYSTEM_LOGIN = '{$oUserCurrent->getLogin()}';</script>

<div id="chat">
    <div id="chat-header">{$aLang.plugin.chat.pop_header}<div id="chat-close" title="{$aLang.plugin.chat.pop_hearer_hide}"></div></div>
    <div id="chat-content" class="load">
        <ul></ul>
    </div>
    <form id="chat-form" action="{cfg name='path.root.web'}/">
        <input class="text" id="chat_text" type="text"{$aLang.plugin.chat.form_placeholder} placeholder="Ваше сообщение..." />
        <input type="submit" id="chat_button" value="" class="button-chat" {if !$oUserCurrent} disabled="disabled"{else}{/if} />
    </form>
    <div style="clear: both"></div>
</div>

<script src="{cfg name='path.root.web'}/plugins/chat/js/jquery-ui.js" language="JavaScript" type="text/javascript"></script>
<script src="{cfg name='path.root.web'}/plugins/chat/js/script.js" language="JavaScript" type="text/javascript"></script>

{/if}