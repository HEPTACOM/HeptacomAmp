{block name='frontend_detail-amp_shop_navigation'}
	<div class="sw-header--navigation">
		{block name="frontend_detail-amp_shop_navigation_menu_button"}
			<button class="sw-btn" on="tap:offcanvas-menu.open">
				{block name="frontend_detail-amp_shop_navigation_menu_button_icon"}
					<i class="icon--menu"></i>
				{/block}
				{block name="frontend_detail-amp_shop_navigation_menu_button_text"}
					<span>Menü</span>
				{/block}
			</button>
		{/block}
		{block name='frontend_detail-amp_shop_navigation_search_form'}
			{* TODO always generate https url *}
			<form method="GET" action="{url controller='search' fullPath=true}" class="sw-main-search-form">
				{block name='frontend_detail-amp_shop_navigation_search_form_search-field'}
					<input type="search" placeholder="Suchbegriff..." maxlength="30" />
				{/block}
				{block name='frontend_detail-amp_shop_navigation_search_form_submit'}
					<button class="sw-btn" type="submit">
						{block name="frontend_detail-amp_shop_navigation_search_form_submit_icon"}
							<i class="icon--search"></i>
						{/block}
					</button>
				{/block}
			</form>
		{/block}
	</div>
{/block}