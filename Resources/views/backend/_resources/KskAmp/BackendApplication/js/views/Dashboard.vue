<template>
    <div>
        <navigation></navigation>
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