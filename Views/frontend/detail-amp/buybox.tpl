{block name="frontend_detail-amp_buybox"}
	<div class="sw-product--buybox">
		{block name="frontend_detail-amp_buy_laststock"}
			{if !$sArticle.isAvailable && ($sArticle.isSelectionSpecified || !$sArticle.sConfigurator)}
				{include file="frontend/_includes/messages.tpl" type="error" content="{s name='DetailBuyInfoNotAvailable' namespace='frontend/detail/buy'}{/s}"}
			{/if}
		{/block}

		{block name="frontend_detail-amp_buy"}
			<form method="POST" action="{url controller=checkout action=addArticle}" class="sw-buybox--form">
				{block name="frontend_detail-amp_buy_configurator_inputs"}
					{if $sArticle.sConfigurator && $sArticle.sConfiguratorSettings.type == 3}
						{foreach $sArticle.sConfigurator as $group}
							<input type="hidden" name="group[{$group.groupID}]" value="{$group.selected_value}"/>
						{/foreach}
					{/if}
				{/block}

				<input type="hidden" name="sActionIdentifier" value="{$sUniqueRand}"/>
				<input type="hidden" name="sAddAccessories" id="sAddAccessories" value=""/>
				<input type="hidden" name="sAdd" value="{$sArticle.ordernumber}"/>

				{block name="frontend_detail-amp_index_buybox"}
					{if (!isset($sArticle.active) || $sArticle.active)}
						{if $sArticle.isAvailable}
							{block name="frontend_detail-amp_buy_button_container"}
								<div class="sw-buybox--button-container sw-block-group{if $NotifyHideBasket && $sArticle.notification && $sArticle.instock <= 0} sw-is--hidden{/if}">
									{* "Buy now" button *}
									{block name="frontend_detail-amp_buy_button"}
										<button class="sw-buybox--button sw-btn sw-is--primary sw-is--icon-right sw-is--center is--large" name="{s name="DetailBuyActionAdd"}{/s}">
											{* TODO fix output of the following to echo "In den Warenkorb" *}
											{* s name="DetailBuyActionAdd"}{/s *} <i class="icon--arrow-right"></i>
										</button>
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
