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
    import Navigation from '../components/navigation.vue';
    import ResultIcon from '../components/result-icon.vue';

    export default {
        components: {
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