{block name="frontend_heptacom_amp_body_article_buybox"}
	<div class="sw-product--buybox">
		{include file="frontend/heptacom_amp/body/article/buybox/laststock.tpl"}
		{include file="frontend/heptacom_amp/body/article/buybox/configurators.tpl"}

		{block name="frontend_heptacom_amp_body_article_buybox_formular"}
			<form method="GET" target="_top" action="{url controller=checkout action=addArticle}" class="sw-buybox--form">
				{include file="frontend/heptacom_amp/body/article/buybox/hidden_values.tpl"}

				{if (!isset($sArticle.active) || $sArticle.active)}
					{if $sArticle.isAvailable}
						{block name="frontend_heptacom_amp_body_article_buybox_formular_buttongroup"}
							<div class="sw-buybox--button-container sw-block-group{if $NotifyHideBasket && $sArticle.notification && $sArticle.instock <= 0} sw-is--hidden{/if}">
								{include file="frontend/heptacom_amp/body/article/buybox/button.tpl"}
							</div>
						{/block}
					{/if}
				{/if}
			</form>
		{/block}
	</div>
{/block}
