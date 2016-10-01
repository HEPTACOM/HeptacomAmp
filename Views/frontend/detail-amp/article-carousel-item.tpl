{block name="frontend_detail-amp_article-carousel-item"}
	<a href="{$article.linkDetails|rewrite:$article.articleName}" target="_blank">
		{block name="frontend_detail-amp_article-carousel-item_image"}
			<amp-img layout="responsive" height="{$article.image.height}" width="{$article.image.width}" src="{$article.image.thumbnails[1].source}"></amp-img>
		{/block}
		{block name="frontend_detail-amp_article-carousel-item_text"}
			<amp-fit-text layout="responsive" width="{$imageWidth}" height="{$textHeight}">
				<span>
					{block name="frontend_detail-amp_article-carousel-item_name"}
						<span class="sw-article-name">
							{$article.articleName|truncate:50|escapeHtml}
						</span>
					{/block}
				</span>
				<br/>
				<span>
					{block name="frontend_detail-amp_article-carousel-item_price"}
						{if $article.has_pseudoprice}
							{include file="frontend/detail-amp/price.tpl" price=$article.price class="sw-discount"}
							{include file="frontend/detail-amp/price.tpl" price=$article.pseudoprice}
						{else}
							{include file="frontend/detail-amp/price.tpl" price=$article.price}
						{/if}
					{/block}
				</span>
			</amp-fit-text>
		{/block}
	</a>
{/block}