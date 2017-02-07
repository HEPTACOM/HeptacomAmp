{extends file="parent:frontend/custom/header.tpl"}

{block name='frontend_index_header_meta_tags' append}
    <link rel="amphtml" href="{url sCustom=$sCustomPage.id title=$sCustomPage.description controller='heptacomAmpCustom' forceSecure}">
{/block}
