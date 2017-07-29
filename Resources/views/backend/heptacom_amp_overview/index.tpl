{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/javascript" append}
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/index.js"}"></script>
{/block}

{block name="content/layout/javascript"}
    heptacom.setUrls({$urls|json_encode});
{/block}

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
            </div>
        </nav>
    </div>
{/block}

{block name="content/main/content"}
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>
                            <i class="fa fa-cog"></i> Systemprüfung
                        </h3>
                        <p class="text-justify">
                            Überprüfen Sie, ob alle notwendigen Abhängigkeiten für die Nutzung von dem HEPTACOM AMP Plugin
                            in Ihrem Shop verfügbar sind.
                        </p>
                        <p class="text-right">
                            <a class="btn btn-primary" href="{url module='backend' controller='HeptacomAmpOverview' action='dependencies'}">
                                Jetzt prüfen
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>
                            <i class="fa fa-check"></i> Validierung
                        </h3>
                        <p class="text-justify">
                            Lassen Sie Ihre Seiten auf ihre AMP-Konformität prüfen. Nur valide Seiten werden auch von
                            <i class="fa fa-google"></i>oogle in den Cache aufgenommen.
                        </p>
                        <p class="text-right">
                            <a class="btn btn-primary" href="{url module='backend' controller='HeptacomAmpOverview' action='validator'}">
                                Inhalte validieren
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>
                            <i class="fa fa-tachometer"></i> Cache erzeugen
                        </h3>
                        <p class="text-justify">
                            Zur Schonung der Rechenleistung werden alle Inhalte zwischengespeichert. Sollten Sie gerade
                            Ihren Cache gelöscht haben sollten Sie nun Ihren AMP Zwischenspeicher neuerzeugen.
                        </p>
                        <p class="text-right">
                            <a class="btn btn-primary" href="{url module='backend' controller='HeptacomAmpOverview' action='cacheWarmer'}">
                                Inhalte erzeugen
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}
