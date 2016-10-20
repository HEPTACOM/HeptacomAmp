{if $sArticle.has_pseudoprice}
	{* Discount price *}
	{block name="frontend_heptacom_amp_body_article_data_discount_price"}
		{block name="frontend_heptacom_amp_body_article_data_discount_price_icon"}
			<span class="sw-price--discount-icon">
				<i class="icon--percent2"></i>
			</span>
		{/block}

		{* Discount price content *}
		{block name="frontend_heptacom_amp_body_article_data_discount_price_content"}
			<span class="sw-content--discount">
				{block name="frontend_heptacom_amp_body_article_data_discount_price_before"}
					{s name="priceDiscountLabel" namespace="frontend/detail/data"}{/s}
				{/block}

				<span class="sw-price--line-through">
					{$sArticle.pseudoprice|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
				</span>

				{block name="frontend_heptacom_amp_body_article_data_discount_price_after"}
					{s name="priceDiscountInfo" namespace="frontend/detail/data"}{/s}
				{/block}

				{* Percentage discount *}
				{block name="frontend_heptacom_amp_body_article_data_discount_price_content_percentage"}
					{if $sArticle.pseudopricePercent.float}
						<span class="sw-price--discount-percentage">({$sArticle.pseudopricePercent.float|number}% {s name="DetailDataInfoSavePercent" namespace="frontend/detail/data"}{/s})</span>
					{/if}
				{/block}
			</span>
		{/block}
	{/block}
{/if}