(function ($) {
    
    //Show Error Message
    $.fn.ShowFlashMessages = function (options) {
        var defaults = {
            message: '',
            type: 'error',
        };

        var opts = $.extend({}, defaults, options);
        var obj =  $('.page-main-content > .container > .content-wrap');
        if (opts.type === 'error') {
            obj.prepend('<div class="alert alert-danger alert-dismissible fade in" role="alert">\n\
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">\n\
            <span aria-hidden="true">×</span></button><p>' + opts.message + '</p></div>');
        } else {

            obj.prepend('<div class="alert alert-success alert-dismissible fade in" role="alert">\n\
            <button class="close" aria-label="Close" data-dismiss="alert" type="button">\n\
            <span aria-hidden="true">×</span></button><p>' + opts.message + '</p></div>');
        }
    };
    
    $.fn.hideScreenLoader = function (options) {
        var defaults = {};
        var opts = $.extend({}, defaults, options);
        $('#globalLoader').hide();
    };
    
    $.fn.showScreenLoader = function (options) {
        var defaults = {};
        var opts = $.extend({}, defaults, options);
        $('#globalLoader').show();
    };
   
}(jQuery));