{if $articles}
	{block name="frontend_heptacom_amp_article_carousel"}
		<amp-carousel
			class="sw-cross-selling amp-carousel"
			layout="fixed-height"
			type="slides"
			height="400">
			{foreach $articles as $article}
				<div class="slide">
					{include file="frontend/heptacom_amp/article_carousel_item.tpl" article=$article}
				</div>
			{/foreach}
		</amp-carousel>
	{/block}
{/if}