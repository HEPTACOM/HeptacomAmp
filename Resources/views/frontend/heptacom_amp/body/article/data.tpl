{block name="frontend_heptacom_amp_body_article_data"}
	<div class="sw-product--details">
		{if !$sArticle.liveshoppingData.valid_to_ts}
			{* Graduated prices *}
			{if $sArticle.sBlockPrices && !$sArticle.liveshoppingData.valid_to_ts}
				{* Include block prices *}
				{block name="frontend_heptacom_amp_body_article_data_block_price_include"}
					{include file="frontend/detail/block_price.tpl" sArticle=$sArticle}
				{/block}
			{else}
				<div class="sw-product--price sw-price--default{if $sArticle.has_pseudoprice} sw-price--discount{/if}">
					{include file="frontend/heptacom_amp/body/article/data/default_price.tpl"}
					{include file="frontend/heptacom_amp/body/article/data/discount_price.tpl"}
				</div>
			{/if}

			{include file="frontend/heptacom_amp/body/article/data/unit_price.tpl"}
			{include file="frontend/heptacom_amp/body/article/data/tax.tpl"}
		{/if}

		{include file="frontend/heptacom_amp/body/article/data/supplier.tpl"}
		{include file="frontend/heptacom_amp/body/article/data/delivery.tpl"}
	</div>
{/block}
