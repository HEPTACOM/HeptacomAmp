<div class="logo-main block-group" role="banner">

    {* Main shop logo *}
    {block name='frontend_index_logo'}
        <div class="logo--shop block">
            <a class="logo--link" href="{url controller='index'}" title="{"{config name=shopName}"|escapeHtml} - {"{s name='IndexLinkDefault' namespace="frontend/index/index"}{/s}"|escape}">
                <amp-img
                    layout="flex-item"
                    src="{link file=$theme.mobileLogo}"
                    srcset="{link file=$theme.desktopLogo} 1260w, {link file=$theme.tabletLandscapeLogo} 1024w, {link file=$theme.tabletLogo} 768w"
                    alt="{"{config name=shopName}"|escapeHtml} - {"{s name='IndexLinkDefault' namespace="frontend/index/index"}{/s}"|escape}"
                ></amp-img>
            </a>
        </div>
    {/block}

    {* Trusted Shops *}
    {block name='frontend_index_logo_trusted_shops'}{/block}
</div>
