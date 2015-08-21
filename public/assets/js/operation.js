
// The module pattern
var OperationModule = (function() {

    var moment = require('moment');

    // Handle datepicker initialization
    var initDatepicker = function (target) {
        target.datetimepicker({
            locale: $('#page-wrapper').data('locale'),
            format: 'L',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-crosshairs',
                clear: 'fa fa-trash',
                close: 'fa fa-times',
            },
        });
    };

    // Handle select type initialization
    var initSelectType = function (target) {
        target.change(function () {
            var row = $(this).closest('tr');

            var enabled = row.find('input, select:not([name="type"]), a');
            var disabled = row.find('input, select:not([name="type"]), a');

            if ($(this).val() === '') {
                enabled = $();
            } else if ($(this).val() === 'revenue') {
                enabled = enabled.not('select[name="envelope_id"]');
                disabled = disabled.filter('select[name="envelope_id"]');
            } else {
                disabled = $();
            }

            enabled.removeAttr('disabled').removeClass('disabled');
            disabled.attr('disabled', 'disabled').addClass('disabled');
        }).change();
    };

    // Handle submit links initialization
    var initSubmitLinks = function (target) {
        target.click(function () {
            var url = $(this).attr('href');
            var row = $(this).closest('tr');
            var data = row.find(':input').serializeArray();

            if ($(this).hasClass('btn-danger')) {
                var msg = $(this).attr('title') + ' ?';

                if (confirm(msg) === false) {
                    return false;
                }
            }

            target.fadeTo('fast', 0.5, function() {
                $.post(url, data, function(data, textStatus, jqXHR) {
                    submitFormSuccess();
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    RouterModule.submitFormFail(row, jqXHR, errorThrown);
                });
            });

            return false;
        });
    };

    // Handle form post success
    var submitFormSuccess = function (row) {
        RouterModule.refresh($('#account-operations-table, #envelope-operations-table'));

        NavbarModule.refresh();

        RouterModule.refresh($('#account-summary-balance, #envelope-summary-balance'));
        RouterModule.refresh($('#account-summary-events, #envelope-summary-events'));

        RouterModule.refresh($('#account-development-monthly, #envelope-development-monthly'));
        RouterModule.refresh($('#account-development-yearly, #envelope-development-yearly'));
    };

    // Handle row initialization
    var initRow = function (row) {
        initDatepicker(row.find('.datepicker'));
        initSelectType(row.find('select[name="type"]'));
        initSubmitLinks(row.find('a.btn:not(.routable)'));
    };

    // Called on module loading
    var init = function () {
    };



    // Define public methods
    return {
        init: init,
        initRow: initRow,
    };



})();
