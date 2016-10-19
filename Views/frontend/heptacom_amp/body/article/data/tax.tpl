{* Tax information *}
{block name="frontend_heptacom_amp_body_article_data_tax"}
	<p class="sw-product--tax">
		{s name="DetailDataPriceInfo" namespace="frontend/heptacom_amp/data"}
{if $sOutputNet}zzgl.{else}inkl.{/if} MwSt. <a title="Versandkosten" href="/versand-und-zahlung">zzgl. Versandkosten</a>
		{/s}
	</p>
{/block}
