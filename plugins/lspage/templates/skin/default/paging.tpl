{if $aPaging and $aPaging.iCountPage>1} 
	<div class="paginator" id="lspage"></div>
	{literal}
	<script type="text/javascript">
		lspage = new Paginator(
			"lspage", // id контейнера, куда ляжет пагинатор
			{/literal}{$aPaging.iCountPage}{literal}, // общее число страниц
			{/literal}{cfg name="plugin.lspage.visible_pages"}{literal}, // число страниц, видимых одновременно
			{/literal}{$aPaging.iCurrentPage}{literal}, // номер текущей страницы
			"{/literal}{$aPaging.sBaseUrl}/page{literal}", // url страниц
			"{/literal}{if $sAction=='search'}/{/if}{$aPaging.sGetParams}{literal}"
		);
	</script>
	{/literal}
			<div id="pagination" style="display: none;">
				<ul>
					{if $aPaging.iCurrentPage>1}
						<li><a href="{$aPaging.sBaseUrl}/{$aPaging.sGetParams}">{$aLang.paging_first}</a></li>
					{/if}
					{foreach from=$aPaging.aPagesLeft item=iPage}
						<li><a href="{$aPaging.sBaseUrl}/page{$iPage}/{$aPaging.sGetParams}">{$iPage}</a></li>
					{/foreach}
					<li class="active">{$aPaging.iCurrentPage}</li>
					{foreach from=$aPaging.aPagesRight item=iPage}
						<li><a href="{$aPaging.sBaseUrl}/page{$iPage}/{$aPaging.sGetParams}">{$iPage}</a></li>
					{/foreach}
					{if $aPaging.iCurrentPage<$aPaging.iCountPage}
						<li><a href="{$aPaging.sBaseUrl}/page{$aPaging.iCountPage}/{$aPaging.sGetParams}">{$aLang.paging_last}</a></li>
					{/if}					
				</ul>
			</div>
{/if}