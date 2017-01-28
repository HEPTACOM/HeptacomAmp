{if !$sArticle.crossbundlelook}
	{if $sArticle.sSimilarArticles}
		{block name="frontend_heptacom_amp_body_article_cross_selling"}
			<span class="sw-cross-selling-header">
				{block name="frontend_heptacom_amp_body_article_cross_selling_similar_title"}
					Ähnliche Artikel
				{/block}
			</span>
			{include file="frontend/heptacom_amp/body/articles/carousel.tpl" articles=$sArticle.sSimilarArticles}
		{/block}
	{/if}
	{if $sArticle.sRelatedArticles}
		{block name="frontend_heptacom_amp_body_article_cross_selling"}
			<span class="sw-cross-selling-header">
				{block name="frontend_heptacom_amp_body_article_cross_selling_related_title"}
					Zubehör
				{/block}
			</span>
			{include file="frontend/heptacom_amp/body/articles/carousel.tpl" articles=$sArticle.sRelatedArticles}
		{/block}
	{/if}
{/if}
