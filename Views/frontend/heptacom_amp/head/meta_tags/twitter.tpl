{block name='frontend_heptacom_amp_head_meta_tags_twitter'}
	<meta name="twitter:card" content="product" />
	<meta name="twitter:site" content="{{config name=sShopname}|escapeHtml}" />
	<meta name="twitter:title" content="{$sArticle.articleName|escapeHtml}" />
	<meta name="twitter:description" content="{$sArticle.description_long|strip_tags|truncate:240|escapeHtml}" />
	<meta name="twitter:image" content="{$sArticle.image.source}" />
{/block}
