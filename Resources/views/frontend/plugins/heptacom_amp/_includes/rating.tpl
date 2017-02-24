{* Type *}
{block name='frontend_rating_type'}
    {$isType='single'} {* available options: single (default) or aggregated *}
    {if isset($type)}
        {$isType=$type}
    {/if}
{/block}

{* Base *}
{block name='frontend_rating_base'}
    {$isBase=10} {* available options: 10 (default) or 5 *}
    {if isset($base)}
        {$isBase=$base}
    {/if}
{/block}

{* Microdata *}
{block name='frontend_rating_microdata'}
    {$hasMicroData=true}
    {if isset($microData)}
        {$hasMicroData=$microData}
    {/if}
    {if $hasMicroData && $isType === 'aggregated' && $count === 0} {* Don't display microdata for empty aggregated ratings *}
        {$hasMicroData=false}
    {/if}
{/block}

{* Microdata depending on type *}
{block name='frontend_rating_microdata_type'}
    {if $isType === 'single'}
        {$data='itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"'}
    {else}
        {$data='itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"'}
    {/if}
{/block}

{* Label *}
{block name='frontend_rating_label'}
    {if isset($label)}
        {$hasLabel=$label}
    {/if}
{/block}

{* Label depending on type *}
{block name='frontend_rating_label_type'}
    {if $isType === 'aggregated'}
        {$hasLabel=true}
    {else}
        {$hasLabel=false}
    {/if}
{/block}

{* Star rating content *}
{block name='frontend_rating_content'}
    <span class="product--rating"{if $hasMicroData} {$data}{/if}>

        {* Average calculation *}
        {block name='frontend_rating_content_average'}
            {$average = $points / 2}
            {if $isBase == 5}
                {$average = $points}
            {/if}
        {/block}

        {* Microdata *}
        {block name='frontend_rating_content_microdata'}
            {if $hasMicroData}
                <meta itemprop="ratingValue" content="{$points}">
                <meta itemprop="worstRating" content="1">
                <meta itemprop="bestRating" content="{$isBase}">
                {if $isType === 'aggregated'}
                    <meta itemprop="ratingCount" content="{$count}">
                {/if}
            {/if}
        {/block}

        {* Stars *}
        {block name='frontend_rating_content_stars'}
            {if $points != 0}
                {for $value=1 to 5}
                    {$cls = 'icon--star'}

                    {if $value > $average}
                        {$diff=$value - $average}

                        {if $diff > 0 && $diff <= 0.5}
                            {$cls = 'icon--star-half'}
                        {else}
                            {$cls = 'icon--star-empty'}
                        {/if}
                    {/if}

                    <i class="{$cls}"></i>
                {/for}
            {/if}
        {/block}

        {* Label *}
        {block name='frontend_rating_content_label'}
            {if $hasLabel && $count}
                <span class="rating--count-wrapper">
                    (<span class="rating--count">{$count}</span>)
                </span>
            {/if}
        {/block}
    </span>
{/block}
