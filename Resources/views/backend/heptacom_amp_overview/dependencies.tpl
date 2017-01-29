{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

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
                <li class="active">
                    <a href="#">
                        <i class="glyphicon glyphicon-cog"></i>
                        Systemanforderungen
                    </a>
                </li>
                <li>
                    <a href="{url controller='HeptacomAmpOverview' module='backend' action='validator'}">
                        <i class="glyphicon glyphicon-ok"></i>
                        Validator
                    </a>
                </li>
            </ul>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <table class="table table-condensed table-bordered">
        <tr>
            <th class="col-xs-7">
                Name
            </th>
            <th class="col-xs-2 text-right">
                Erforderliche Version
            </th>
            <th class="col-xs-2 text-right">
                Installierte Version
            </th>
            <th class="col-xs-1"></th>
        </tr>
        {foreach $dependencies as $dep}
            <tr>
                <td class="col-xs-7">
                    {$dep->getName()}
                </td>
                <td class="col-xs-2 text-right">
                    {$dep->getRequiredVersion()}
                </td>
                <td class="col-xs-2 text-right">
                    {$dep->getInstalledVersion()}
                </td>
                <td class="col-xs-1 text-right">
                    <i class="{if $dep->isOk()}glyphicon glyphicon-ok-sign text-success{else}glyphicon glyphicon-exclamation-sign text-danger{/if}"></i>
                </td>
            </tr>
        {/foreach}
    </table>
{/block}
