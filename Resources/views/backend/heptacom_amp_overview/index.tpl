{extends file="parent:backend/_resources/HeptacomAmp/_forms/basic.tpl"}

{block name="content/javascript" append}
    <script type="text/javascript" src="{link file="backend/heptacom_amp_overview/index.js"}"></script>
{/block}

{block name="content/layout/javascript"}
    heptacom.setUrls({$urls|json_encode});
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
