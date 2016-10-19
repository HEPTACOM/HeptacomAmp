<body>
	{block name="frontend_heptacom_amp_body"}
		<header class="sw-header-main">
			{block name='frontend_heptacom_amp_header_navigation'}
				{include file="frontend/heptacom_amp/logo_container.tpl"}
				{include file="frontend/heptacom_amp/shop_navigation.tpl"}
			{/block}
		</header>
		{include file="frontend/heptacom_amp/offcanvas_navigation.tpl"}
		<h1 class="sw-product--title">
			{$sArticle.articleName}
		</h1>
		{include file="frontend/heptacom_amp/article_image.tpl"}
		{include file="frontend/heptacom_amp/data.tpl"}
		{include file="frontend/heptacom_amp/buybox.tpl"}
		{include file="frontend/heptacom_amp/description.tpl"}
		{include file="frontend/heptacom_amp/cross_selling.tpl"}
		{include file="frontend/heptacom_amp/footer.tpl"}
	{/block}
</body>
