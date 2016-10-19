<body>
	{block name="frontend_heptacom_amp_body"}
		{include file="frontend/heptacom_amp/body/header.tpl"}
		<h1 class="sw-product--title">
			{$sArticle.articleName}
		</h1>
		{include file="frontend/heptacom_amp/article_image.tpl"}
		{include file="frontend/heptacom_amp/data.tpl"}
		{include file="frontend/heptacom_amp/buybox.tpl"}
		{include file="frontend/heptacom_amp/description.tpl"}
		{include file="frontend/heptacom_amp/cross_selling.tpl"}
		{include file="frontend/heptacom_amp/body/footer.tpl"}
	{/block}
</body>
