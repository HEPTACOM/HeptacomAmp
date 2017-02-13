Vue.component('validator', {
    template: '<div class="caption">' +
    '<h3><slot name="caption"></slot>&nbsp;<span class="badge"><span v-show="processing">{{errors.length + successValue}}&nbsp;/&nbsp;</span>{{urls.length}}<i v-show="fetching" class="fa fa-spinner fa-pulse" style="margin-left:10px"></i></span></h3>' +
    '<div v-show="progressVisible"><div class="progress">' +
    '<div class="progress-bar progress-bar-striped progress-bar-danger" :class="{active: processing}" :style="{ width: percentFailureComplete + \'%\' }"></div>' +
    '<div class="progress-bar progress-bar-striped progress-bar-success" :class="{active: processing}" :style="{ width: percentSuccessComplete + \'%\' }"></div>' +
    '</div></div>' +
    '<p class="text-center"><button class="btn btn-success" :disabled="fetching || processing" @click="btnValidate($event)"><slot name="button"></slot></button></p>' +
    '<div v-show="errors.length > 0" class="panel panel-default">' +
    '<div class="panel-heading"><slot name="error"></slot>&nbsp;<span class="badge">{{errors.length}}</span></div>' +
    '<div class="panel-body"><div class="table table-condensed"><div v-for="page in errors" class="row">' +
    '<div class="col-xs-8 col-md-10">{{page.name}}&nbsp;<span class="badge">{{page.messages.length}}</span></div>' +
    '<div class="col-xs-4 col-md-2 text-right"><div class="btn-group">' +
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
                    item.urls.bolt = 'https://validator.ampproject.org/#url='+encodeURIComponent(item.test_url);
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
        btnValidate: function(event) {
            var that = this;
            that.errors.splice(0);
            that.successValue = 0;
            var todo = that.urls.slice(0);
            var fetcher = function() {
                var item = todo.pop();
                if (Boolean(item)) {
                    that.processing = true;
                    heptacom.validate(
                        item.test_url,
                        function () {
                            ++that.successValue;
                        },
                        function (data) {
                            item.messages = data.errors.slice(0);
                            that.errors.push(item);
                    }).fail(function(request, textStatus, errorThrown) {
                        item.messages = [
                            {
                                type: 'HTTP',
                                params: [
                                    request.status
                                ]
                            }
                        ];
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
    }
};

new Vue({
    el: '.container'
});
