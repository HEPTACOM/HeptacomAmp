{$maxQuantity=$sArticle.maxpurchase + 1}
{if $sArticle.laststock && $sArticle.instock < $sArticle.maxpurchase}
	{$maxQuantity=$sArticle.instock + 1}
{/if}

{block name="frontend_heptacom_amp_body_article_buybox_formular_buttongroup_buy_quantity"}
	{* Quantity selection *}
	<div class="sw-buybox--quantity">
		<select id="sQuantity" name="sQuantity" class="sw-quantity--select sw-btn">
			{section name="i" start=$sArticle.minpurchase loop=$maxQuantity step=$sArticle.purchasesteps}
				<option value="{$smarty.section.i.index}">{$smarty.section.i.index}{if $sArticle.packunit} {$sArticle.packunit}{/if}</option>
			{/section}
		</select>
	</div>
{/block}

