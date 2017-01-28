<div class="sw-product--configurator">
	{foreach $sArticle.sConfigurator as $configurator}
		{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant"}
			<div class="sw-product--configurator-variant-group">
				{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_name"}
					<p class="sw-product--configurator-variant-name">{$configurator.groupname}</p>
				{/block}

				{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_options"}
					<div>
						<form method="GET"
							target="_top"
							action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID}">
							{foreach $configurator.values as $option}
								<button name="group[{$option.groupID}]"
									value="{$option.optionID}"{if !$option.selectable} disabled="disabled"{/if}
									class="sw-product--configurator-variant-option sw-btn{if !$option.selectable} sw-is--disabled{/if}">
									{$option.optionname}
								</button>
							{/foreach}
						</form>
					</div>
				{/block}
			</div>
		{/block}
	{/foreach}
</div>
