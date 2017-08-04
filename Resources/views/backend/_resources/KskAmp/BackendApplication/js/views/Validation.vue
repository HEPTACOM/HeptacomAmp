<template>
    <div>
        <navigation>
            <li>
                <ul class="uk-navbar-item uk-breadcrumb">
                    <li>
                        <router-link to="/">
                            <f-a icon="bolt"></f-a>
                            &nbsp;
                            Übersicht
                        </router-link>
                    </li>
                    <li>
                        <span>
                            <f-a icon="check"></f-a>
                            &nbsp;
                            Validierung
                        </span>
                    </li>
                </ul>
            </li>
        </navigation>
    </div>
</template>

<script type="application/javascript">
    import FA from '../components/font-awesome.vue';
    import Navigation from '../components/navigation.vue';

    export default {
        components: {
            FA,
            Navigation
        }
    }
</script>