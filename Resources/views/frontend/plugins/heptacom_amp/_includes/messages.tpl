{* Icon classes *}
{block name="frontend_global_messages_icon_class"}
    {$iconCls = 'icon--check'}
    {if $type == 'error'}
        {$iconCls = 'icon--cross'}
    {elseif $type == 'success'}
        {$iconCls= 'icon--check'}
    {elseif $type == 'warning'}
        {$iconCls = 'icon--warning'}
    {else}
        {$iconCls = 'icon--info'}
    {/if}

    {* Support for customized icons *}
    {if isset($icon) && $icon|@count}
        {$iconCls=$icon}
    {/if}
{/block}

{* Support for non border-radius *}
{block name="frontend_global_messages_border_radius"}
    {$hasBorderRadius=true}
    {if isset($borderRadius)}
        {$hasBorderRadius=$borderRadius}
    {/if}
{/block}

{* Support for bold text *}
{block name="frontend_global_messages_bold"}
    {$isBold=false}
    {if isset($bold)}
        {$isBold=$bold}
    {/if}
{/block}

{* Support for hiding the message on startup *}
{block name="frontend_global_messages_visible"}
    {$isVisible=true}
    {if isset($visible)}
        {$isVisible=$visible}
    {/if}
{/block}

{* Messages container *}
{block name="frontend_global_messages_container"}
    <div class="alert is--{$type}{if $hasBorderRadius && $hasBorderRadius === true} is--rounded{/if}{if $isVisible === false} is--hidden{/if}">

        {* Icon column *}
        {block name="frontend_global_messages_icon"}
            <div class="alert--icon">
                <i class="icon--element {$iconCls}"></i>
            </div>
        {/block}

        {* Content column *}
        {block name="frontend_global_messages_content"}
            <div class="alert--content{if $isBold} is--strong{/if}">
                {if $content && !$list}
                    {$content}
                {else}
                    <ul class="alert--list">
                        {foreach $list as $entry}
                            <li class="list--entry{if $entry@first} is--first{/if}{if $entry@last} is--last{/if}">{$entry}</li>
                        {/foreach}
                    </ul>
                {/if}
            </div>
        {/block}
    </div>
{/block}
