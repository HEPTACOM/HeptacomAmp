Vue.component('cache-warmer', {
    template: '<div class="caption">' +
    '<h3><slot name="caption"></slot>&nbsp;<span class="badge">{{urls.length}}<i v-show="fetching" class="fa fa-spinner fa-pulse" style="margin-left:10px"></i></span></h3>' +
    '<div v-show="progressVisible"><div class="progress">' +
    '<div class="progress-bar progress-bar-striped progress-bar-danger active" :style="{ width: percentFailureComplete + \'%\' }"></div>' +
    '<div class="progress-bar progress-bar-striped progress-bar-success active" :style="{ width: percentSuccessComplete + \'%\' }"></div>' +
    '</div></div>' +
    '<p class="text-center"><button class="btn btn-success" :disabled="fetching || processing" @click="btnWarmup($event)"><slot name="button"></slot></button></p>' +
    '<div v-show="errors.length > 0" class="panel panel-default">' +
    '<div class="panel-heading"><slot name="error"></slot>&nbsp;<span class="badge">{{errors.length}}</span></div>' +
    '<div class="panel-body"><div class="table table-condensed"><div v-for="page in errors" class="row">' +
    '<div class="col-xs-10">{{page.name}}</div>' +
    '<div class="col-xs-2 text-right"><div class="btn-group">' +
    '<a v-for="(url, urlKey) in page.urls" class="btn btn-link" :href="url" target="_blank"><i :class="[\'fa\', \'fa-\' + urlKey]"></i></a>' +
    '</div></div></div></div></div>' +
    '</div>',
    data: function() {
        return {
            urls: [],
            errors: [],
            successValue: 0,
            processing: false,
            fetching: false
        }
    },
    props: {
        fetchUrl: {
            type: String,
            required: true
        }
    },
    computed: {
        percentSuccessComplete: function() {
            return Math.ceil(this.successValue / this.urls.length * 100);
        },
        percentFailureComplete: function() {
            return Math.floor(this.errors.length / this.urls.length * 100);
        },
        progressVisible: function () {
            return (this.urls.length > 0 && (this.urls.length == this.successValue + this.errors.length)) || this.processing;
        }
    },
    mounted: function() {
        var that = this;
        var fetcher = function(id) {
            that.fetching = true;
            heptacom.fetchPaged(that.fetchUrl, id, 20).success(function(response) {
                response.data.forEach(function (item) {
                    that.urls.push(item);
                });

                if (response.count == 20) {
                    setTimeout(function () {
                        fetcher(id + 20);
                    }, 100);
                } else {
                    that.fetching = false;
                }
            });
        };

        fetcher(0);
    },
    methods: {
        btnWarmup: function(event) {
            var that = this;
            that.errors.splice(0);
            that.successValue = 0;
            var todo = that.urls.slice(0);
            var fetcher = function() {
                var item = todo.pop();
                if (Boolean(item)) {
                    that.processing = true;
                    heptacom.getRequest(item.test_url).done(function() {
                        ++that.successValue;
                    }).fail(function() {
                        that.errors.push(item);
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
});

heptacom = {
    getRequest: function (url) {
        return $.ajax({
            type: 'get',
            url: url
        });
    },

    fetchPaged: function(url, skip, take) {
        return $.ajax({
            type: 'get',
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: {
                skip: skip,
                take: take
            }
        });
    }
};

new Vue({
    el: '.container'
});