{extends file="parent:frontend/custom/header.tpl"}

{block name='frontend_index_header_meta_tags'}
    {$smarty.block.parent}
    <link rel="amphtml" href="{url sCustom=$sCustomPage.id title=$sCustomPage.description amp=1 forceSecure}">
{/block}
