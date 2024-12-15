<div class="block usertop block-type-blogs">
	<header class="block-header sep">	
		<h3><i class="fontello icon-users"></i> {$aLang.plugin.usertop.title_block}</h3>
	</header>

	<div class="block-content">
	
		<ul class="blog-list-avatar">
			{foreach from=$aUsertop item=oUser name="cmt"}
				<li>
					<a href="{$oUser->getUserWebPath()}" class="js-tip-help" title="{$oUser->getLogin()}"><img src="{$oUser->getProfileAvatarPath(64)}" /></a>
				</li>
			{/foreach}
		</ul>
		
		<footer>
			<a href="{router page='people'}">{$aLang.plugin.usertop.all_users}</a>
		</footer>
		
	</div>	
</div>