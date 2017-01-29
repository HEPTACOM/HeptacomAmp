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
            <ul class="nav nav-pills" role="tablist">
                <li role="presentation" class="active">
                    <a href="#tabsystem" aria-controls="tabsystem" role="tab" data-toggle="tab">
                        <i class="glyphicon glyphicon-cog"></i>
                        Systemanforderungen
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tabvalidator" aria-controls="tabvalidator" role="tab" data-toggle="tab">
                        <i class="glyphicon glyphicon-ok"></i>
                        Validator
                    </a>
                </li>
            </ul>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tabsystem">
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
                {foreach $tabSystemDependencies as $dep}
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
        </div>
        <div role="tabpanel" class="tabpane" id="tabvalidator">
            <table class="table table-condensed table-bordered">
                {foreach $tabValidatorArticleDetails as $detail}
                    <tr data-ampurl="../heptacomAmpDetail/index/sArticle/{$detail->getArticle()->getId()}">
                        <td class="col-xs-2">
                            {$detail->getNumber()}
                        </td>
                        <td class="col-xs-3">
                            {$detail->getArticle()->getName()}
                        </td>
                        <td class="col-xs-4 text-right">
                            <span class="label label-success hidden">
                                <i class="glyphicon glyphicon-ok-circle" style="color:#fff"></i>
                            </span>
                            <span class="label label-danger hidden">
                                4
                            </span>
                            <div class="col-xs-12 collapsed"></div>
                        </td>
                        <td class="col-xs-3 text-right">
                            <span class="btn-group">
                                <button class="btn btn-link" onclick="heptacom.btnValidateRow(event)">
                                    <i class="glyphicon glyphicon-ok"></i>
                                </button>
                                <button class="btn btn-link">
                                    <i class="glyphicon glyphicon-envelope"></i>
                                </button>
                                <a href="{url sArticle=$detail->getArticle()->getId() title=$detail->getArticle()->getName() controller='detail'}" class="btn btn-link">
                                    <i class="glyphicon glyphicon-th"></i>
                                </a>
                                <a href="{url sArticle=$detail->getArticle()->getId() title=$detail->getArticle()->getName() controller='heptacomAmpDetail' forceSecure}" class="btn btn-link">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>
{/block}


{block name="head" prepend}{literal}
    <script id="validationResult" type="text/x-handlebars-template">
        <dl>
            {{#each errors}}
                <dt>{{code}}</dt>
                <dd>{{#each params}}<span>{{this}}</span>{{/each}}</dd>
            {{/each}}
        </dl>
    </script>
{/literal}{/block}

{block name="content/javascript" append}
    <script type="text/javascript" src="https://cdn.ampproject.org/v0/validator.js"></script>
    <script type="text/javascript" src="{link file="backend/_resources/HeptacomAmp/js/handlebars-v3.0.3.js"}"></script>
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/index.js"}"></script>
{/block}

{block name="content/layout/javascript"}{literal}
    $('[role=tablist]').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    postMessageApi.window.setTitle('HEPTACOM - AMP');
{/literal}{/block}