{if $sArticle.supplierImg}
	{* Product - Supplier information *}
	{block name="frontend_heptacom_amp_body_article_data_supplier"}
		<div class="sw-product--supplier">
			<a href="{url controller='listing' action='manufacturer' sSupplier=$sArticle.supplierID}"
				class="sw-product--supplier-link">
				<amp-img
					layout="fixed-height"
					height="100{* TODO get image size *}"
					src="{$sArticle.supplierImg}"
					alt="{$sArticle.supplierName|escape}">
				</amp-img>
			</a>
		</div>
	{/block}
{/if}
