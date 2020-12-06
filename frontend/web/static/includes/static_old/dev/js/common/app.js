(function ($) {
    $.fn.confirmMessage = function (options) {
        var defaults = {
            message: 'Are you sure to delete this record?',
            title: 'Confirm',
        };
        var opts = $.extend({}, defaults, options);
        return this.each(function () {
            var elem = $(this);
            $(elem).on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var url = $(this).attr('href');
                if (typeof url === "undefined" || url === "") {
                    return;
                }
                bootbox.confirm({
                    title: opts.title,
                    message: opts.message,
                    className: "modal__wrapper",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'button small blue'
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'button small grey'
                        }
                    },
                    callback: function (result) {
                        if (result === true) {
                            window.location = url;
                        }
                    }
                });
            });
        });

    };
    $.fn.General_ShowNotification = function (options) {
        var defaults = {
            message: '',
            type: 'success',
            timeout: 4000
        };

        var opts = $.extend({}, defaults, options);

        if ($('#noty_topRight_layout_container').length > 0) {
            $('#noty_topRight_layout_container').remove();
        }

        var n = noty({
            type: opts.type,
            text: opts.message,
            layout: 'top',
            dismissQueue: true,
            template: opts.template,
            timeout: opts.timeout,
            closeWith: ['click'],
            theme: 'relax',
            modal: opts.modal || false,
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
    $.fn.bindNiceScroll = function (options) {
        if ($(window).width() > 992) {
            var defaults = {};
            var opts = $.extend({}, defaults, options);
            $(".table__structure-scrollable .scrolling").getNiceScroll().remove();
            $(".table__structure-scrollable .scrolling").niceScroll({
                cursorwidth: '8px',
                zindex: 999,
                cursorcolor: "#aaa",
                preventmultitouchscrolling: false,
                autohidemode: false
            });
        }
    };
    
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    
    

    // main navigation toggle activate
    if ($(window).width() < 992) {
        $(".page__navigation .dropdown-toggle, .responsive-standalone .dropdown-toggle").attr("data-toggle", "dropdown");
    }
    // nice scroll for table scrolling
    if ($(window).width() > 992) {
        $(".table__structure-scrollable .scrolling, .scrollingEvent, .category__list ul").niceScroll({
            cursorwidth: '8px',
            zindex: 999,
            cursorcolor: "#aaa",
            cursoropacitymin: 0.6,
            cursorborder: 'none',
            preventmultitouchscrolling: false,
            autohidemode: 'leave'
        });
    }
    ;
//    $('.section-head__optionSets--filter').on('click', function () {
//        $(this).parents('.table__structure__head').find('.filters-wrapper').slideToggle();
//    });

    // single search toggle
    var singleSearch = $(".search__single");
    singleSearch.on('click', function () {
        if (singleSearch.hasClass('search__close')) {
            $(this).removeClass('search__close').find('i').addClass('fa-search').removeClass('fa-close');
            $('.search__single-bar').hide();
        } else {
            $(this).addClass('search__close').find('i').removeClass('fa-search').addClass('fa-close');
            $('.search__single-bar').show();
        }
    });
   
    
    
      $(".selectdatePicker").datepicker({
        format: 'dd-mm-yyyy'
    });
    
    $('.deleteRecord').confirmMessage();
    
       // Nice scrolling issue fixed.
    $('.section-head__optionSets--filter').on('click', function () {
        $(".table__structure-scrollable .scrolling").getNiceScroll().hide();
        $(this).parents('.table__structure__head').find('.filters-wrapper').slideToggle();
        setTimeout(function () {
            $(".table__structure-scrollable .scrolling").getNiceScroll().resize().show();
        }, 500);
    });
    
    $(".datePicker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    
    
    $('.logoutBtn').on('click', function (e) {
        e.preventDefault();
        var elem = $(this);
        bootbox.confirm({
            title: "Logout",
            message: 'Do you want to logout your account?',
            className: "modal__wrapper",
            buttons: {
                confirm: {
                    label: 'Logout',
                    className: 'button blue small'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'button grey small'
                }
            },
            callback: function (result) {
                if (result == true) {
                    window.location = $(elem).attr('href');
                }
            }
        });
    });
  
}(jQuery));