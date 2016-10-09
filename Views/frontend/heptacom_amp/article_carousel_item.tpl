{block name="frontend_heptacom_amp_article_carousel_item"}
	<a href="{$article.linkDetails|rewrite:$article.articleName}">
		{block name="frontend_heptacom_amp_article_carousel_item_image"}
			<amp-img layout="fixed-height" height="350" src="{$article.image.thumbnails[1].source}"></amp-img>
		{/block}
		{block name="frontend_heptacom_amp_article_carousel_item_text"}
			<amp-fit-text layout="fixed-height" height="50">
				<span>
					{block name="frontend_heptacom_amp_article_carousel_item_name"}
						<span class="sw-article-name">
							{$article.articleName|truncate:50|escapeHtml}
						</span>
					{/block}
				</span>
				<br/>
				<span>
					{block name="frontend_heptacom_amp_article_carousel_item_price"}
						{if $article.has_pseudoprice}
							{include file="frontend/heptacom_amp/price.tpl" price=$article.price class="sw-discount"}
							{include file="frontend/heptacom_amp/price.tpl" price=$article.pseudoprice}
						{else}
							{include file="frontend/heptacom_amp/price.tpl" price=$article.price}
						{/if}
					{/block}
				</span>
			</amp-fit-text>
		{/block}
	</a>
{/block}