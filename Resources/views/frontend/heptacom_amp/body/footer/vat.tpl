{block name="frontend_heptacom_amp_body_footer_vat"}
	<div class="sw-footer--vat-info">
		<p class="sw-vat-info--text">
			{if $sOutputNet}
				{s name="FooterInfoExcludeVat" namespace="frontend/index/footer"}{/s}
			{else}
				{s name="FooterInfoIncludeVat" namespace="frontend/index/footer"}{/s}
			{/if}
		</p>
	</div>
{/block}
