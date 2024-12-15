{if $oUserCurrent}
    {literal}
    <script language="JavaScript" type="text/javascript">
            $(document).ready(function(){
            $('.show_hide_lenta').click(function(){
            $("#block-blog-list").slideToggle("show", function() {
            if ($("#block-blog-list").css('display') == 'none'){
            $(".show_hide_lenta").text('{/literal}{$aLang.plugin.ll.block_blog_lenta_settings_show}{literal}');
} else {
        $(".show_hide_lenta").text('{/literal}{$aLang.plugin.ll.block_blog_lenta_settings_hide}{literal}');
}
});
    return false;
});
});
</script>
{/literal}
<section class="block">
    <header class="block-header sep">
        <h3>{$aLang.userfeed_block_blogs_title}</h3><br />

        <p class="note">{$aLang.userfeed_settings_note_follow_blogs}</p>
    </header>
    {if count($aBlogs)}
        <div class="block-content" id="block-blog-list" style="display: none;">
            <ul>
                {foreach from=$aBlogs item=oBlog}
                    {assign var=iBlogId value=$oBlog->getId()}
                    <li>
                        <input class="userfeedBlogCheckbox input-checkbox"
                               type="checkbox" {if isset($aUserfeedSubscribedBlogs.$iBlogId)} checked="checked"{/if}
                               onClick="if (this.checked) { ls.userfeed.subscribe('blogs',{$iBlogId}) } else { ls.userfeed.unsubscribe('blogs',{$iBlogId}) } "/>
                        <a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>
                        {if $oBlog->getType()=='close'}
                            <i title="{$aLang.blog_closed}" class="icon-lock"></i>
                        {/if}
                    </li>
                {/foreach}
            </ul>
        </div>
        <a href="#" class="show_hide_lenta">{$aLang.plugin.ll.block_blog_lenta_settings_show}</a>
        {else}
        <p>{$aLang.userfeed_no_blogs}</p>
    {/if}
</section>
{/if}