<!DOCTYPE html>
<html ⚡ lang="{s name='IndexXmlLang' namespace='frontend/index/index'}de{/s}">
	{include file="frontend/HEPTACOMAMP/header.tpl"}
	<body>
		<header class="sw-header-main">
			{block name='frontend_HEPTACOMAMP_header_navigation'}
				{include file="frontend/HEPTACOMAMP/logo-container.tpl"}
				{include file="frontend/HEPTACOMAMP/shop-navigation.tpl"}
			{/block}
		</header>
		{include file="frontend/HEPTACOMAMP/offcanvas-navigation.tpl"}
		<h1 class="sw-product--title">
			{$sArticle.articleName}
		</h1>
		{include file="frontend/HEPTACOMAMP/article-image.tpl"}
		{include file="frontend/HEPTACOMAMP/data.tpl"}
		{include file="frontend/HEPTACOMAMP/buybox.tpl"}
		{include file="frontend/HEPTACOMAMP/description.tpl"}
		{include file="frontend/HEPTACOMAMP/cross-selling.tpl"}
		{include file="frontend/HEPTACOMAMP/footer.tpl"}
	</body>
</html>
