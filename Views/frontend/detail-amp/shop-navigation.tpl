{block name='frontend_detail-amp_shop_navigation'}
	<div class="sw-header--navigation">
		{block name='frontend_detail-amp_shop_navigation_search_form'}
			{* TODO always generate https url *}
			<form method="GET" action="{url controller='search' fullPath=true}">
				{block name='frontend_detail-amp_shop_navigation_search_form_search-field'}
					<input type="search" maxlength="30" />
				{/block}
				{block name='frontend_detail-amp_shop_navigation_search_form_submit'}
					<button type="submit">
						Suche
						{* TODO implement icons }
						{block name='frontend_detail-amp_shop_navigation_search_form_submit_icon'}
							<i class="icon--search"></i>
						{/block*}
					</button>
				{/block}
			</form>
		{/block}
	</div>
{/block}