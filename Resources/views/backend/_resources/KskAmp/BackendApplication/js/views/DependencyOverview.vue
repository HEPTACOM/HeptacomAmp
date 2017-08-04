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
                            <f-a icon="cog"></f-a>
                            &nbsp;
                            Systemprüfung
                        </span>
                    </li>
                </ul>
            </li>
        </navigation>
        <table class="uk-table uk-table-striped uk-table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Erforderliche Version</th>
                    <th>Installierte Version</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dependency in dependencies">
                    <td>
                        <result-icon v-bind:success="dependency.valid"></result-icon>
                        &nbsp;
                        {{dependency.name}}
                    </td>
                    <td>
                        {{dependency.version.required}}
                    </td>
                    <td>
                        {{dependency.version.current}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script type="application/javascript">
    import KskAmpBackend from '../lib/KskAmpBackend.js';
    import FA from '../components/font-awesome.vue';
    import Navigation from '../components/navigation.vue';
    import ResultIcon from '../components/result-icon.vue';

    export default {
        components: {
            FA,
            Navigation,
            ResultIcon
        },
        data: () => ({
            dependencies: []
        }),
        created: function () {
            KskAmpBackend.dependencies.then(response => this.dependencies = response.data.data);
        }
    }
</script>