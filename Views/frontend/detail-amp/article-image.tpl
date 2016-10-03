{$pictures = []}
{if $sArticle.image}
	{$pictures[] = $sArticle.image}
{/if}
{if $sArticle.images}
	{$pictures = array_merge($pictures, $sArticle.images)}
{/if}

{if $pictures}{strip}
	{block name="frontend_detail-amp_image"}
		<amp-carousel layout="fixed-height" type="slides" height="400">
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