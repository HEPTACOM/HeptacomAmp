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
                            <i class="fa fa-tachometer"></i>
                            &nbsp;
                            Cache erzeugen
                        </span>
                    </li>
                </ul>
            </li>
        </navigation>
        <tree nameProperty="name" childrenProperty="categories" v-bind:data="categories"></tree>
    </div>
</template>

<script type="application/javascript">
    import KskAmpBackend from '../lib/KskAmpBackend.js';
    import Navigation from '../components/navigation.vue';
    import Tree from '../components/tree.vue';

    export default {
        components: {
            Navigation,
            Tree
        },
        created: function() {
            KskAmpBackend.categories.then(p => this.categories = p.data.data);
        },
        data: () => ({
            categories: []
        })
    }
</script>