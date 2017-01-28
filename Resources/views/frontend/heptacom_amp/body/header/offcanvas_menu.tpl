{function name=categories level=0}
	{if $categories}
		<ul class="sw-sidebar--navigation sw-categories--navigation sw-navigation--list sw-is--level{$level}">
			{block name="frontend_heptacom_amp_body_header_offcanvas_menu_group"}
				{foreach $categories as $category}
					{block name="frontend_heptacom_amp_body_header_offcanvas_menu_entry"}
						<li class="sw-navigation--entry{if $category.flag} sw-is--active{/if}{if $category.subcategories} sw-has--sub-categories{/if}">
							<a class="sw-navigation--link{if $category.flag} sw-is--active{/if}{if $category.subcategories} sw-has--sub-categories{/if}"
								href="{$category.link}">
								{$category.description}
							</a>
							{block name="frontend_heptacom_amp_body_header_offcanvas_menu_subgroup"}
								{if $category.subcategories}
									{call name=categories categories=$category.subcategories level=$level+1}
								{/if}
							{/block}
						</li>
					{/block}
				{/foreach}
			{/block}
		</ul>
	{/if}
{/function}

{block name="frontend_heptacom_amp_body_header_offcanvas_menu"}
	<amp-sidebar id="offcanvas-menu" layout="nodisplay">
		{block name="frontend_heptacom_amp_body_header_offcanvas_menu_close"}
			<a class="sw-navigation--entry sw-entry--close-off-canvas sw-btn sw-is--icon-right"
				on="tap:offcanvas-menu.close"
				href="#">
				{s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
				<i class="icon--cross"></i>
			</a>
		{/block}
		{if $sCategories}
			{call name="categories" categories=$sCategories}
		{else}
			{call name="categories" categories=$sMainCategories}
		{/if}
	</amp-sidebar>
{/block}