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
                            <f-a icon="tachometer"></f-a>
                            &nbsp;
                            Cache erzeugen
                        </span>
                    </li>
                </ul>
            </li>
        </navigation>
        <dock>
            <tree nameProperty="name" childrenProperty="categories" v-bind:data="categories" slot="left" v-on:click-item="selectCategory"></tree>
            <category-cache-warmer v-bind:category="selectedCategory" v-if="selectedCategory"></category-cache-warmer>
        </dock>
    </div>
</template>

<script type="application/javascript">
    import KskAmpBackend from '../lib/KskAmpBackend.js';
    import FA from '../components/font-awesome.vue';
    import CategoryCacheWarmer from '../components/category-cache-warmer.vue';
    import Dock from '../components/dock.vue';
    import Navigation from '../components/navigation.vue';
    import Tree from '../components/tree.vue';

    export default {
        components: {
            CategoryCacheWarmer,
            Dock,
            FA,
            Navigation,
            Tree
        },
        created: function() {
            KskAmpBackend.categories.then(p => this.categories = p.data.data);
        },
        data: () => ({
            categories: [],
            selectedCategory: null
        }),
        methods: {
            selectCategory(item) {
                this.selectedCategory = item;
            }
        }
    }
</script>