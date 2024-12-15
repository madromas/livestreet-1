{if $aSimilarTopics|@count}
                        <div class="block stream" style="padding-left:40px;padding-bottom:15px;">
                                                <span style="font-weight:bold;color:#66b746;">
{$aLang.block_similar_articles_title}</span>
                                        <div class="block-content">
                                        <ul class="stream-content">
                                                {foreach from=$aSimilarTopics item=oTopic name="cmt"}
                                                        {assign var="oBlog" value=$oTopic->getBlog()}
                                                        {assign var="oUser" value=$oTopic->getUser()}

                                                        <li {if $smarty.foreach.cmt.iteration % 2 == 1}class="even"{/if}>
                                                                <a href="{$oUser->getUserWebPath()}" class="stream-author">{$oUser->getLogin()}</a> →
                                                                <a href="{$oTopic->getUrl()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>
                                                                <span> ({$oTopic->getCountComment()})</span> РІ <a href="{$oBlog->getUrlFull()}" class="stream-blog">{$oBlog->getTitle()|escape:'html'}</a>
                                                        </li>
                                                {/foreach}
                                        </ul>
                        
                        </div>
 </div>
                        {/if}