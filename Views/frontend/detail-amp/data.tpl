{block name="frontend_HEPTACOMAMP_data"}
	<div class="sw-product--details">
		{if !$sArticle.liveshoppingData.valid_to_ts}
			{* Graduated prices *}
			{if $sArticle.sBlockPrices && !$sArticle.liveshoppingData.valid_to_ts}
				{* Include block prices *}
				{block name="frontend_HEPTACOMAMP_data_block_price_include"}
					{include file="frontend/detail/block_price.tpl" sArticle=$sArticle}
				{/block}
			{else}
				<div class="sw-product--price sw-price--default{if $sArticle.has_pseudoprice} sw-price--discount{/if}">
					{* Default price *}
					{block name="frontend_HEPTACOMAMP_data_price_configurator"}
						{if $sArticle.priceStartingFrom && !$sArticle.sConfigurator && $sView}
							{* Price - Starting from *}
							{block name="frontend_HEPTACOMAMP_data_price_configurator_starting_from_content"}
								<span class="sw-price--content sw-content--starting-from">
									{s name="DetailDataInfoFrom" namespace="frontend/detail/data"}{/s} {$sArticle.priceStartingFrom|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
								</span>
							{/block}
						{else}
							{* Regular price *}
							{block name="frontend_HEPTACOMAMP_data_price_default"}
								<span class="sw-price--content sw-content--default">
									{if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}
										{s name='ListingBoxArticleStartsAt' namespace="frontend/listing/box_article"}{/s}
									{/if}
									{$sArticle.price|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
								</span>
							{/block}
						{/if}
					{/block}

					{* Discount price *}
					{block name="frontend_HEPTACOMAMP_data_pseudo_price"}
						{if $sArticle.has_pseudoprice}
							{block name="frontend_HEPTACOMAMP_data_pseudo_price_discount_icon"}
								<span class="sw-price--discount-icon">
									<i class="icon--percent2"></i>
								</span>
							{/block}

							{* Discount price content *}
							{block name="frontend_HEPTACOMAMP_data_pseudo_price_discount_content"}
								<span class="sw-content--discount">
									{block name="frontend_HEPTACOMAMP_data_pseudo_price_discount_before"}
										{s name="priceDiscountLabel" namespace="frontend/detail/data"}{/s}
									{/block}

									<span class="sw-price--line-through">
										{$sArticle.pseudoprice|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
									</span>

									{block name="frontend_HEPTACOMAMP_data_pseudo_price_discount_after"}
										{s name="priceDiscountInfo" namespace="frontend/detail/data"}{/s}
									{/block}

									{* Percentage discount *}
									{block name="frontend_HEPTACOMAMP_data_pseudo_price_discount_content_percentage"}
										{if $sArticle.pseudopricePercent.float}
											<span class="sw-price--discount-percentage">({$sArticle.pseudopricePercent.float|number}% {s name="DetailDataInfoSavePercent" namespace="frontend/detail/data"}{/s})</span>
										{/if}
									{/block}
								</span>
							{/block}
						{/if}
					{/block}
				</div>
			{/if}

			{* Unit price *}
			{if $sArticle.purchaseunit}
				{block name="frontend_HEPTACOMAMP_data_price"}
					<div class="sw-product--price sw-price--unit">

						{* Unit price label *}
						{block name="frontend_HEPTACOMAMP_data_price_unit_label"}
							<span class="sw-price--label sw-label--purchase-unit">
								{s name="DetailDataInfoContent" namespace="frontend/detail/data"}{/s}
							</span>
						{/block}

						{* Unit price content *}
						{block name="frontend_HEPTACOMAMP_data_price_unit_content"}
							{$sArticle.purchaseunit} {$sArticle.sUnit.description}
						{/block}

						{* Unit price is based on a reference unit *}
						{if $sArticle.purchaseunit && $sArticle.purchaseunit != $sArticle.referenceunit}
							{* Reference unit price content *}
							{block name="frontend_HEPTACOMAMP_data_price_unit_reference_content"}
								({$sArticle.referenceprice|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
								/ {$sArticle.referenceunit} {$sArticle.sUnit.description})
							{/block}
						{/if}
					</div>
				{/block}
			{/if}

			{* Tax information *}
			{block name="frontend_HEPTACOMAMP_data_tax"}
				<p class="sw-product--tax">
					{s name="DetailDataPriceInfo" namespace="frontend/HEPTACOMAMP/data"}
{if $sOutputNet}zzgl.{else}inkl.{/if} MwSt. <a title="Versandkosten" href="/versand-und-zahlung">zzgl. Versandkosten</a>
					{/s}
				</p>
			{/block}
		{/if}

		{* Product - Supplier information *}
		{block name="frontend_HEPTACOMAMP_supplier_info"}
			{if $sArticle.supplierImg}
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
			{/if}
		{/block}

		{block name="frontend_HEPTACOMAMP_data_delivery"}
			{* Delivery informations *}
			{if ($sArticle.sConfiguratorSettings.type != 1 && $sArticle.sConfiguratorSettings.type != 2) || $activeConfiguratorSelection == true}
				{include file="frontend/plugins/index/delivery_informations.tpl" sArticle=$sArticle}
			{/if}
		{/block}
	</div>
{/block}
