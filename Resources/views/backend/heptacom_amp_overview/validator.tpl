{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/javascript" append}
    <script type="text/javascript" src="https://cdn.ampproject.org/v0/validator.js"></script>
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/vue-2.1.10.min.js"}"></script>
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/validator.js"}"></script>
{/block}

{block name="content/layout/javascript"}
    heptacom.setUrls({ldelim}
        getArticleIds: '{url module='backend' controller='HeptacomAmpOverviewData' action='getArticleIds'}'
    {rdelim});
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
            </div>
            <ul class="nav nav-pills">
                <li>
                    <a href="{url controller='HeptacomAmpOverview' module='backend' action='dependencies'}">
                        <i class="fa fa-cog"></i>
                        Systemanforderungen
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <i class="fa fa-check"></i>
                        Validator
                    </a>
                </li>
            </ul>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <div class="panel panel-default" id="heptacomArticles">
        <div class="panel-heading">
            <h3 class="panel-title">
                Artikel
            </h3>
        </div>
        <div class="panel-body text-right">
            <span class="btn-group">
                <button class="btn btn-link" :disabled="!fetchedData || fetchingData" onclick="heptacom.btnValidateArticles(event)">
                    <i class="fa fa-bug"></i>
                </button>
                <button class="btn btn-link" :disabled="fetchingData" onclick="heptacom.btnLoadArticles(event)">
                    <i v-if="fetchingData" class="fa fa-spin fa-refresh"></i>
                    <i v-else class="fa fa-refresh"></i>
                </button>
            </span>
        </div>
        <table class="table table-condensed">
            <tr class="row" v-for="article in fetched(articles)">
                <td>
                    {ldelim}{ldelim}article.name{rdelim}{rdelim}
                </td>
            </tr>
        </table>
    </div>
{/block}
