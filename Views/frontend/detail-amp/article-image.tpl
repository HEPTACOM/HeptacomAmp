{if $sArticle.images}{strip}
	{block name="frontend_detail-amp_image"}
		<amp-carousel layout="fixed-height" type="slides" height="400">
			{$pictures = $sArticle.images}
			{* TODO find better way to suppress echo of the array_unshift result *}
			{$_ = $pictures|array_unshift:$sArticle.image}
			{foreach $pictures as $image}
				{if $image.thumbnails}
					{block name='frontend_detail-amp_images'}
						<amp-img layout="fill" src="{$image.thumbnails[1].source}"></amp-img>
					{/block}
				{/if}
			{/foreach}
		</amp-carousel>
	{/block}
{/strip}{/if}