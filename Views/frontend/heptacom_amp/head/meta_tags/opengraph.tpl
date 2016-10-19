{block name='frontend_heptacom_amp_head_meta_tags_opengraph'}
	<meta property="og:type" content="product" />
	<meta property="og:site_name" content="{{config name=sShopname}|escapeHtml}" />
	<meta property="og:url" content="{url sArticle=$sArticle.articleID title=$sArticle.articleName controller=index}" />
	<meta property="og:title" content="{$sArticle.articleName|escapeHtml}" />
	<meta property="og:description" content="{$sArticle.description_long|strip_tags|truncate:240|escapeHtml}" />
	<meta property="og:image" content="{$sArticle.image.source}" />
{/block}
