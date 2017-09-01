var createCategory = function() {
    var t = {};
    t.errors = [];
    t.success = 0;
    t.articles = [];
    t.working = false;
    return t;
};

Vue.component('shop-list', {
    template: '<div class="caption">' +
    '<h2><slot name="caption"></slot></h2>' +
        '<div v-for="shop in shops">' +
            '<h3>{{shop.name}}</h3>' +
            '<category-list :categories-url="categoriesUrl" :articles-url="articlesUrl" :shop="shop" @fetchComplete="shopFetchComplete">' +
                '<template slot="button"><slot name="button"></slot></template>' +
                '<template slot="error"><slot name="error"></slot></template>' +
            '</category-list>' +
        '</div>' +
    '</div>',
    data: function() {
        return {
            shops: [],
            fetching: false,
            fetchingComponents: []
        }
    },
    props: {
        shopsUrl: {
            type: String,
            required: true
        },
        categoriesUrl: {
            type: String,
            required: true
        },
        articlesUrl: {
            type: String,
            required: true
        }
    },
    mounted: function() {
        this.fetchData();
    },
    methods: {
        fetchData: function() {
            var that = this;
            that.fetching = true;
            heptacom.fetch(that.shopsUrl, {}).done(function (response) {
                response.data.forEach(function (shop) {
                    that.shops.push(shop);
                    that.fetchingComponents.push(shop.id);
                });
                that.fetching = false;
            });
        },
        shopFetchComplete: function (shopId) {
            var index = this.fetchingComponents.indexOf(shopId);
            this.fetchingComponents.splice(index, 1);
        }
    }
});

Vue.component('category-list', {
    template: '<div>' +
        '<p class="text-center"><button class="btn btn-success" :disabled="fetching || fetchingComponents.length > 0 || working" @click="btnWarmupAll($event)"><slot name="button"></slot></button></p>' +
        '<progressbar :success="successes" :failure="errors.length" :maximum="maximum" :visible="working"></progressbar>' +
        '<category v-for="category in categories" :category="category" :shop="shop" :articles-url="articlesUrl" @fetchComplete="categoryFetchComplete"></category>' +
        '<error-list :errors="errors">' +
            '<template slot="error"><slot name="error"></slot></template>' +
        '</error-list>' +
    '</div>',
    data: function() {
        return {
            categories: [],
            fetching: false,
            fetchingComponents: [],
            successes: 0,
            errors: [],
            maximum: 0,
            working: false
        }
    },
    mounted: function() {
        this.fetchData();
    },
    props: {
        shop: {
            type: Object,
            required: true
        },
        categoriesUrl: {
            type: String,
            required: true
        },
        articlesUrl: {
            type: String,
            required: true
        }
    },
    methods: {
        fetchData: function () {
            var that = this;
            that.fetching = true;
            heptacom.fetch(that.categoriesUrl, { shop: that.shop.id }).done(function (response) {
                response.data.forEach(function (category) {
                    that.fetchingComponents.push(category.id);
                    category.data = createCategory();
                    that.categories.push(category);
                });
                that.fetching = false;
            });
        },
        categoryFetchComplete: function (shopId) {
            var index = this.fetchingComponents.indexOf(shopId);
            this.fetchingComponents.splice(index, 1);

            if (this.fetchingComponents.length == 0 && !this.fetching) {
                this.$emit('fetchComplete', this.shop.id);
            }
        },
        btnWarmupAll: function (event) {
            var that = this;

            that.successes = 0;
            that.errors.splice(0);
            that.maximum = that.categories.reduce(function (acc, val) { return val.data.articles.length + acc; }, 0);
            that.working = true;

            that.categories.forEach(function (category) {
                category.data.success = 0;
                category.data.errors.splice(0);
                category.data.working = false;
            });

            var fetcher = function (categoryId, articleId) {
                if (categoryId < that.categories.length) {
                    if (articleId < that.categories[categoryId].data.articles.length) {
                        that.categories[categoryId].data.working = true;
                        var article = that.categories[categoryId].data.articles[articleId];
                        heptacom.getRequest(article.test_url).done(function() {
                            heptacom.sendUpdatePing(article.test_url);
                            ++that.successes;
                            ++that.categories[categoryId].data.success;
                        }).fail(function() {
                            that.categories[categoryId].data.errors.push(article);
                            that.errors.push(article);
                        }).always(function() {
                            setTimeout(function () { fetcher(categoryId, articleId + 1); }, 10);
                        });
                    } else {
                        fetcher(categoryId + 1, 0);
                    }
                } else {
                    that.working = false;
                }
            };
            fetcher(0, 0);
        }
    }
});

