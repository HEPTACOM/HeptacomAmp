{extends file="parent:frontend/listing/header.tpl"}

{block name='frontend_index_header_meta_tags' append}
    <link rel="amphtml" href="{url sCategory=$sCategoryContent.id title=$sCategoryContent.name controller='heptacomAmpListing' forceSecure}">
{/block}
