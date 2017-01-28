<div class="sw-product--configurator">
	{foreach from=$sArticle.sConfigurator item=configurator key=groupID}
		{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant"}
			<div class="sw-product--configurator-variant-group">
				{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_name"}
					<p class="sw-product--configurator-variant-name">{$configurator.groupname}</p>
				{/block}

				{if $configurator.groupdescription}
					{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_name"}
						<p class="sw-product--configurator-variant-description">{$configurator.groupdescription}</p>
					{/block}
				{/if}

				{$pregroupID=$groupID-1}
				{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_options"}
					<div>
						{foreach from=$configurator.values item=option key=optionID}
							<form method="GET"
								target="_top"
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
