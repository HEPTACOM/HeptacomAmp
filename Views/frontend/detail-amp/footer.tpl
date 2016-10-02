{block name="frontend_detail-amp_minimal_footer"}
	<div class="sw-footer">
		{if !$hideCopyrightNotice}
			{block name='frontend_detail-amp_footer_vat_info'}
				<div class="sw-footer--vat-info">
					<p class="sw-vat-info--text">
						{if $sOutputNet}
							{s name='FooterInfoExcludeVat' namespace="frontend/index/footer"}{/s}
						{else}
							{s name='FooterInfoIncludeVat' namespace="frontend/index/footer"}{/s}
						{/if}
					</p>
				</div>
			{/block}

			{include file="frontend/detail-amp/footer-navigation.tpl"}

			{block name="frontend_detail-amp_footer_copyright"}
				<div class="sw-footer--copyright">
					{s name="IndexCopyright" namespace="frontend/index/footer"}{/s}
				</div>
			{/block}
		{/if}
	</div>
{/block}
