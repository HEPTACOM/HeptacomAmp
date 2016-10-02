<!DOCTYPE html>
{*
	TODO: get lang from shopware
	{s name='IndexXmlLang'}{/s} is the way it is done in the index/index.tpl but we have no XmlLang.
*}
<html ⚡ lang="de">
	{include file="frontend/detail-amp/header.tpl"}
	<body>
		<header class="sw-header-main">
			{block name='frontend_detail-amp_header_navigation'}
				<div class="sw-header--navigation">
					{include file="frontend/detail-amp/logo-container.tpl"}
					{include file="frontend/detail-amp/shop-navigation.tpl"}
				</div>
			{/block}
		</header>
		{include file="frontend/detail-amp/offcanvas-navigation.tpl"}
		<h1>
			{$sArticle.articleName}
		</h1>
		{include file="frontend/detail-amp/article-image.tpl"}
		{include file="frontend/detail-amp/buybox.tpl"}
		{include file="frontend/detail-amp/description.tpl"}
		{include file="frontend/detail-amp/cross-selling.tpl"}
		{include file="frontend/detail-amp/footer.tpl"}
	</body>
</html>
