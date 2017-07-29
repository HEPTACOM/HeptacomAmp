{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/main/header"}
    <div class="container-fluid">
        <nav class="navbar" style="margin-bottom:0;">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <a href="https://www.ksk-agentur.de/" target="_blank">
                        <img src="{link file="backend/_resources/HeptacomAmp/images/ksk-agentur.svg"}" width="62" height="26" style="margin:-4px -10px -4px -4px" />
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
                            <i class="fa fa-cog"></i> Systemprüfung
                        </li>
                    </ol>
                </div>
            </div>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <table class="table table-condensed table-bordered">
        <tr>
            <th class="col-xs-8 col-md-10">
                Name
            </th>
            <th class="col-xs-2 col-md-1 text-right">
                Erforderliche Version
            </th>
            <th class="col-xs-2 col-md-1 text-right">
                Installierte Version
            </th>
        </tr>
        {foreach $dependencies as $dep}
            <tr>
                <td class="col-xs-8 col-md-10">
                    <i class="fa fa-{if $dep->isOk()}check-circle text-success{else}exclamation-triangle text-danger{/if}"></i>
                    &nbsp;
                    {$dep->getName()}
                </td>
                <td class="col-xs-2 col-md-1 text-right">
                    {$dep->getRequiredVersion()}
                </td>
                <td class="col-xs-2 col-md-1 text-right">
                    {$dep->getInstalledVersion()}
                </td>
            </tr>
        {/foreach}
    </table>
{/block}
