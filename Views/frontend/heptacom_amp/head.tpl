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

    {include file="frontend/heptacom_amp/head/amp.tpl"}
</head>
