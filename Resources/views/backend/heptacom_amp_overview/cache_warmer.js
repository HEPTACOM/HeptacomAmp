heptacom = {
    urls: {},

    setUrls: function(urls) {
        heptacom.urls = urls;
    },

    cacheWarmerArticleDetails: new Vue({
        el: '#cacheWarmerArticleDetails',
        data: {
            progressSuccessValue: 0,
            progressFailureValue: 0,
            progressMax: 0,
            fetchedAllData: false,
            processing: false,
            articleUrls: [],
            errors: []
        },
        computed: {
            percentSuccessComplete : function() {
                return Math.ceil(this.progressSuccessValue / this.progressMax * 100);
            },
            percentFailureComplete : function() {
                return Math.ceil(this.progressFailureValue / this.progressMax * 100);
            }
        },
        methods: {
            btnWarmup: function(event) {
                var that = this;
                that.errors.splice(0);
                that.progressSuccessValue = 0;
                that.progressFailureValue = 0;
                var fetcher = function() {
                    var item = that.articleUrls.pop();
                    if (Boolean(item)) {
                        that.processing = true;
                        heptacom.getRequest(item.amp_url).done(function() {
                            ++that.progressSuccessValue;
                        }).fail(function() {
                            that.errors.push(item);
                            ++that.progressFailureValue;
                        }).always(function() {
                            setTimeout(fetcher, 50);
                        });
                    } else {
                        that.processing = false;
                    }
                };

                fetcher();
            }
        }
    }),

    warmup: function() {
        heptacom.cacheWarmerArticleDetails.fetchedAllData = false;
        heptacom.cacheWarmerArticleDetails.articleUrls.splice(0);

        var fetcher = function(id) {
            heptacom.overviewGetArticleIds(id, 20).success(function(data) {
                data.data.forEach(function (item) {
                    heptacom.cacheWarmerArticleDetails.articleUrls.push(item);
                });

                heptacom.cacheWarmerArticleDetails.progressMax += data.data.length;

                if (data.data.length == 20) {
                    setTimeout(function () {
                        fetcher(id + 20);
                    }, 100);
                } else {
                    heptacom.cacheWarmerArticleDetails.fetchedAllData = true;
                }
            });
        };

        fetcher(0);
    },

    getRequest: function (url) {
        return $.ajax({
            type: 'get',
            url: url
        });
    },

    overviewGetArticleIds: function(skip, take) {
        return $.ajax({
            type: 'get',
            url: heptacom.urls.getArticleIds,
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: {
                skip: skip,
                take: take
            }
        })
    }
};