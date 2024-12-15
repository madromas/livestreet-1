<section class="panel panel-default block block-type-userstop">
	<div class="panel-body">
	
		<header class="block-header">
			<h3>{$aLang.plugin.usertop.title_block}</h3>
		</header>
		
		<div class="block-content">
			<ul class="list-unstyled item-list">
				{foreach from=$aUsertop item=oUser}
					<li>
						<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(24)}" alt="{$oUser->getLogin()}" class="avatar" /></a>
						<a href="{$oUser->getUserWebPath()}" class="user">{$oUser->getLogin()}</a>
						<small class="text-success pull-right">{$oUser->getRating()}</small>
					</li>
				{/foreach}
			</ul>
			
			<footer class="small text-muted">
				<a href="{router page='people'}">{$aLang.plugin.usertop.all_users}</a>
			</footer>
		</div>
		
	</div>
</section>