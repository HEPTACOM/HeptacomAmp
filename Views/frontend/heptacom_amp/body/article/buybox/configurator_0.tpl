<div class="sw-product--configurator">
	{foreach $sArticle.sConfigurator as $configurator}
		{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant"}
			<div class="sw-product--configurator-variant-group">
				{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_name"}
					<p class="sw-product--configurator-variant-name">{$configurator.groupname}</p>
				{/block}

				{block name="frontend_heptacom_amp_body_article_buybox_configurator_variant_options"}
					<div>
						{foreach $configurator.values as $option}
							<form method="GET"
								target="_top"
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
