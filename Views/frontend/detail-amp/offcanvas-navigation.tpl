{function name=categories level=0}
	{if $categories}
		<ul class="sw-sidebar--navigation sw-categories--navigation sw-navigation--list sw-is--level{$level}">
			{block name="frontend_detail-amp_categories_left_before"}{/block}
			{foreach $categories as $category}
				{block name="frontend_detail-amp_categories_left_entry"}
					<li class="sw-navigation--entry{if $category.flag} sw-is--active{/if}{if $category.subcategories} sw-has--sub-categories{/if}">
						<a class="sw-navigation--link{if $category.flag} sw-is--active{/if}{if $category.subcategories} sw-has--sub-categories{/if}"
							href="{$category.link}">
							{$category.description}
						</a>
						{block name="frontend_detail-amp_categories_left_entry_subcategories"}
							{if $category.subcategories}
								{call name=categories categories=$category.subcategories level=$level+1}
							{/if}
						{/block}
					</li>
				{/block}
			{/foreach}
			{block name="frontend_detail-amp_categories_left_after"}{/block}
		</ul>
	{/if}
{/function}

<amp-sidebar id="offcanvas-menu" layout="nodisplay">
	<a class="sw-navigation--entry sw-entry--close-off-canvas sw-btn sw-is--icon-right"
		on="tap:offcanvas-menu.close"
		href="#">
		{s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
		<i class="icon--cross"></i>
	</a>
	{if $sCategories}
		{call name="categories" categories=$sCategories}
	{else}
		{call name="categories" categories=$sMainCategories}
	{/if}
</amp-sidebar>