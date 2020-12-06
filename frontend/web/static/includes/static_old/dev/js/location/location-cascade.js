(function($) {
    $.fn.CascadeLocation = function (options) {
        var defaults = {
            val: '',
            parent: '',
            onSuccess: function () {},
            onError: function () {},
            beforeSend: function () {},
            onComplete: function () {}
        };

        var opts = $.extend({}, defaults, options);
        
        $.ajax({
            url: baseHttpPath + '/location/cascade',
            type: "POST",
            data: {val: opts.val, _csrf: yii.getCsrfToken(), parent: opts.parent},
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if (opts.onSuccess && typeof opts.onSuccess === 'function') {
                    opts.onSuccess(data, textStatus, jqXHR);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (opts.onError && typeof opts.onError === 'function') {
                    opts.onError(jqXHR, textStatus, errorThrown);
                }
            },
            beforeSend: function (jqXHR, settings) {
                if (opts.beforeSend && typeof opts.beforeSend === 'function') {
                    opts.beforeSend(jqXHR, settings);
                }
            },
            complete: function (jqXHR, textStatus) {
                if (opts.onComplete && typeof opts.onComplete === 'function') {
                    opts.onComplete(jqXHR, textStatus);
                }
            }
        });
    };
}(jQuery));