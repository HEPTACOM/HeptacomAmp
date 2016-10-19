<head>
    <meta charset="utf-8">

    {* Canonical link *}
    <link rel="canonical" href="{url sArticle=$sArticle.articleID title=$sArticle.articleName}">

    {include file="frontend/heptacom_amp/head/meta_tags.tpl"}

    {* Keywords *}
    <meta name="keywords" content="{block name="frontend_index_header_meta_keywords"}{if $sArticle.keywords}{$sArticle.keywords|escapeHtml}{elseif $sArticle.sDescriptionKeywords}{$sArticle.sDescriptionKeywords|escapeHtml}{/if}{/block}" />

    {* Description *}
    <meta name="description" content="{block name='frontend_index_header_meta_description'}{if $sArticle.description}{$sArticle.description|escapeHtml}{else}{$sArticle.description_long|strip_tags|escapeHtml}{/if}{/block}" />

    {* Meta opengraph tags *}
    {* TODO Add schema.org meta tags *}
    {block name="frontend_heptacom_amp_header_meta_tags_opengraph"}
        <meta property="product:brand" content="{$sArticle.supplierName|escapeHtml}" />
        <meta property="product:price" content="{$sArticle.price}" />
        <meta property="product:product_link" content="{url sArticle=$sArticle.articleID title=$sArticle.articleName}" />
    {/block}

    {* Meta title *}
    <title>{block name="frontend_heptacom_amp_header_title"}{if $sArticle.metaTitle}{$sArticle.metaTitle|escapeHtml}{else}{$sArticle.articleName}{/if} | {{config name=sShopname}|escapeHtml}{/block}</title>

    {block name="frontend_heptacom_amp_header_amp"}
        {literal}
            <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
        {/literal}

        {include file="frontend/heptacom_amp/custom_style.tpl"}

        <script async src="https://cdn.ampproject.org/v0.js"></script>

        {block name="frontend_heptacom_amp_header_amp_extensions"}
            <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-latest.js"></script>
            <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-latest.js"></script>
            <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-latest.js"></script>
            <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-latest.js"></script>
            <script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-latest.js"></script>
        {/block}
    {/block}
</head>