Vue.component('category', {
    template: '<div class="row">' +
        '<div class="col-xs-4 text-ellipse">{{category.name}}</div>' +
            '<div class="col-xs-2 text-center">' +
                '<badge :value="category.data.errors.length + category.data.success" :maximum="category.data.articles.length" :spinning="fetching" :counting="category.data.working"></badge>' +
            '</div>' +
            '<div class="col-xs-6">' +
                '<progressbar :success="category.data.success" :failure="category.data.errors.length" :maximum="category.data.articles.length" :visible="true"></progressbar>' +
            '</div>' +
        '</div>' +
    '</div>',
    data: function () {
        return {
            visible: false,
            fetching: false
        };
    },
    props: {
        category: {
            type: Object,
            required: true
        },
        shop: {
            type: Object,
            required: true
        },
        articlesUrl: {
            type: String,
            required: true
        }
    },
    mounted: function () {
        this.fetchData();
    },
    methods: {
        fetchData: function () {
            var that = this;
            that.fetching = true;
            heptacom.fetch(that.articlesUrl, { category: that.category.id, shop: that.shop.id }).done(function (response) {
                response.data.forEach(function (article) {
                    that.category.data.articles.push(article);
                });
                that.fetching = false;
                that.$emit('fetchComplete', that.category.id);
            });
        }
    }
});

Vue.component('progressbar', {
    template: '<div v-show="visible" class="progress">' +
        '<div class="progress-bar progress-bar-danger" :class="{active: !finished, \'progress-bar-striped\': !finished }" :style="{ width: percentFailureComplete + \'%\' }"></div>' +
        '<div class="progress-bar progress-bar-success" :class="{active: !finished, \'progress-bar-striped\': !finished}" :style="{ width: percentSuccessComplete + \'%\' }"></div>' +
    '</div>',
    props: {
        success: {
            type: Number,
            required: true
        },
        failure: {
            type: Number,
            required: true
        },
        maximum: {
            type: Number,
            required: true
        },
        visible: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        percentSuccessComplete: function() {
            return Math.ceil(this.success / this.maximum * 100);
        },
        percentFailureComplete: function() {
            return Math.floor(this.failure / this.maximum * 100);
        },
        finished: function() {
            return this.maximum <= this.success + this.failure;
        }
    }
});

Vue.component('badge', {
    template: '&nbsp;<span class="badge">' +
        '<span v-show="counting || value != 0">{{value}}&nbsp;/&nbsp;</span>{{maximum}}' +
        '<i v-show="spinning" class="fa fa-spinner fa-pulse" style="margin-left:10px"></i>' +
    '</span>',
    props: {
        value: {
            type: Number,
            required: true
        },
        maximum: {
            type: Number,
            required: true
        },
        counting: {
            type: Boolean,
            required: true
        },
        spinning: {
            type: Boolean,
            required: true
        }
    }
});

Vue.component('error-list', {
    template: '<div v-show="errors.length > 0" class="panel panel-default">' +
        '<div class="panel-heading">' +
            '<slot name="error"></slot>' +
            '<badge :value="0" :maximum="errors.length" :counting="false" :spinning="false"></badge>' +
        '</div>' +
        '<div class="panel-body">' +
            '<div class="table table-condensed">' +
                '<div v-for="page in errors" class="row">' +
                    '<div class="col-xs-8 col-md-10">{{page.name}}</div>' +
                    '<div class="col-xs-4 col-md-2 text-right">' +
                        '<div class="btn-group">' +
                            '<a v-for="(url, urlKey) in page.urls" class="btn btn-link" :href="url" target="_blank"><i :class="[\'fa\', \'fa-\' + urlKey]"></i></a>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
    '</div>',
    props: {
        errors: {
            type: Array,
            required: true
        }
    }
});

heptacom = {
    getRequest: function (url) {
        return $.ajax({
            type: 'get',
            url: url
        });
    },

    fetch: function(url, data) {
        return $.ajax({
            type: 'get',
            url: url,
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: 'json'
        });
    },

    fetchArticle: function(url, shop, category) {
        return $.ajax({
            type: 'get',
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: {
                shop: shop,
                category: category
            }
        });
    },

    sendUpdatePing: function (url) {
        var ampUrl = url.split('://').pop();
        var cacheUrl = 'https://cdn.ampproject.org/update-ping/c/s/' + ampUrl;

        heptacom.getRequest(cacheUrl);
    }
};

new Vue({
    el: '.container'
});
