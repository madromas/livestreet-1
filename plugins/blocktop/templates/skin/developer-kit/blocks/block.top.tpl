<section class="panel panel-default block block-type-top">
	<div class="panel-body">
		
		<header class="block-header">
			<h3>{$aLang.plugin.blocktop.top_block} <sup class="small">{$aLang.plugin.blocktop.top_block_time}</sup></h3>
		</header>
		
		<div class="block-content">
			{if $aTopTopics}
				<ul class="list-unstyled item-list">
					{foreach from=$aTopTopics item=oTopic name=foo}
						{assign var="oUser" value=$oTopic->getUser()}
						{assign var="oBlog" value=$oTopic->getBlog()}
						
						<li class="text-muted js-title-topic" title="{$oTopic->getText()|strip_tags|trim|truncate:150:'...'|escape:'html'}">
							<p class="small">
								<a href="{$oUser->getUserWebPath()}" class="author">{$oUser->getLogin()}</a>
								<time datetime="{date_format date=$oTopic->getDate() format='c'}">
									· {date_format date=$oTopic->getDateAdd() hours_back="12" minutes_back="60" now="60" day="day H:i" format="j F Y, H:i"}
								</time>
							</p>
							<a href="{$oBlog->getUrlFull()}" class="blog-name">{$oBlog->getTitle()|escape:'html'}</a> &rarr;
							<a href="{$oTopic->getUrl()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>
							<small class="text-danger">{$oTopic->getCountComment()}</small>
						</li>
					</article>
					
					{/foreach}
				</ul>
			{else}
				{$aLang.plugin.blocktop.top_no}
			{/if}
		</div>
		
	</div>
</section>