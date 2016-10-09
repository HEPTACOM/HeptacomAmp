{if !$sArticle.crossbundlelook}{strip}
	{if $sArticle.sSimilarArticles}
		<span class="sw-cross-selling-header">
			{block name="frontend_heptacom_amp_cross_selling_title"}
				Ähnliche Artikel
			{/block}
		</span>
        {include file="frontend/heptacom_amp/article_carousel.tpl" articles=$sArticle.sSimilarArticles}
	{/if}
	{if $sArticle.sRelatedArticles}
		<span class="sw-cross-selling-header">
			{block name="frontend_heptacom_amp_cross_selling_title"}
				Zubehör
			{/block}
		</span>
        {include file="frontend/heptacom_amp/article_carousel.tpl" articles=$sArticle.sRelatedArticles}
	{/if}
{/strip}{/if}
