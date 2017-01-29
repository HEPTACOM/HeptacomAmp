<body>
	{block name="frontend_heptacom_amp_body"}
        {* The configurator selection is checked at this early point
           to use it in different included files in the detail template. *}
        {block name='frontend_detail_index_configurator_settings'}

            {* Variable for tracking active user variant selection *}
            {$activeConfiguratorSelection = true}

            {if $sArticle.sConfigurator && ($sArticle.sConfiguratorSettings.type == 1 || $sArticle.sConfiguratorSettings.type == 2)}
                {* If user has no selection in this group set it to false *}
                {foreach $sArticle.sConfigurator as $configuratorGroup}
                    {if !$configuratorGroup.selected_value}
                        {$activeConfiguratorSelection = false}
                    {/if}
                {/foreach}
            {/if}
        {/block}

		{include file="frontend/heptacom_amp/body/header.tpl"}
		{include file="frontend/heptacom_amp/body/article.tpl"}
		{include file="frontend/heptacom_amp/body/footer.tpl"}
	{/block}
</body>
