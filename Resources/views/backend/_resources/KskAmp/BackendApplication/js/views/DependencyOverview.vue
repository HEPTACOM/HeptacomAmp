<template>
    <div>
        <navigation>
            <li>
                <ul class="uk-navbar-item uk-breadcrumb">
                    <li>
                        <router-link to="/">
                            <i class="fa fa-bolt"></i>
                            &nbsp;
                            Übersicht
                        </router-link>
                    </li>
                    <li>
                        <span>
                            <i class="fa fa-cog"></i>
                            &nbsp;
                            Systemprüfung
                        </span>
                    </li>
                </ul>
            </li>
        </navigation>
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