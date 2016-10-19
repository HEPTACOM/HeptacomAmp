{block name="frontend_heptacom_amp_body_article_buybox_formular_hidden_values"}
	{* Block Prices *}
	{if $sArticle.sBlockPrices && (!$sArticle.sConfigurator || $sArticle.pricegroupActive)}
		{foreach $sArticle.sBlockPrices as $blockPrice}
			{if $blockPrice.from == 1}
				<input id="price_{$sArticle.ordernumber}" type="hidden" value="{$blockPrice.price|replace:",":"."}" />
			{/if}
		{/foreach}
	{/if}

	{* Selected Configurations *}
	{block name="frontend_heptacom_amp_buy_configurator_inputs"}
		{if $sArticle.sConfigurator && $sArticle.sConfiguratorSettings.type == 3}
			{foreach $sArticle.sConfigurator as $group}
				<input type="hidden" name="group[{$group.groupID}]" value="{$group.selected_value}"/>
			{/foreach}
		{/if}
	{/block}

	{* Article Information *}
	<input type="hidden" name="sActionIdentifier" value="{$sUniqueRand}"/>
	<input type="hidden" name="sAddAccessories" id="sAddAccessories" value=""/>
	<input type="hidden" name="sAdd" value="{$sArticle.ordernumber}"/>
{/block}