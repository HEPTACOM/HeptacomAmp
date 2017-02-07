{extends file="frontend/plugins/heptacom_amp/heptacom_amp_index/header.tpl"}

{* Keywords *}
{block name="frontend_index_header_meta_keywords"}{if $sCustomPage.meta_keywords}{$sCustomPage.meta_keywords|escapeHtml}{else}{$smarty.block.parent}{/if}{/block}

{* Description *}
{block name="frontend_index_header_meta_description"}{if $sCustomPage.meta_description}{$sCustomPage.meta_description|escapeHtml}{else}{$smarty.block.parent}{/if}{/block}
