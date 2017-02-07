heptacom = {
    url: {},

    validationArticles: new Vue({
        el: '#heptacomArticles',
        data: {
            fetchingData: false,
            fetchedData: false,
            processingData: false,
            articles: []
        },
        methods: {
            fetched: function(articles) {
                return articles.filter(function (article) {
                    return article.status === 'fetched';
                })
            },
            validating: function(articles) {
                return articles.filter(function (article) {
                    return article.status === 'validating';
                })
            },
            valid: function(articles) {
                return articles.filter(function (article) {
                    return article.status === 'valid';
                })
            },
            error: function(articles) {
                return articles.filter(function (article) {
                    return article.status === 'error';
                })
            }
        }
    }),

    setUrls: function(urls) {
        heptacom.url = urls;
    },

    btnLoadArticles: function(event) {
        heptacom.validationArticles.fetchingData = true;
        heptacom.validationArticles.articles.splice(0);

        var fetcher = function(id) {
            heptacom.overviewGetArticleIds(id, 20).success(function(data) {
                data.data.forEach(function (item) {
                    item.errors = [];
                    item.status = 'fetched';
                    heptacom.validationArticles.articles.push(item);
                });

                if (data.data.length == 20) {
                    setTimeout(function () {
                        fetcher(id + 20);
                    }, 100);
                } else {
                    heptacom.validationArticles.fetchingData = false;
                }
            }).done(function () {
                heptacom.validationArticles.fetchedData = true;
            });
        };

        fetcher(0);
    },

    btnValidateArticles: function(event) {
        heptacom.validationArticles.processingData = true;

        var validIterator = function(id) {
            heptacom.validationArticles.articles[id].status = 'validating';
            var request = heptacom.validate(
                heptacom.validationArticles.articles[id].amp_url,
                function () {
                    heptacom.validationArticles.articles[id].status = 'valid';
                },
                function (data) {
                    heptacom.validationArticles.articles[id].status = 'error';
                    heptacom.validationArticles.articles[id].errors.splice(0);

                    data.errors.forEach(function (item) {
                        heptacom.validationArticles.articles[id].errors.push(item);
                    })
                }
            ).fail(function(request, textStatus, errorThrown) {
                heptacom.validationArticles.articles[id].status = 'error';
                heptacom.validationArticles.articles[id].errors.push({
                    type: 'HTTP',
                    params: [ request.status ]
                });
            }).done(function(){
                var validatingCount = heptacom.validationArticles.articles.filter(function (item) {
                    return item.status == 'validating';
                }).length;

                if (validatingCount == 0) {
                    heptacom.validationArticles.processingData = false
                }
            });

            if (id + 1 < heptacom.validationArticles.articles.length) {
                setTimeout(function () { validIterator(id + 1); }, 1000);
            }
        };

        validIterator(0);
    },

    validate: function(url, success, error) {
        return $.ajax({
            type: 'get',
            url: url,
            success: function(data) {
                var validationResult = amp.validator.validateString(data);
                (validationResult.status == 'PASS' ? success : error)(validationResult);
            }
        });
    },

    googleAmpCache: function(url) {
        if (url.indexOf('https://') === 0) {
            url = 'https://cdn.ampproject.org/c/s/' + url.substring(8);
        } else if (url.indexOf('http://') === 0) {
            url = 'https://cdn.ampproject.org/c/' + url.substring(7);
        }

        return $.ajax({
            type: 'get',
            url: url
        });
    },

    overviewGetArticleIds: function(skip, take) {
        return $.ajax({
            type: 'get',
            url: heptacom.url.getArticleIds,
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: {
                skip: skip,
                take: take
            }
        });
    }
};