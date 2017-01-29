<div class="sw-product--configurator">
    <form method="get" target="_top" action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID forceSecure}" class="configurator--form upprice--form">

        {foreach $sArticle.sConfigurator as $sConfigurator}
            <div class="sw-product--configurator-variant-group">

                {* Group name *}
                {block name='frontend_detail_group_name'}
                    <p class="sw-product--configurator-variant-name">{$sConfigurator.groupname}:</p>
                {/block}

                {* Group description *}
                {if $sConfigurator.groupdescription}
                    {block name='frontend_detail_group_description'}
                        <p class="sw-product--configurator-variant-description">{$sConfigurator.groupdescription}</p>
                    {/block}
                {/if}

                {* Configurator drop down *}
                {block name='frontend_detail_group_selection'}
                    {foreach $sConfigurator.values as $configValue}
                        {if !{config name=hideNoInStock} || ({config name=hideNoInStock} && $configValue.selectable)}
                            {if $configValue.selected}
                                <input type="hidden" name="group[{$sConfigurator.groupID}]" value="{$configValue.optionID}" />
                            {/if}
                        {/if}
                    {/foreach}

                    {foreach $sConfigurator.values as $configValue}
                        {if !{config name=hideNoInStock} || ({config name=hideNoInStock} && $configValue.selectable)}
                            <button
                                type="submit"
                                name="group[{$sConfigurator.groupID}]"
                                value="{$configValue.optionID}"
                                class="sw-product--configurator-variant-option sw-btn{if $configValue.selected} sw-is--primary{/if}">
                                {$configValue.optionname}{if $configValue.upprice} {if $configValue.upprice > 0}{/if}{/if}
                            </button>
                        {/if}
                    {/foreach}
                {/block}
            </div>
        {/foreach}
    </form>
</div>
