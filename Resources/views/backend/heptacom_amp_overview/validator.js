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
    }
};