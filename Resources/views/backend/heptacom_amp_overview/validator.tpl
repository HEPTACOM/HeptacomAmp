{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/javascript" append}
    <script type="text/javascript" src="https://cdn.ampproject.org/v0/validator.js"></script>
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/handlebars-v3.0.3.js"}"></script>
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/validator.js"}"></script>
{/block}

{block name="content/layout/javascript"}
    heptacom.setUrls({ldelim}
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
                        <i class="glyphicon glyphicon-cog"></i>
                        Systemanforderungen
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <i class="glyphicon glyphicon-ok"></i>
                        Validator
                    </a>
                </li>
            </ul>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <table class="table table-condensed">
        <tr>
            <th class="col-xs-7">
                Bereiche
            </th>
            <th class="col-xs-3"></th>
        </tr>
        <tr>
            <td>
                Artikeldetails
            </td>
            <td class="text-right">
                <span class="btn-group">
                    <button class="btn btn-link" onclick="heptacom.btnValidateArticleDetails(event)">
                        <i class="glyphicon glyphicon-ok"></i>
                    </button>
                </span>
            </td>
        </tr>
    </table>
{/block}
