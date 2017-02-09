{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/javascript" append}
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/vue-2.1.10.min.js"}"></script>
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/cache_warmer.js"}"></script>
{/block}

{block name="content/layout/javascript"}
    heptacom.setUrls({$urls|json_encode});
    heptacom.warmup();
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
                            <i class="fa fa-tachometer"></i> Cache erzeugen
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
                    <div id="cacheWarmerArticleDetails" class="caption">
                        <h3>
                            Artikeldetailseiten
                            &nbsp;
                            <span class="badge">
                                {ldelim}{ldelim}progressMax{rdelim}{rdelim}
                            </span>
                        </h3>
                        <p v-show="processing || (progressSuccessValue + progressFailureValue) == progressMax">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-danger active" :style="{ width: percentFailureComplete + '%' }"></div>
                                <div class="progress-bar progress-bar-striped progress-bar-success active" :style="{ width: percentSuccessComplete + '%' }"></div>
                            </div>
                        </p>
                        <p class="text-center">
                            <button class="btn btn-success" :disabled="!fetchedAllData || processing" @click="btnWarmup($event)">
                                <i class="fa fa-refresh"></i> Cache erzeugen
                            </button>
                        </p>
                        <div v-show="progressFailureValue" class="panel panel-default">
                            <div class="panel-heading">
                                Fehler
                                &nbsp;
                                <span class="badge">
                                    {ldelim}{ldelim}progressFailureValue{rdelim}{rdelim}
                                </span>
                            </div>
                            <div class="panel-body">
                                <div class="table table-striped table-condensed">
                                    <div v-for="article in errors" class="row">
                                        <div class="col-xs-10">
                                            {ldelim}{ldelim}article.name{rdelim}{rdelim}
                                        </div>
                                        <div class="col-xs-2 text-right">
                                            <div class="btn-group">
                                                <a class="btn btn-link" :href="article.url" target="_blank">
                                                    <i class="fa fa-desktop"></i>
                                                </a>
                                                <a class="btn btn-link" :href="article.amp_url" target="_blank">
                                                    <i class="fa fa-mobile"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}
