{block name="frontend_heptacom_amp_body_article_data_delivery"}
	{* Delivery informations *}
	{if ($sArticle.sConfiguratorSettings.type != 1 && $sArticle.sConfiguratorSettings.type != 2) || $activeConfiguratorSelection == true}
		{include file="frontend/plugins/index/delivery_informations.tpl" sArticle=$sArticle}
	{/if}
{/block}
