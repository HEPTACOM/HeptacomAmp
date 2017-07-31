<template>
    <div>
        <navigation>
            <li>
                <ul class="uk-navbar-item uk-breadcrumb">
                    <li>
                        <span>
                            <i class="fa fa-bolt"></i>
                            &nbsp;
                            Übersicht
                        </span>
                    </li>
                </ul>
            </li>
        </navigation>
        <div class="uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-3@l uk-grid-match uk-grid-large uk-padding-large" uk-grid>
            <div>
                <div class="uk-card uk-card-default uk-card-hover">
                    <div class="uk-card-header">
                        <i class="fa fa-cog"></i>
                        &nbsp;
                        Systemprüfung
                    </div>
                    <div class="uk-card-body">
                        Überprüfen Sie, ob alle notwendigen Abhängigkeiten für die Nutzung von dem KSK-Agentur AMP Plugin in Ihrem Shop verfügbar sind.
                    </div>
                    <div class="uk-card-footer">
                        <router-link to="/dependencies" class="uk-button uk-button-primary">
                            Jetzt prüfen
                        </router-link>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-hover">
                    <div class="uk-card-header">
                        <i class="fa fa-check"></i>
                        &nbsp;
                        Validierung
                    </div>
                    <div class="uk-card-body">
                        Lassen Sie Ihre Seiten auf ihre AMP-Konformität prüfen. Nur valide Seiten werden auch von <i class="fa fa-google"></i>oogle in den Cache aufgenommen.
                    </div>
                    <div class="uk-card-footer">
                        <router-link to="/validation" class="uk-button uk-button-primary">
                            Inhalte validieren
                        </router-link>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-hover">
                    <div class="uk-card-header">
                        <i class="fa fa-tachometer"></i>
                        &nbsp;
                        Cache erzeugen
                    </div>
                    <div class="uk-card-body">
                        Zur Schonung der Rechenleistung werden alle Inhalte zwischengespeichert. Sollten Sie gerade Ihren Cache gelöscht haben sollten Sie nun Ihren AMP Zwischenspeicher neuerzeugen.
                    </div>
                    <div class="uk-card-footer">
                        <router-link to="/cache_warmer" class="uk-button uk-button-primary">
                            Inhalte erzeugen
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
    import Navigation from '../components/navigation.vue';

    export default {
        components: {
            Navigation
        }
    }
</script>