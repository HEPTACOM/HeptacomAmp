{namespace name="frontend/index/header"}

<head>
    {* Http-Tags *}
    {block name="frontend_index_header_meta_http_tags"}
        <meta charset="utf-8">
    {/block}

    {* Meta-Tags *}
    {block name='frontend_index_header_meta_tags'}
        <meta name="author" content="{s name='IndexMetaAuthor'}{/s}" />
        {* <meta name="copyright" content="{s name='IndexMetaCopyright'}{/s}" /> *}
        <meta name="robots" content="{block name='frontend_index_header_meta_robots'}{s name='IndexMetaRobots'}{/s}{/block}" />
        <meta name="keywords" content="{block name='frontend_index_header_meta_keywords'}{if $sCategoryContent.metaKeywords}{$sCategoryContent.metaKeywords|escapeHtml}{else}{s name='IndexMetaKeywordsStandard'}{/s}{/if}{/block}" />
        <meta name="description" content="{block name='frontend_index_header_meta_description'}{s name='IndexMetaDescriptionStandard'}{/s}{/block}" />

        {* Meta opengraph tags *}
        {block name='frontend_index_header_meta_tags_opengraph'}
            <meta property="og:type" content="website" />
            <meta property="og:site_name" content="{{config name=sShopname}|escapeHtml}" />
            <meta property="og:title" content="{{config name=sShopname}|escapeHtml}" />
            <meta property="og:description" content="{s name='IndexMetaDescriptionStandard'}{/s}" />
            <meta property="og:image" content="{link file=$theme.desktopLogo fullPath}" />

            <meta name="twitter:card" content="website" />
            <meta name="twitter:site" content="{{config name=sShopname}|escapeHtml}" />
            <meta name="twitter:title" content="{{config name=sShopname}|escapeHtml}" />
            <meta name="twitter:description" content="{s name='IndexMetaDescriptionStandard'}{/s}" />
            <meta name="twitter:image" content="{link file=$theme.desktopLogo fullPath}" />
        {/block}

        {block name='frontend_index_header_meta_tags_schema_webpage'}
            <meta itemprop="copyrightHolder" content="{{config name=sShopname}|escapeHtml}" />
            <meta itemprop="copyrightYear" content="{s name='IndexMetaCopyrightYear'}{/s}" />
            <meta itemprop="isFamilyFriendly" content="{if {config name=metaIsFamilyFriendly}}True{else}False{/if}" />
            <meta itemprop="image" content="{link file=$theme.desktopLogo}" />
        {/block}

        {block name='frontend_index_header_meta_tags_mobile'}
            <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1.0, user-scalable=no">
            <meta name="mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-title" content="{if $theme.appleWebAppTitle != ""}{$theme.appleWebAppTitle|escapeHtml}{else}{{config name=sShopname}|escapeHtml}{/if}">
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="default">
        {/block}
    {/block}

    {* Set favicons and touch icons for all different sizes *}
    {block name="frontend_index_header_favicons"}
        <link rel="apple-touch-icon{if $theme.setPrecomposed}-precomposed{/if}" href="{link file=$theme.appleTouchIcon}">
        <link rel="shortcut icon" href="{link file=$theme.favicon}">
    {/block}

    {* Internet Explorer 9 specific meta tags *}
    {block name='frontend_index_header_meta_tags_ie9'}
        <meta name="msapplication-navbutton-color" content="{$theme['brand-primary']}" />{* Navbutton color *}
        <meta name="application-name" content="{{config name=shopName}|escapeHtml}" />{* Pinned name *}
        <meta name="msapplication-starturl" content="{url controller='index'}" />{* Start url to launch from the shortcut *}
        <meta name="msapplication-window" content="width=1024;height=768" />{* Size of the window to launch *}
        <meta name="msapplication-TileImage" content="{link file=$theme.win8TileImage}"> {* Image of the Windows 8 tile *}
        <meta name="msapplication-TileColor" content="{$theme['brand-primary']}"> {* Backgroud Color of the Windows 8 tile *}
    {/block}

    {* Android specifc meta tags *}
    {block name='frontend_index_header_meta_tags_android'}
        <meta name="theme-color" content="{$theme['brand-primary']}" />
    {/block}

    {* Canonical link *}
    {block name='frontend_index_header_canonical'}
        <link rel="canonical" href="{url controller='index' forceSecure}">
    {/block}

    {* RSS and Atom feeds *}
    {block name="frontend_index_header_feeds"}{/block}

    {* Page title *}
    <title itemprop="name">{block name='frontend_index_header_title'}{strip}
            {if $sBreadcrumb}{foreach from=$sBreadcrumb|array_reverse item=breadcrumb}{$breadcrumb.name} | {/foreach}{/if}{{config name=sShopname}|escapeHtml}
        {/strip}{/block}</title>

    {* Stylesheets *}
    {block name="frontend_index_header_css_screen"}
        {{compileLess timestamp={themeTimestamp} output="lessFiles"}}
        {$baseUrl = $Shopware->Front()->Request()->getBaseUrl()}

        {foreach $lessFiles as $stylesheet}
            <link rel="stylesheet" href="{$stylesheet}" />
        {/foreach}

        {* {if $theme.additionalCssData}
            {$theme.additionalCssData}
        {/if} *}

        {include file="frontend/plugins/heptacom_amp/heptacom_amp_index/amp-boilerplate.tpl"}
    {/block}

    {* Print Stylesheets *}
    {block name="frontend_index_header_css_print"}{/block}

    {* Block for IE specific stylesheets - @deprecated due to the stylesheets are now merged *}
    {block name="frontend_index_header_css_ie"}{/block}

    {block name="frontend_index_header_javascript_amp"}
        <script async src="https://cdn.ampproject.org/v0.js"></script>
    {/block}
</head>
