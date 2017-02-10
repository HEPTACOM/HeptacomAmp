{block name="frontend_listing_banner"}
    {if $sBanner}
        <div class="banner--container">

            {if $sBanner.extension=="swf"}

                {* @deprecated Flash banner *}
                {block name='frontend_listing_swf_banner'}{/block}

            {elseif $sBanner.media.thumbnails}
                {if !$sBanner.link || $sBanner.link == "#" || $sBanner.link == ""}

                    {* Image only banner *}
                    {block name='frontend_listing_image_only_banner'}
                        <amp-img layout="fill"
                                 class="banner--img"
                                 src="{$sBanner.media.thumbnails[0].source}"
                                 srcset="{$sBanner.media.thumbnails[0].sourceSet}"
                                 alt="{$sBanner.description|escape}"
                        ></amp-img>
                    {/block}
                {else}

                    {* Normal banner *}
                    {block name='frontend_listing_normal_banner'}
                        <a href="{$sBanner.link}" class="banner--link" {if $sBanner.link_target}target="{$sBanner.link_target}"{/if} title="{$sBanner.description|escape}">
                            <amp-img layout="fill"
                                     class="banner--img"
                                     src="{$sBanner.media.thumbnails[0].source}"
                                     srcset="{$sBanner.media.thumbnails[0].sourceSet}"
                                     alt="{$sBanner.description|escape}"
                            ></amp-img>
                        </a>
                    {/block}
                {/if}
            {/if}
        </div>
    {/if}
{/block}
