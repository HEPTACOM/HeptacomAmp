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
        <div class="uk-padding-large">
            <cache-warmer header="Artikel" v-bind:items="articles" v-bind:loading="articlesLoading"></cache-warmer>
        </div>
    </div>
</template>

<script type="application/javascript">
    import KskAmpBackend from '../lib/KskAmpBackend.js';
    import FA from '../components/font-awesome.vue';
    import CategoryCacheWarmer from '../components/category-cache-warmer.vue';
    import CacheWarmer from '../components/cache-warmer.vue';
    import Navigation from '../components/navigation.vue';
    import Tree from '../components/tree.vue';

    export default {
        components: {
            CacheWarmer,
            CategoryCacheWarmer,
            FA,
            Navigation,
        },
        created: function() {
            KskAmpBackend.getArticles(p => this.articles.push(...p.data.data))
                .then(p => this.articlesLoading = false);
        },
        data: () => ({
            articles: [],
            articlesLoading: true
        })
    }
</script>