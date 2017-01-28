{* Unit price *}
{if $sArticle.purchaseunit}
	{block name="frontend_heptacom_amp_body_article_data_unit_price"}
		<div class="sw-product--price sw-price--unit">
			{* Unit price label *}
			{block name="frontend_heptacom_amp_body_article_data_price_unit_label"}
				<span class="sw-price--label sw-label--purchase-unit">
					{s name="DetailDataInfoContent" namespace="frontend/detail/data"}{/s}
				</span>
			{/block}

			{* Unit price content *}
			{block name="frontend_heptacom_amp_body_article_data_price_content"}
				{$sArticle.purchaseunit} {$sArticle.sUnit.description}
			{/block}

			{* Unit price is based on a reference unit *}
			{if $sArticle.purchaseunit && $sArticle.purchaseunit != $sArticle.referenceunit}
				{* Reference unit price content *}
				{block name="frontend_heptacom_amp_body_article_data_price_unit_reference_content"}
					({$sArticle.referenceprice|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
					/ {$sArticle.referenceunit} {$sArticle.sUnit.description})
				{/block}
			{/if}
		</div>
	{/block}
{/if}
