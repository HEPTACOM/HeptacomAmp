<head>
    <meta charset="utf-8">

    {* Canonical link *}
    <link rel="canonical" href="{url sArticle=$sArticle.articleID title=$sArticle.articleName}">

    {block name='frontend_index_header_meta_tags_mobile'}
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="{if $theme.appleWebAppTitle != ""}{$theme.appleWebAppTitle|escapeHtml}{else}{{config name=sShopname}|escapeHtml}{/if}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
    {/block}

    {* Keywords *}
    <meta name="keywords" content="{block name="frontend_index_header_meta_keywords"}{if $sArticle.keywords}{$sArticle.keywords|escapeHtml}{elseif $sArticle.sDescriptionKeywords}{$sArticle.sDescriptionKeywords|escapeHtml}{/if}{/block}" />

    {* Description *}
    <meta name="description" content="{block name='frontend_index_header_meta_description'}{if $sArticle.description}{$sArticle.description|escapeHtml}{else}{$sArticle.description_long|strip_tags|escapeHtml}{/if}{/block}" />

    {* Meta opengraph tags *}
    {block name='frontend_detail-amp_header_meta_tags_opengraph'}
        <meta property="og:type" content="product" />
        <meta property="og:site_name" content="{{config name=sShopname}|escapeHtml}" />
        <meta property="og:url" content="{url sArticle=$sArticle.articleID title=$sArticle.articleName}" />
        <meta property="og:title" content="{$sArticle.articleName|escapeHtml}" />
        <meta property="og:description" content="{$sArticle.description_long|strip_tags|truncate:240|escapeHtml}" />
        <meta property="og:image" content="{$sArticle.image.source}" />

        <meta property="product:brand" content="{$sArticle.supplierName|escapeHtml}" />
        <meta property="product:price" content="{$sArticle.price}" />
        <meta property="product:product_link" content="{url sArticle=$sArticle.articleID title=$sArticle.articleName}" />

        <meta name="twitter:card" content="product" />
        <meta name="twitter:site" content="{{config name=sShopname}|escapeHtml}" />
        <meta name="twitter:title" content="{$sArticle.articleName|escapeHtml}" />
        <meta name="twitter:description" content="{$sArticle.description_long|strip_tags|truncate:240|escapeHtml}" />
        <meta name="twitter:image" content="{$sArticle.image.source}" />
    {/block}

    {* Meta title *}
    <title>{block name="frontend_detail-amp_header_title"}{if $sArticle.metaTitle}{$sArticle.metaTitle|escapeHtml}{else}{$sArticle.articleName}{/if} | {{config name=sShopname}|escapeHtml}{/block}</title>

    {block name="frontend_detail-amp_header_amp"}
        {literal}
            <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
        {/literal}

        <script async src="https://cdn.ampproject.org/v0.js"></script>

        {block name="frontend_detail-amp_header_amp_extensions"}
            <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-latest.js"></script>
            <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-latest.js"></script>
            <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-latest.js"></script>
            <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-latest.js"></script>
            <script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-latest.js"></script>
        {/block}
    {/block}
</head>
