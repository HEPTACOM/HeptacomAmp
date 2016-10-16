{block name="frontend_heptacom_amp_shop_navigation"}
	<div class="sw-header--navigation">
		{block name="frontend_heptacom_amp_shop_navigation_menu_button"}
			<div class="sw-header--navigation-item sw-header--navigation-item--btn">
				<button class="sw-btn"
					on="tap:offcanvas-menu.open">
					{block name="frontend_heptacom_amp_shop_navigation_menu_button_icon"}
						<i class="icon--menu"></i>
					{/block}
					{block name="frontend_heptacom_amp_shop_navigation_menu_button_text"}
						<span>Menü</span>
					{/block}
				</button>
			</div>
		{/block}
		{block name="frontend_heptacom_amp_shop_navigation_search_form"}
			{* TODO always generate https url *}
			<form method="GET"
				target="_top"
				action="{url controller='search' fullPath=true}"
				class="sw-main-search-form sw-header--navigation-item">
				{block name="frontend_heptacom_amp_shop_navigation_search_form_search-field"}
					<input type="search" name="sSearch" placeholder="Suchbegriff..." maxlength="30" />
				{/block}
			</form>
		{/block}
	</div>
{/block}
