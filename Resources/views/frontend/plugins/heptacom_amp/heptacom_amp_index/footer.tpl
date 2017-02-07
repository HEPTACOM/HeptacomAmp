{* Footer menu *}
{block name='frontend_index_footer_menu'}
    <div class="footer--columns block-group">
        {include file='frontend/plugins/heptacom_amp/heptacom_amp_index/footer-navigation.tpl'}
    </div>
{/block}

{* Copyright in the footer *}
{block name='frontend_index_footer_copyright'}
    <div class="footer--bottom">

        {* Vat info *}
        {block name='frontend_index_footer_vatinfo'}
            <div class="footer--vat-info">
                <p class="vat-info--text">
                    {if $sOutputNet}
                        {s name='FooterInfoExcludeVat' namespace="frontend/index/footer"}{/s}
                    {else}
                        {s name='FooterInfoIncludeVat' namespace="frontend/index/footer"}{/s}
                    {/if}
                </p>
            </div>
        {/block}

        {block name='frontend_index_footer_minimal'}
            {include file="frontend/plugins/heptacom_amp/heptacom_amp_index/footer_minimal.tpl" hideCopyrightNotice=true}
        {/block}

        {* Shopware footer *}
        {block name="frontend_index_shopware_footer"}

            {* Copyright *}
            {block name="frontend_index_shopware_footer_copyright"}
                <div class="footer--copyright">
                    {s name="IndexCopyright"}{/s}
                </div>
            {/block}

            {* Logo *}
            {block name="frontend_index_shopware_footer_logo"}
                <div class="footer--logo">
                    {if $supportHeptacom}
                        <a href="https://www.heptacom.de/" title="{s name='HeptacomAmpFooterLinkTitle'}Realisiert durch HEPTACOM{/s}">
                            <amp-img src="{link file='frontend/_public/src/img/icons/icon--heptacom.png'}"
                                 alt="{s name='HeptacomAmpFooterImageAlt'}HEPTACOM{/s}"
                                 height="32"
                                 width="32"
                                 layout="fixed">
                            </amp-img>
                        </a>
                    {else}
                        <i class="icon--shopware"></i>
                    {/if}
                </div>
            {/block}
        {/block}
    </div>
{/block}
