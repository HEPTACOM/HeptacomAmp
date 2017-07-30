{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/javascript" append}
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/amp-validator-v0.min.js"}"></script>
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/vue-2.1.10.min.js"}"></script>
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/validator.js"}"></script>
{/block}

{block name="content/main/header"}
    <div class="container-fluid">
        <nav class="navbar" style="margin-bottom:0;">
            <div class="navbar-header">
                <div class="navbar-text" style="margin: 8px 0 0 8px;">
                    <ol class="breadcrumb" style="margin: 0; background: transparent;">
                        <li>
                            <a href="{url module='backend' controller='HeptacomAmpOverview' action='index'}">
                                <i class="fa fa-bolt"></i> Übersicht
                            </a>
                        </li>
                        <li class="active">
                            <i class="fa fa-check"></i> Validierung
                        </li>
                    </ol>
                </div>
            </div>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="thumbnail">
                    <shop-list
                            shops-url="{url module='backend' controller='HeptacomAmpOverviewData' action='getShops'}"
                            categories-url="{url module='backend' controller='HeptacomAmpOverviewData' action='getCategories'}"
                            articles-url="{url module='backend' controller='HeptacomAmpOverviewData' action='getArticles'}"
                    >
                        <span slot="caption">Artikeldetailseiten</span>
                        <span slot="button"><i class="fa fa-refresh"></i> Artikel validieren</span>
                        <span slot="error">Fehler</span>
                    </shop-list>
                </div>
            </div>
        </div>
    </div>
{/block}
