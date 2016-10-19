{* "Buy now" button *}
{block name="frontend_heptacom_amp_body_article_buybox_formular_buttongroup_buy"}
	{if $sArticle.sConfigurator && !$activeConfiguratorSelection}
		{include file="frontend/heptacom_amp/body/article/buybox/button_forward.tpl"}
	{else}
		{include file="frontend/heptacom_amp/body/article/buybox/quantity.tpl"}
		{include file="frontend/heptacom_amp/body/article/buybox/button_buy.tpl"}
	{/if}
{/block}
