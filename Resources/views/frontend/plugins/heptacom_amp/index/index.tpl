{namespace name="frontend/index/index"}

{block name="frontend_index_start"}{/block}
{block name="frontend_index_doctype"}
<!DOCTYPE html>
{/block}

{block name='frontend_index_html'}
<html amp lang="{s name='IndexXmlLang'}{/s}" itemscope="itemscope" itemtype="http://schema.org/WebPage" class="has--csstransforms">
{/block}

{block name='frontend_index_header'}
    {include file='frontend/plugins/heptacom_amp/index/header.tpl'}
{/block}

<body class="{block name="frontend_index_body_classes"}{strip}
    is--ctl-{controllerName|lower} is--act-{controllerAction|lower}
    {if $sUserLoggedIn} is--user{/if}
    {if $sTarget} is--target-{$sTarget|escapeHtml}{/if}
    {if !$theme.displaySidebar} is--no-sidebar{/if}
    {/strip}{/block}">

{block name='frontend_index_after_body'}{/block}

{block name="frontend_index_page_wrap"}

    {* Sidebar left *}
    {block name='frontend_index_content_left'}
        {include file='frontend/plugins/heptacom_amp/index/sidebar.tpl'}
    {/block}

    <div class="page-wrap">

        {* Message if javascript is disabled *}
        {block name="frontend_index_no_script_message"}
            <noscript class="noscript-main">
                {include file="frontend/plugins/heptacom_amp/_includes/messages.tpl" type="warning" content="{s name="IndexNoscriptNotice"}{/s}" borderRadius=false}
            </noscript>
        {/block}

        {block name='frontend_index_before_page'}{/block}

        {* Shop header *}
        {block name='frontend_index_navigation'}
            <header class="header-main is--active-searchfield">

                {block name='frontend_index_header_navigation'}
                    <div class="container header--navigation">

                        {* Logo container *}
                        {block name='frontend_index_logo_container'}
                            {include file="frontend/plugins/heptacom_amp/index/logo-container.tpl"}
                        {/block}

                        {* Shop navigation *}
                        {block name='frontend_index_shop_navigation'}
                            {include file="frontend/plugins/heptacom_amp/index/shop-navigation.tpl"}
                        {/block}
                    </div>
                {/block}
            </header>
        {/block}

        {block name='frontend_index_content_main'}
            <section class="content-main container block-group">

                {* Breadcrumb *}
                {block name='frontend_index_breadcrumb'}
                    {if count($sBreadcrumb)}
                        <nav class="content--breadcrumb block">
                            {block name='frontend_index_breadcrumb_inner'}
                                {include file='frontend/plugins/heptacom_amp/index/breadcrumb.tpl'}
                            {/block}
                        </nav>
                    {/if}
                {/block}

                {* Content top container *}
                {block name="frontend_index_content_top"}{/block}

                <div class="content-main--inner">
                    {* Main content *}
                    {block name='frontend_index_content_wrapper'}
                        <div class="content--wrapper">
                            {block name='frontend_index_content'}{/block}
                        </div>
                    {/block}

                    {* Sidebar right *}
                    {block name='frontend_index_content_right'}{/block}
                </div>
            </section>
        {/block}

        {* Footer *}
        {block name="frontend_index_footer"}
            <footer class="footer-main">
                <div class="container">
                    {block name="frontend_index_footer_container"}
                        {include file='frontend/plugins/heptacom_amp/index/footer.tpl'}
                    {/block}
                </div>
            </footer>
        {/block}

        {block name='frontend_index_body_inline'}{/block}
    </div>
{/block}
</body>
</html>
