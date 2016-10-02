{if !$sArticle.crossbundlelook}{strip}
	{if $sArticle.sSimilarArticles}
		<span class="sw-cross-selling-header">
			{block name="frontend_detail-amp_cross-selling_title"}
				Ähnliche Artikel
			{/block}
		</span>
        {include file="frontend/detail-amp/article-carousel.tpl" articles=$sArticle.sSimilarArticles}
	{/if}
	{if $sArticle.sRelatedArticles}
		<span class="sw-cross-selling-header">
			{block name="frontend_detail-amp_cross-selling_title"}
				Zubehör
			{/block}
		</span>
        {include file="frontend/detail-amp/article-carousel.tpl" articles=$sArticle.sRelatedArticles}
	{/if}
{/strip}{/if}
