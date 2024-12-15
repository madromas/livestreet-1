{if count($aCTopics)>0}
    {foreach from=$aCTopics item=oCTopic}
        {assign var="sTopicTemplateName" value="topic_`$oCTopic->getType()`.tpl"}
        {include file=$sTopicTemplateName bTopicList=true oTopic=$oCTopic}
    {/foreach}
{/if}