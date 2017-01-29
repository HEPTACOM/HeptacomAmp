heptacom = {
    /**
     * The validation result template.
     */
    validationResultTemplate: Handlebars.compile($("#validationResult").html()),

    /**
     * Reacts on the validation button click
     * @param event
     */
    btnValidateRow: function(event) {
        var row = $(event.target).parents('tr')[0];
        heptacom.validate($(row).data('ampurl'), function (result)
        {
            if (result.status == 'FAIL') {
                $(row).find('.label-danger').text(result.errors.length).removeClass('hidden');
            } else {
                $(row).find('.label-danger').removeClass('hidden');
            }

            var lastCell = $(row).find('.collapsed');
            lastCell.append(heptacom.validationResultTemplate(result));
            lastCell.collapse('show');
        });
    },

    /**
     * Validates an url.
     * @param url The url to validate.
     * @param receive The action it executes if the result came in.
     */
    validate: function(url, receive) {
        $.get(url, [], function(data) { receive(amp.validator.validateString(data)); });
    }
};