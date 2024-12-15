<div class="block block-type-stream">
	<header class="block-header sep">
		<h3>{$aLang.plugin.blocktop.top_block} {$aLang.plugin.blocktop.top_block_time}</h3>
	</header>
	
	<div class="block-content">
		{if $aTopTopics}
			<ul class="latest-list">
				{foreach from=$aTopTopics item=oTopic}
					{assign var="oUser" value=$oTopic->getUser()}
					{assign var="oBlog" value=$oTopic->getBlog()}
					<li class="js-title-topic" title="{$oTopic->getText()|strip_tags|trim|truncate:150:'...'|escape:'html'}">

						<a class="circle" href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" alt="avatar" class="avatar" /></a>

						<p>
							<a href="{$oUser->getUserWebPath()}" class="author">{$oUser->getLogin()}</a> &rarr; <a href="{$oBlog->getUrlFull()}" class="stream-blog">{$oBlog->getTitle()|escape:'html'}</a>
							<br>
							<time datetime="{date_format date=$oTopic->getDateAdd() format='c'}" title="{date_format date=$oTopic->getDateAdd() format="j F Y, H:i"}">
								{date_format date=$oTopic->getDateAdd() hours_back="12" minutes_back="60" now="60" day="day H:i" format="j F Y, H:i"}
							</time>
							<span class="block-item-comments"><i class="icon-synio-comments-small"></i>{$oTopic->getCountComment()}</span>
						</p>

						<a href="{$oTopic->getUrl()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>
					</li>						
				{/foreach}
			</ul>
		{else}
			{$aLang.plugin.blocktop.top_no}
		{/if}
	</div>	

</div>