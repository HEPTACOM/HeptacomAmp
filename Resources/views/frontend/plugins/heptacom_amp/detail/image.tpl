{block name="frontend_detail_image"}

    {* Product image - Gallery *}
    {block name="frontend_detail_image_box"}
        {strip}
            <amp-carousel layout="fixed-height" type="slides" height="200"
                class="image-slider--container{if !$sArticle.image} no--image{/if}{if !count($sArticle.images)} no--thumbnails{/if}">

                {block name='frontend_detail_image_default_image_slider_item'}

                    {block name='frontend_detail_image_default_image_element'}

                        {$alt = $sArticle.articleName|escape}

                        {if $sArticle.image.description}
                            {$alt = $sArticle.image.description|escape}
                        {/if}

                        {block name='frontend_detail_image_default_image_media'}
                            {if isset($sArticle.image.thumbnails)}
                                {block name='frontend_detail_image_default_picture_element'}
                                    <amp-img layout="fill"
                                        src="{$sArticle.image.thumbnails[1].source}"
                                        srcset="{$sArticle.image.thumbnails[1].sourceSet}"
                                        alt="{$alt}"
                                        itemprop="image"
                                        class="image--element"
                                    ></amp-img>
                                {/block}
                            {else}
                                {block name='frontend_detail_image_fallback'}
                                    <amp-img layout="fill"
                                        src="{link file='frontend/_public/src/img/no-picture.jpg'}"
                                        alt="{$alt}"
                                        itemprop="image"
                                        class="image--element"
                                    ></amp-img>
                                {/block}
                            {/if}
                        {/block}
                    {/block}
                {/block}

                {foreach $sArticle.images as $image}
                    {block name='frontend_detail_images_image_slider_item'}

                        {block name='frontend_detail_images_image_element'}

                            {$alt = $sArticle.articleName|escape}

                            {if $image.description}
                                {$alt = $image.description|escape}
                            {/if}

                            {block name='frontend_detail_images_image_media'}
                                {if isset($image.thumbnails)}
                                    {block name='frontend_detail_images_picture_element'}
                                        <amp-img layout="fill"
                                            src="{$image.thumbnails[1].source}"
                                            srcset="{$image.thumbnails[1].sourceSet}"
                                            alt="{$alt}"
                                            itemprop="image"
                                            class="image--element"
                                        ></amp-img>
                                    {/block}
                                {else}
                                    {block name='frontend_detail_images_fallback'}
                                        <amp-img layout="fill"
                                            src="{link file='frontend/_public/src/img/no-picture.jpg'}"
                                            alt="{$alt}"
                                            itemprop="image"
                                            class="image--element"
                                        ></amp-img>
                                    {/block}
                                {/if}
                            {/block}
                        {/block}
                    {/block}
                {/foreach}
            </amp-carousel>
        {/strip}
    {/block}
{/block}
