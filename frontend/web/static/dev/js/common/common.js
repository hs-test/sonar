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
            speed: 1000 // opening & closing animation speed
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
            eventCallback: function () {}
        };

        var opts = $.extend({}, defaults, options);

        bootbox.alert({
            title: opts.title,
            message: opts.message,
            className: "modal__wrapper",
            buttons: {
                ok: {
                    label: 'Ok',
                    className: 'button blue small'
                }
            },
            callback: function () {
                if (opts.eventCallback && typeof opts.eventCallback === 'function') {
                    opts.eventCallback();
                }
            }
        });
    };
    
$.fn.ShowFileName = function () {
    $("#importform-file").change(function () {
       
        var fullPath = document.getElementById('importform-file').value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
           
            $(".file-name").val(filename);

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
         
 
   