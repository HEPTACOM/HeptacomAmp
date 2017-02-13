{extends file="parent:frontend/listing/header.tpl"}

{block name='frontend_index_header_meta_tags'}
    {$smarty.block.parent}
    <link rel="amphtml" href="{url params=$sCategoryContent.canonicalParams amp=1 p=$sPage forceSecure}">
{/block}
