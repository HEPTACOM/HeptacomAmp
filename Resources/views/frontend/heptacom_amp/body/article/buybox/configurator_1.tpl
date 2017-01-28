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
					<form method="GET"
						  target="_top"
						  action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID}">
						{foreach from=$configurator.values item=option key=optionID}
							<button
									type="submit"
									name="group[{$configurator.groupID}]"
									value="{$option.optionID}"
									class="sw-product--configurator-variant-option sw-btn{if (!$option.selectable) || ($groupID > 0 && empty($sArticle.sConfigurator[$pregroupID].user_selected))} sw-is--disabled{/if}{if $option.selected && $configurator.user_selected} sw-is--primary{/if}"
									{if ($groupID > 0 && empty($sArticle.sConfigurator[$pregroupID].user_selected)) || !$option.selectable}
										disabled="disabled"
									{/if}>
								{$option.optionname}{if !$option.selectable}{s name='DetailConfigValueNotAvailable'}{/s}{/if}
							</button>
						{/foreach}
					</form>
				{/block}
			</div>
		{/block}
	{/foreach}
</div>
