{if $articles}
	{block name="frontend_detail-amp_article-carousel"}
		{* define start values *}
		{$textHeight = 40}
		{$imageHeight = null}
		{$imageWidth = null}

		{* iterator through all articles to find the best image size *}
		{foreach $articles as $article}
			{if is_null($imageWidth) || ($article.image.height / $article.image.width) > ($imageHeight / $imageWidth)}
				{if ((480 - $textHeight) * $article.image.width / $article.image.height <= 320)
				 xor (320 * $article.image.height / $article.image.width <= 480 - $textHeight)}
					{$imageWidth = $article.image.width}
					{$imageHeight = $article.image.height}
				{/if}
			{/if}
		{/foreach}

		{* if the detection did not work fine, then just take the minimum support size *}
		{if $imageHeight}
			{$imageWidth = intval(320 * $imageHeight / $imageWidth)}
			{$imageHeight = intval(480 * $imageWidth / $imageHeight)}
		{else}
			{$imageHeight = intval(480 - $textHeight)}
			{$imageWidth = intval(320)}
		{/if}
		<amp-carousel
			class="sw-cross-selling"
			layout="responsive"
			type="slides"
			height="{$imageHeight + $textHeight}"
			width="{$imageWidth}">
			{foreach $articles as $article}
				<div class="slide">
					{include
						file="frontend/detail-amp/article-carousel-item.tpl"
						article=$article
						imageHeight=$imageHeight
						imageWidth=$imageWidth
						textHeight=$textHeight}
				</div>
			{/foreach}
		</amp-carousel>
	{/block}
{/if}