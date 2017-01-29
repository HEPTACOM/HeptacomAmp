heptacom = {
    btnValidateArticleDetails: function(event) {

    },

    validate: function(url, success, error) {
        return $.get({
            url: url,
            success: function(data) {
                (data.status == 'PASS' ? success : error)(amp.validator.validateString(data))
            }
        });
    },

    googleAmpCache: function(url) {
        if (url.indexOf('https://') === 0) {
            url = 'https://cdn.ampproject.org/c/s/' + url.substring(8);
        } else if (url.indexOf('http://')) {
            url = 'https://cdn.ampproject.org/c/' + url.substring(7);
        }

        return $.get({url: url});
    }
};