/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var SliderController = (function ($) {
    return {
        createUpdate: function () {
            SliderController.CreateUpdate.init();
        }
    };
}(jQuery));

SliderController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        deleteSliderMedia();
        updateStatus();
        deleteSlider();
        uploadfiles();
        initJs();
        deleteMedia();
   };
    
    var initJs = function () {

        $(".dateDatepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    };
    
    var uploadfiles = function () {

        $('a.uploadFileBtn').uploadFile({
            cloudUpload: true,
            addRemoveLinks: false,
            acceptedFiles: allowedImageExtension,
            onSuccess: function (file, response) {
                if (response.success == "1") {
                    var media = response.media;

                    var template = Handlebars.compile(sliderItem);
                    var html = template({media: media.cdnPath, id: media.orig, unqid: media.unqid});

                    $('.mediaContainer').append('<input id="mediafile' + media.orig + '" name="SliderForm[media][]" type="hidden" value="' + media.orig + '">');
                    $('.sliderBlock').removeClass('hide');

                    $('#slider-carousel').data('owlCarousel').addItem(html);

                    $('#uploadImageModal').modal('hide');
                    toastr.success("Media had been added successfully.");
                    deleteSliderMedia();

                } else {
                    $().General_ShowErrorMessage({message: 'While save file in remote cdn error.'});
                }
            }
        });
    };

    var deleteSliderMedia = function (e) {
        
        $('.removeImage').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var id = elem.data('id');
            var unqid = elem.data('guid');
            if ((typeof id === undefined || id === "") || typeof unqid === undefined || unqid === "") {
                $().General_ShowErrorMessage({message: "Error: Invalid media file."});
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this media?",
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'button blue'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button grey'
                    }
                },
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'post',
                            url: baseHttpPath + '/upload-file/remove-media',
                            dataType: 'json',
                            data: {id: id, guid: unqid},
                            success: function (data, textStatus, jqXHR) {
                                if (data.success == "1") {
                                    $(elem).closest('div.owl-item').remove();
                                    var existingItems = $('#slider-carousel').find('div.item').length;
                                    if (existingItems <= 0) {
                                        var owlSlider = $("#slider-carousel").data('owlCarousel');
                                        owlSlider.reinit({
                                            loop: true,
                                            items: 4,
                                            navigation: true,
                                            itemsDesktop: [1199, 3],
                                            itemsDesktopSmall: [979, 2],
                                            itemsTablet: [768, 2],
                                            itemsMobile: [479, 1]
                                        });
                                    }
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-close');
                                $().General_ShowErrorMessage({message: jqXHR.responseText});
                            },
                            beforeSend: function (jqXHR, settings) {
                                elem.find('.fa').addClass('fa-spin fa-spinner').removeClass('fa-close');
                            },
                            complete: function (jqXHR, textStatus) {
                                elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-close');
                            }
                        });
                    }
                }
            });
        });
    };

    var deleteMedia = function (e) {
        $('.deleteMedia').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var elem = $(this);
            var id = elem.data('id');
            var unqid = elem.data('unqid');
            if ((typeof id === undefined || id === "") || typeof unqid === undefined || unqid === "") {
                $().General_ShowErrorMessage({message: "Error: Invalid media file."});
            }
            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this media?",
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'button blue'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button grey'
                    }
                },
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'post',
                            url: baseHttpPath + '/upload-file/remove-media',
                            dataType: 'json',
                            data: {id: id, unqid: unqid},
                            success: function (data, textStatus, jqXHR) {
                                if (data.success == "1") {
                                    $(elem).closest('.imageBlock').remove();
                                    toastr.success("Media has been removed successfully.");
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $().General_ShowErrorMessage({message: jqXHR.responseText});
                            },
                            beforeSend: function (jqXHR, settings) {
                                elem.find('.fa').addClass('fa-spin fa-spinner').removeClass('fa-close');
                            },
                            complete: function (jqXHR, textStatus) {
                                elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-close');
                            }
                        });
                    }
                }
            });
        });
    };

    var updateStatus = function (e) {
        $('.updateStatus').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var elem = $(this);
            var url = elem.data('url');
            var status = elem.data('status');
            if (typeof url === 'undefined' || url === '') {
                return;
            }

            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data.success == "1") {
                        elem.data('status', data.status);
                        var remClass = (status == '1') ? 'active' : 'inactive';
                        var className = ((data.status == '1') ? 'active' : 'inactive');
                        $(elem).attr("title", className);
                        $(elem).attr("data-original-title", className);
                        $(elem).addClass(className).removeClass(remClass);
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    elem.find('.fa').removeClass('fa-image').addClass('fa-spin fa-spinner');
                },
                complete: function (jqXHR, textStatus) {
                    elem.find('.fa').addClass('fa-image').removeClass('fa-spin fa-spinner');
                }
            });
        });
    };

    var deleteSlider = function () {
        $('.deleteSlider').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');

            if (typeof url === 'undefined' || url === '') {
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this record?",
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'button blue'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button grey'
                    }
                },
                callback: function (result) {
                    if (result === true) {
                        window.location = url;
                        return;
                    }
                }
            });
        });
    };

    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));

