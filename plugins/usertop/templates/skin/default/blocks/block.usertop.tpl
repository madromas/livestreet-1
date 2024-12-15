<div class="block usertop block-type-blogs">
	<header class="block-header sep">	
		<h3>{$aLang.plugin.usertop.title_block}</h3>
	</header>

	<div class="block-content">
	
		<ul class="usertop block-blog-list">
			{foreach from=$aUsertop item=oUser name="cmt"}
				<li>
					<a href="{$oUser->getUserWebPath()}" class="user">{$oUser->getLogin()}</a>
					<strong>{$oUser->getRating()}</strong>
				</li>
			{/foreach}
		</ul>
		
		<footer>
			<a href="{router page='people'}">{$aLang.plugin.usertop.all_users}</a>
		</footer>
		
	</div>	
</div>