/* global FormatModule */
/* global NavbarModule */

/* exported RouterModule */

// The module pattern
var RouterModule = (function() {



    // Check if fragment ecists
    var hasFragment = function () {
        return window.location.hash !== '';
    };

    // Set url to fragment
    var setFragment = function (url) {
        var baseUrl = $('#page-wrapper').data('base-url');
        var fragment = url.replace(baseUrl, '');

        window.location.hash = fragment;
    };

    // Get url from fragment and baseurl
    var getFragment = function () {
        var baseUrl = $('#page-wrapper').data('base-url');
        var fragment = window.location.hash.substring(1);

        return baseUrl + fragment;
    };



    // Get data from url and load it to target
    var load = function (url, target, callback) {
        console.log('Load ' + url + ' to ' + target.selector);

        target.fadeTo('fast', 0.5, function() {
            target.load(url, null, function () {
                target.fadeTo('fast', 1);
                if (target.attr('id') === 'page-wrapper') {
                    setFragment(url);
                    NavbarModule.activateLinks();
                }
                if (typeof callback === "function") {
                    callback();
                }
            });

            target.data('url', url);
        });
    };

    // Refresh target content from url set as data attribute
    var refresh = function (target, callback) {
        var url = target.data('url');
        load(url, target, callback);
    };



    // Hangle click with GET Ajax call
    var clickLink = function (link, callback) {
        var url = link.attr('href');

        var target;
        if (link.hasClass('routable')) {
            target = link.data('target');
        } else {
            target = link.closest('.routable').data('target');
        }

        load(url, $(target), callback);
    };


    // Submit form with POST Ajax call
    var submitForm = function (form) {
        var url = form.attr('action');
        var target = $(form.data('target'));
        var data = form.find(':input').serializeArray();

        console.log('Submit form to ' + url);
        target.fadeTo('fast', 0.5, function() {
            $.post(url, data, function(data) {
                target.html(data);
                target.fadeTo('fast', 1);
                target.data('url', url);

                if (target.attr('id') === 'page-wrapper') {
                    NavbarModule.activateLinks();
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                submitFormFail(form, jqXHR, errorThrown);
            }).always(function () {
                target.fadeTo('fast', 1);
            });
        });
    };

    // Handle form post failure
    var submitFormFail = function(form, jqXHR, errorThrown) {
        console.log(jqXHR);
        form.find('.form-group.has-error .help-block.text-right').remove();
        form.find('.form-group').removeClass('.has-error');

        if (jqXHR.status === 422) {
            invalidForm(form, jqXHR.responseJSON);
            return;
        }

        var alert = FormatModule.alert(errorThrown, 'danger');
        form.find('.messagebox').html(alert);
    };

    // Add error messages to failed form inputs
    var invalidForm = function (form, errors) {
        $.each(errors, function(field, messages) {
            var formGroup = form.find('[name="' + field + '"]').closest('.form-group');

            var message = '';
            for (var i = 0; i < messages.length; ++i) {
                message += '<li>' + messages[i] + '</li>';
            }

            formGroup.addClass('has-error');
            formGroup.append('<ul class="help-block text-right">' + message + '</ul>');
        });
    };



    // Called on module loading
    var init = function () {
        // Use route from fragment if provided
        if (hasFragment()) {
            console.log('=> ' + getFragment());
            $('#page-wrapper').data('url', getFragment());
        }

        // Click routable links should reload element asynchronously
        $('body').on('click', '.routable a, a.routable', function () {
            clickLink($(this));
            return false;
        });

        // Submitting routable forms should submit data asynchronously
        $('body').on('submit', 'form.routable', function () {
            submitForm($(this));
            return false;
        });

        // Support link to tab outside of nav-tabs
        $('body').on('click', 'a.link-to-tab', function () {
            var url = $(this).attr('href');
            $('.nav-tabs a[href="'+url+'"]').click();
            return false;
        });

        // Redraw chart in tabs on tab show
        $('body').on('shown.bs.tab', 'ul.nav-tabs a', function (e) {
            $(e.target.hash).find('div[id$="-chart"]').each(function() {
                $(this).get(0).chart.resizeHandler();
            });
        });
    };



    // Define public methods
    return {
        init: init,
        refresh: refresh,
        clickLink: clickLink,
        submitForm: submitForm,
        submitFormFail: submitFormFail,
        load: load,
    };



})();
