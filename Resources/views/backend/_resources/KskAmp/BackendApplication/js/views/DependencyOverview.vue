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
                        <i class="fa fa-check-circle uk-text-success" v-if="dependency.valid"></i>
                        <i class="fa fa-exclamation-triangle uk-text-danger" v-if="!dependency.valid"></i>
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
    import Navigation from '../components/navigation.vue';

    export default {
        components: {
            Navigation
        },
        data: () => ({
            dependencies: []
        }),
        created: function () {
            KskAmpBackend.dependencies.then(response => this.dependencies = response.data.data);
        }
    }
</script>