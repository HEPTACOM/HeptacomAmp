{namespace name="frontend/detail/tabs"}

{* Tab navigation for the product detail page *}
{block name="frontend_detail_tabs"}
    <div class="tab-menu--product">
        {block name="frontend_detail_tabs_inner"}

            {* Content list *}
            {block name="frontend_detail_tabs_content"}
                <amp-accordion class="tab--container-list" disable-session-states>
                    {block name="frontend_detail_tabs_content_inner"}

                        {* Description container *}
                        {block name="frontend_detail_tabs_content_description"}
                            <section class="tab--container has--border">
                                {block name="frontend_detail_tabs_content_description_inner"}

                                    {* Description title *}
                                    {block name="frontend_detail_tabs_content_description_title"}
                                        <header class="tab--header">
                                            {block name="frontend_detail_tabs_content_description_title_inner"}
                                                <a href="#" class="tab--title" title="{s name='DetailTabsDescription'}{/s}">{s name='DetailTabsDescription'}{/s}</a>
                                            {/block}
                                        </header>
                                    {/block}

                                    {* Description content *}
                                    {block name="frontend_detail_tabs_content_description_description"}
                                        <div class="tab--content">
                                            {block name="frontend_detail_tabs_content_description_description_inner"}
                                                {include file="frontend/plugins/heptacom_amp/detail/tabs/description.tpl"}
                                            {/block}
                                        </div>
                                    {/block}

                                {/block}
                            </section>
                        {/block}

                        {* Rating container *}
                        {block name="frontend_detail_tabs_content_rating"}
                            {if !{config name=VoteDisable}}
                                <section class="tab--container has--border">
                                    {block name="frontend_detail_tabs_content_rating_inner"}

                                        {* Rating title *}
                                        {block name="frontend_detail_tabs_rating_title"}
                                            <header class="tab--header">
                                                {block name="frontend_detail_tabs_rating_title_inner"}
                                                    <a href="#" class="tab--title" title="{s name='DetailTabsRating'}{/s}">{s name='DetailTabsRating'}{/s}
                                                        {block name="frontend_detail_tabs_rating_title_count"}
                                                            <span class="product--rating-count">{$sArticle.sVoteAverage.count}</span>
                                                        {/block}
                                                    </a>
                                                {/block}
                                            </header>
                                        {/block}

                                        {* Rating content *}
                                        {block name="frontend_detail_tabs_rating_content"}
                                            <div class="tab--content">
                                                {block name="frontend_detail_tabs_rating_content_inner"}
                                                    {include file="frontend/plugins/heptacom_amp/detail/tabs/comment.tpl"}
                                                {/block}
                                            </div>
                                        {/block}

                                    {/block}
                                </section>
                            {/if}
                        {/block}

                    {/block}
                </amp-accordion>
            {/block}

        {/block}
    </div>
{/block}
