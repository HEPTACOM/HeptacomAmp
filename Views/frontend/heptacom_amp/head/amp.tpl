{block name="frontend_heptacom_amp_head_amp"}
	{* Canonical link *}
	<link rel="canonical" href="{url sArticle=$sArticle.articleID title=$sArticle.articleName controller=index}">

	{* Cascading Style Sheets *}
	{include file="frontend/heptacom_amp/head/amp/boilerplate.tpl"}
	{include file="frontend/heptacom_amp/head/amp/custom_style.tpl"}

	{* Javascript *}
	<script async src="https://cdn.ampproject.org/v0.js"></script>
	{include file="frontend/heptacom_amp/head/amp/extensions.tpl"}
{/block}
