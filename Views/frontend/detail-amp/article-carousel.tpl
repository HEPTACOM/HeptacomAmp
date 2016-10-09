{if $articles}
	{block name="frontend_HEPTACOMAMP_article-carousel"}
		<amp-carousel
			class="sw-cross-selling amp-carousel"
			layout="fixed-height"
			type="slides"
			height="400">
			{foreach $articles as $article}
				<div class="slide">
					{include file="frontend/detail-amp/article-carousel-item.tpl" article=$article}
				</div>
			{/foreach}
		</amp-carousel>
	{/block}
{/if}