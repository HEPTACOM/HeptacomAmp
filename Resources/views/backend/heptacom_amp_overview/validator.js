heptacom = {
    url: {},

    validationArticles: new Vue({
        el: '#heptacomArticles',
        data: {
            fetchingData: false,
            fetchedData: false,
            articles: []
        },
        methods: {
            fetched: function(articles) {
                return articles.filter(function (article) {
                    return article.status === 'fetched';
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
            heptacom.overviewGetArticleIds(id, 50).success(function(data) {
                data.data.forEach(function (item) {
                    item.validated = false;
                    item.errors = [];
                    item.status = 'fetched';
                    heptacom.validationArticles.articles.push(item);
                });
                heptacom.validationArticles.fetchedData = true;

                if (data.data.length == 50) {
                    setTimeout(function () {
                        fetcher(id + 50);
                    }, 100);
                } else {
                    heptacom.validationArticles.fetchingData = false;
                }
            })
        };

        fetcher(0);
    },

    validate: function(url, success, error) {
        return $.ajax({
            type: 'post',
            url: url,
            success: function(data) {
                (data.status == 'PASS' ? success : error)(amp.validator.validateString(data))
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