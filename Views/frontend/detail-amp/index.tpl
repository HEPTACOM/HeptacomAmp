<!DOCTYPE html>
{* TODO: get lang from shopware *}
<html ⚡ lang="de">

    {include file="frontend/detail-amp/header.tpl"}

    <body>

        <header class="header-main">
            {block name='frontend_index_header_navigation'}
                <div class="container header--navigation">
                    {* Logo container *}
                    {block name='frontend_index_logo_container'}
                        {include file="frontend/index/logo-container.tpl"}
                    {/block}

                    {* Shop navigation *}
                    {block name='frontend_index_shop_navigation'}
                        {include file="frontend/index/shop-navigation.tpl"}
                    {/block}
                </div>
            {/block}
        </header>
        
        {include file="frontend/detail-amp/offcanvas-navigation.tpl"}
        {include file="frontend/detail-amp/article-image.tpl"}
        {include file="frontend/detail-amp/description.tpl"}
        {include file="frontend/detail-amp/cross-selling.tpl"}
        {include file="frontend/detail-amp/footer.tpl"}
    </body>
</html>
