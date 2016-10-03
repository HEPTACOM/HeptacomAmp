<!DOCTYPE html>
<html ⚡ lang="{s name='IndexXmlLang' namespace='frontend/index/index'}de{/s}">
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
		{include file="frontend/detail-amp/data.tpl"}
		{include file="frontend/detail-amp/buybox.tpl"}
		{include file="frontend/detail-amp/description.tpl"}
		{include file="frontend/detail-amp/cross-selling.tpl"}
		{include file="frontend/detail-amp/footer.tpl"}
	</body>
</html>
