{* Configurator drop down menu's *}
{if (!isset($sArticle.active) || $sArticle.active) && $sArticle.isAvailable && $sArticle.sConfigurator}
	{block name="frontend_heptacom_amp_body_article_buybox_configurators"}
		{if $sArticle.sConfiguratorSettings.type == 0}
			{include file="frontend/heptacom_amp/body/article/buybox/configurator_0.tpl"}
		{elseif $sArticle.sConfiguratorSettings.type == 1}
			{include file="frontend/heptacom_amp/body/article/buybox/configurator_1.tpl"}
		{elseif $sArticle.sConfiguratorSettings.type == 2}
			{include file="frontend/heptacom_amp/body/article/buybox/configurator_2.tpl"}
		{/if}
	{/block}
{/if}
