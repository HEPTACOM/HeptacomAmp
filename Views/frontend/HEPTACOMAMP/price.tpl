{block name="frontend_HEPTACOMAMP_price"}
	<span class="sw-price{if $class} {$class}{/if}">
		{block name="frontend_HEPTACOMAMP_price-value"}
			{$price|currency}
		{/block}
	</span>
{/block}