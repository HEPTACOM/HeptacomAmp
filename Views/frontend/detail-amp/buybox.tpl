{block name="frontend_HEPTACOMAMP_buybox"}
	<div class="sw-product--buybox">
		{block name="frontend_HEPTACOMAMP_buy_laststock"}
			{if !$sArticle.isAvailable && ($sArticle.isSelectionSpecified || !$sArticle.sConfigurator)}
				{include file="frontend/_includes/messages.tpl" type="error" content="{s name='DetailBuyInfoNotAvailable' namespace='frontend/detail/buy'}{/s}"}
			{/if}
		{/block}

		{* Configurator drop down menu's *}
		{if (!isset($sArticle.active) || $sArticle.active) && $sArticle.isAvailable && $sArticle.sConfigurator}
			{block name="frontend_HEPTACOMAMP_index_configurator"}
				{if $sArticle.sConfiguratorSettings.type == 0
				 or $sArticle.sConfiguratorSettings.type == 2}
					<div class="sw-product--configurator">
						{foreach $sArticle.sConfigurator as $configurator}
							{block name="frontend_HEPTACOMAMP_configurator_variant"}
								<div class="sw-product--configurator-variant-group">
									{block name="frontend_HEPTACOMAMP_configurator_variant_name"}
										<p class="sw-product--configurator-variant-name">{$configurator.groupname}</p>
									{/block}
									
									{block name="frontend_HEPTACOMAMP_configurator_variant_options"}
										<div>
											{foreach $configurator.values as $option}
												<form method="GET"
													action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID}">
													<input type="hidden" name="group[{$option.groupID}]" value="{$option.optionID}" />
													<input type="submit"
														class="sw-product--configurator-variant-option sw-btn{if !$option.selectable} sw-is--disabled{/if}"
														value="{$option.optionname}" />
													</input>
												</form>
											{/foreach}
										</div>
									{/block}
								</div>
							{/block}
						{/foreach}
					</div>
				{elseif $sArticle.sConfiguratorSettings.type == 1}
					<div class="sw-product--configurator">
						{foreach from=$sArticle.sConfigurator item=configurator key=groupID}
							{block name="frontend_HEPTACOMAMP_configurator_variant"}
								<div class="sw-product--configurator-variant-group">
									{block name="frontend_HEPTACOMAMP_configurator_variant_name"}
										<p class="sw-product--configurator-variant-name">{$configurator.groupname}</p>
									{/block}

									{if $configurator.groupdescription}
										{block name="frontend_HEPTACOMAMP_configurator_variant_name"}
											<p class="sw-product--configurator-variant-description">{$configurator.groupdescription}</p>
										{/block}
									{/if}

									{$pregroupID=$groupID-1}
									{block name="frontend_HEPTACOMAMP_configurator_variant_options"}
										<div>
											{foreach from=$configurator.values item=option key=optionID}
												<form method="GET"
													action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID}">
													<input type="hidden" name="group[{$configurator.groupID}]" value="{$option.optionID}" />
													<input type="submit"
														class="sw-product--configurator-variant-option sw-btn{if (!$option.selectable) or ($groupID gt 0 && empty($sArticle.sConfigurator[$pregroupID].user_selected))} sw-is--disabled{/if}{if $option.selected && $configurator.user_selected} sw-is--primary{/if}"
														{if ($groupID gt 0 && empty($sArticle.sConfigurator[$pregroupID].user_selected)) or !$option.selectable}
															disabled="disabled"
														{/if}
														value="{$option.optionname}{if !$option.selectable}{s name='DetailConfigValueNotAvailable'}{/s}{/if}" />
												</form>
											{/foreach}
										</div>
									{/block}
								</div>
							{/block}
						{/foreach}
					</div>
				{/if}
			{/block}
		{/if}

		{block name="frontend_HEPTACOMAMP_buy"}
			<form method="GET" action="{url controller=checkout action=addArticle}" class="sw-buybox--form">
				{if $sArticle.sBlockPrices && (!$sArticle.sConfigurator || $sArticle.pricegroupActive)}
					{foreach $sArticle.sBlockPrices as $blockPrice}
						{if $blockPrice.from == 1}
							<input id="price_{$sArticle.ordernumber}" type="hidden" value="{$blockPrice.price|replace:",":"."}" />
						{/if}
					{/foreach}
				{/if}

				{block name="frontend_HEPTACOMAMP_buy_configurator_inputs"}
					{if $sArticle.sConfigurator && $sArticle.sConfiguratorSettings.type == 3}
						{foreach $sArticle.sConfigurator as $group}
							<input type="hidden" name="group[{$group.groupID}]" value="{$group.selected_value}"/>
						{/foreach}
					{/if}
				{/block}

				<input type="hidden" name="sActionIdentifier" value="{$sUniqueRand}"/>
				<input type="hidden" name="sAddAccessories" id="sAddAccessories" value=""/>
				<input type="hidden" name="sAdd" value="{$sArticle.ordernumber}"/>

				{* TODO is frontend_detail_buy_accessories needed for this? *}

				{block name="frontend_HEPTACOMAMP_index_buybox"}
					{if (!isset($sArticle.active) || $sArticle.active)}
						{if $sArticle.isAvailable}
							{block name="frontend_HEPTACOMAMP_buy_button_container"}
								<div class="sw-buybox--button-container sw-block-group{if $NotifyHideBasket && $sArticle.notification && $sArticle.instock <= 0} sw-is--hidden{/if}">
									{* "Buy now" button *}
									{block name="frontend_HEPTACOMAMP_buy_button"}
										{if $sArticle.sConfigurator && !$activeConfiguratorSelection}
											<a class="sw-buybox--button sw-buybox--button-configure sw-btn sw-is--primary sw-is--icon-right sw-is--center sw-is--large"
												href="{url sArticle=$sArticle.articleID title=$sArticle.articleName}">
												{s name="OpenCanonicalConfigurator" namespace="frontend/HEPTACOMAMP/buy"}Jetzt konfigurieren{/s} <i class="icon--arrow-right"></i>
											</a>
										{else}
											{* Quantity selection *}
											{block name="frontend_HEPTACOMAMP_buy_quantity"}
												<div class="sw-buybox--quantity">
													{$maxQuantity=$sArticle.maxpurchase + 1}
													{if $sArticle.laststock && $sArticle.instock < $sArticle.maxpurchase}
														{$maxQuantity=$sArticle.instock + 1}
													{/if}

													{block name="frontend_HEPTACOMAMP_buy_quantity_select"}
														<select id="sQuantity" name="sQuantity" class="sw-quantity--select sw-btn">
															{section name="i" start=$sArticle.minpurchase loop=$maxQuantity step=$sArticle.purchasesteps}
																<option value="{$smarty.section.i.index}">{$smarty.section.i.index}{if $sArticle.packunit} {$sArticle.packunit}{/if}</option>
															{/section}
														</select>
													{/block}
												</div>
											{/block}

											<button class="sw-buybox--button sw-btn sw-is--primary sw-is--icon-right sw-is--center sw-is--large" name="{s name="DetailBuyActionAdd" namespace="frontend/detail/buy"}{/s}">
												{s name="DetailBuyActionAdd" namespace="frontend/detail/buy"}{/s} <i class="icon--arrow-right"></i>
											</button>
										{/if}
									{/block}
								</div>
							{/block}
						{/if}
					{/if}
				{/block}
			</form>
		{/block}
	</div>
{/block}
