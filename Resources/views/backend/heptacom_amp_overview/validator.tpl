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
                <div class="navbar-brand">
                    <a href="https://heptacom.de/" target="_blank">
                        <img src="{link file="backend/_resources/HeptacomAmp/images/heptacom.svg"}" width="26" height="26" style="margin:-4px -10px -4px -4px" />
                    </a>
                </div>
                <div class="navbar-brand">
                    <a href="https://ampproject.org/" target="_blank">
                        <img src="{link file="backend/_resources/HeptacomAmp/images/heptacom_amp.svg"}" width="26" height="26" style="margin:-4px -4px -4px -10px" />
                    </a>
                </div>
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
                    <validator fetch-url="{url module='backend' controller='HeptacomAmpOverviewData' action='getArticleIds'}">
                        <span slot="caption">Artikeldetailseiten</span>
                        <span slot="button"><i class="fa fa-bug"></i> Artikel validieren</span>
                        <span slot="error">Fehler</span>
                    </validator>
                </div>
            </div>
        </div>
    </div>
    <table class="collapse table table-condensed">
        <tr class="row" v-for="article in error(articles)">
            <td>
                {ldelim}{ldelim}article.name{rdelim}{rdelim}
                <span class="badge badge-danger">{ldelim}{ldelim}article.errors.length{rdelim}{rdelim}</span>
            </td>
        </tr>
    </table>
{/block}
