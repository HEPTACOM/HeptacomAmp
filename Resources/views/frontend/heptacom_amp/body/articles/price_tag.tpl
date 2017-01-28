{block name="frontend_heptacom_amp_body_articles_carousel_item_price_tag"}
	<span class="sw-price{if $class} {$class}{/if}">
		{block name="frontend_heptacom_amp_body_articles_carousel_price_tag_value"}
			{$price|currency}
		{/block}
	</span>
{/block}