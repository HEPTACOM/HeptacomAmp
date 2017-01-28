{block name="frontend_heptacom_amp__body_article_data_detault_price"}
	{if $sArticle.priceStartingFrom && !$sArticle.sConfigurator && $sView}
		{* Price - Starting from *}
		{block name="frontend_heptacom_amp__body_article_data_detault_price_configurator_starting_from_content"}
			<span class="sw-price--content sw-content--starting-from">
				{s name="DetailDataInfoFrom" namespace="frontend/detail/data"}{/s} {$sArticle.priceStartingFrom|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
			</span>
		{/block}
	{else}
		{* Regular price *}
		{block name="frontend_heptacom_amp__body_article_data_detault_price_regular"}
			<span class="sw-price--content sw-content--default">
				{if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}
					{s name='ListingBoxArticleStartsAt' namespace="frontend/listing/box_article"}{/s}
				{/if}
				{$sArticle.price|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
			</span>
		{/block}
	{/if}
{/block}
