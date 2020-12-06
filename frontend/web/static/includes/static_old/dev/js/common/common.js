//Noty Message
$.fn.General_ShowNotification = function (options) {
    var defaults = {
        message: '',
        type: 'success',
        timeout: 2000
    };

    var opts = $.extend({}, defaults, options);

    $.noty.closeAll();  //close all before displaying

    if ($('#noty_topRight_layout_container').length > 0) {
        $('#noty_topRight_layout_container').remove();
    }

    var n = noty({
        type: opts.type,
        text: opts.message,
        layout: 'topRight',
        template: opts.template,
        timeout: opts.timeout,
        modal: opts.modal || false,
        dismissQueue: true,
        animation: {
            open: 'animated bounceInRight', // jQuery animate function property object
            close: 'animated bounceOutRight', // jQuery animate function property object
            easing: 'swing', // easing
            speed: 500 // opening & closing animation speed
        }
    });
};

//Show Error Message
$.fn.General_ShowErrorMessage = function (options) {
    var defaults = {
        message: '',
        type: 'error',
        timeout: 2000,
        title: 'Error',
        eventCallback: function () {
        }
    };

    var opts = $.extend({}, defaults, options);

    bootbox.alert({
        title: opts.title,
        message: opts.message,
        callback: function () {
            if (opts.eventCallback && typeof opts.eventCallback === 'function') {
                opts.eventCallback();
            }
        }
    });
};

$('.owl-carousel').owlCarousel({
	loop: true,
	items: 4,
	navigation: true,
	itemsDesktop: [1199, 3],
	itemsDesktopSmall: [979, 2],
	itemsTablet: [768, 2],
	itemsMobile: [479, 1]
});