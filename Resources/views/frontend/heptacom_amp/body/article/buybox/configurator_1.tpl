<div class="sw-product--configurator">
	<form method="get" target="_top" action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID forceSecure}" class="configurator--form selection--form">
        {foreach from=$sArticle.sConfigurator item=sConfigurator name=group key=groupID}
			<div class="sw-product--configurator-variant-group">

				{* Group name *}
				{block name='frontend_detail_group_name'}
					<p class="sw-product--configurator-variant-name">{$sConfigurator.groupname}:</p>
				{/block}

				{* Group description *}
				{block name='frontend_detail_group_description'}
					{if $sConfigurator.groupdescription}
						<p class="sw-product--configurator-variant-description">{$sConfigurator.groupdescription}</p>
					{/if}
				{/block}

				{$pregroupID=$groupID-1}
				{* Configurator drop down *}
				{block name='frontend_detail_group_selection'}
					<div class="field--select{if $groupID gt 0 && empty($sArticle.sConfigurator[$pregroupID].user_selected)} is--disabled{/if}">
						{foreach from=$sConfigurator.values item=configValue name=option key=optionID}

							{if $configValue.selected && $sConfigurator.user_selected}
								<input type="hidden" name="group[{$sConfigurator.groupID}]" value="{$configValue.optionID}" />
							{/if}

						{/foreach}
						{foreach from=$sConfigurator.values item=configValue name=option key=optionID}

							<button
								type="submit"
								name="group[{$sConfigurator.groupID}]"
								value="{$configValue.optionID}"
								{if !$configValue.selectable}disabled{/if}
								class="sw-product--configurator-variant-option sw-btn{if !$configValue.selectable} sw-is--disabled{/if}{if $configValue.selected && $sConfigurator.user_selected} sw-is--primary{/if}"
							>
								{$configValue.optionname}
							</button>

						{/foreach}
					</div>
				{/block}

			</div>
		{/foreach}
	</form>
</div>
