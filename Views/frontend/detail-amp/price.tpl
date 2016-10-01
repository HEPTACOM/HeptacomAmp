{block name="frontend_detail-amp_price"}
	<span class="sw-price{if $class} {$class}{/if}">
		{block name="frontend_detail-amp_price-value"}
			{$price|currency}
		{/block}
	</span>
{/block}