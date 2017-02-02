{*
{block name="frontend_heptacom_amp_body_header_searchbar"}
    <div class="sw-header--navigation">
        {block name="frontend_heptacom_amp_body_header_searchbar_button"}
            <div class="sw-header--navigation-item sw-header--navigation-item--btn">
                <button class="sw-btn"
                        on="tap:offcanvas-menu.open">
                    {block name="frontend_heptacom_amp_body_header_searchbar_button_icon"}
                        <i class="icon--menu"></i>
                    {/block}
                    {block name="frontend_heptacom_amp_body_header_searchbar_button_text"}
                        <span>Menü</span>
                    {/block}
                </button>
            </div>
        {/block}
        {block name="frontend_heptacom_amp_body_header_searchbar_form"}
            <form method="GET"
                  target="_top"
                  action="{url controller='search' fullPath=true forceSecure}"
                  class="sw-main-search-form sw-header--navigation-item">
                {block name="frontend_heptacom_amp_body_header_searchbar_form_search-field"}
                    <input type="search" name="sSearch" placeholder="Suchbegriff..." maxlength="30" />
                {/block}
            </form>
        {/block}
    </div>
{/block}
*}




<nav class="shop--navigation block-group">
    <ul class="navigation--list block-group" role="menubar">

        {* Menu (Off canvas left) trigger *}
        {block name='frontend_index_offcanvas_left_trigger'}
            <li class="navigation--entry entry--menu-left" role="menuitem">
                <a class="entry--link entry--trigger btn is--icon-left" href="#offcanvas--left" on="tap:offcanvas-menu.open">
                    <i class="icon--menu"></i> {s namespace='frontend/index/menu_left' name="IndexLinkMenu"}{/s}
                </a>
            </li>
        {/block}

        {* Search form *}
        {block name='frontend_index_search'}
            <li class="navigation--entry entry--search is--active" role="menuitem" data-search="true" aria-haspopup="true">
                <a class="btn entry--link entry--trigger is--active" href="#show-hide--search" title="{"{s namespace='frontend/index/search' name="IndexTitleSearchToggle"}{/s}"|escape}">
                    <i class="icon--search"></i>

                    {block name='frontend_index_search_display'}
                        <span class="search--display">{s namespace='frontend/index/search' name="IndexSearchFieldSubmit"}{/s}</span>
                    {/block}
                </a>

                {* Include of the search form *}
                {block name='frontend_index_search_include'}
                    {include file="frontend/plugins/heptacom_amp/heptacom_amp_index/search.tpl"}
                {/block}
            </li>
        {/block}

        {* Cart entry *}
        {block name='frontend_index_checkout_actions'}
            {* Include of the cart *}
            {block name='frontend_index_checkout_actions_include'}
                {action module=widgets controller=checkout action=info}
            {/block}
        {/block}
    </ul>
</nav>
