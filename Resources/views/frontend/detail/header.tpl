{extends file="parent:frontend/detail/header.tpl"}

{block name='frontend_index_header_meta_tags'}
    {$smarty.block.parent}
    <link rel="amphtml" href="{url sArticle=$sArticle.articleID title=$sArticle.articleName amp=1 forceSecure}">
{/block}
