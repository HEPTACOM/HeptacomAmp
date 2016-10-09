{block name="frontend_heptacom_amp_price"}
	<span class="sw-price{if $class} {$class}{/if}">
		{block name="frontend_heptacom_amp_price-value"}
			{$price|currency}
		{/block}
	</span>
{/block}