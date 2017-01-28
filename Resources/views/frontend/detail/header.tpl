{extends file="parent:frontend/detail/header.tpl"}

{block name='frontend_index_header_meta_tags' append}
    <link rel="amphtml" href="{url sArticle=$sArticle.articleID title=$sArticle.articleName controller='heptacomAmpDetail'}">
{/block}
