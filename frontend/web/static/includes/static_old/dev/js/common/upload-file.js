(function ($) {
    $.fn.ShowHideAjaxLoadingToImageModal = function (options) {
        $('#ModalCoverImage .modal-body').General_AddRemoveAjaxLoader(options);
    };
    
    $.fn.uploadFile = function (options) {
        var defaults = {
            maxFilesize: 1,
            uploadMultiple: false,
            addRemoveLinks : true,
            acceptedFiles : "image/*",
            onSuccess: function () {},
            onError: function () {},
            beforeSend: function () {},
            beforeAdded: function () {},
            onComplete: function () {}
        };

        var opts = $.extend({}, defaults, options);
        var $modal = $('#uploadImageModal');
        Dropzone.autoDiscover = false;
        return this.each(function () {
            var elem = $(this);
            $(elem).on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                
                $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
                        '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
                            '<div class="loader">' +
                                '<span><img width="24" height="24" src="' + staticPath + '/dist/images/loading.svg"></span>' +
                                '<span class="text">please wait...</span>' +
                            '</div>' +
                        '</div>';
                
                $('body').modalmanager('loading');
                setTimeout(function () {
                    $modal.load(baseHttpPath + '/upload-file/upload-modal', function (responseText, textStatus, jqXHR) {
                        $modal.modal();
                    });
                }, 500);

                $('#uploadImageModal').on('shown.bs.modal', function (e) {
                    new Dropzone("#upload-dropzone-file", {
                        paramName: "file",
                        addRemoveLinks: opts.addRemoveLinks,
                        maxFilesize: opts.maxFilesize,
                        uploadMultiple: opts.uploadMultiple,
                        url: baseHttpPath + "/upload-file/upload",
                        init: function () {
                            this.on("addedfile", function (file) {
                                if (opts.beforeAdded && typeof opts.beforeAdded === 'function') {
                                    opts.beforeAdded(file);
                                }
                            });
                            this.on("sending", function (file, xhr, formData) {
                                if (opts.beforeSend && typeof opts.beforeSend === 'function') {
                                    opts.beforeSend(file, xhr, formData);
                                }
                            });
                            this.on("success", function (file, response) {
                                if (opts.onSuccess && typeof opts.onSuccess === 'function') {
                                    opts.onSuccess(file, response, elem);
                                }
                            });
                            this.on("complete", function (file) {
                                if (opts.onComplete && typeof opts.onComplete === 'function') {
                                    opts.onComplete(file);
                                }
                            });
                        }
                    });
                });
            });
        });
    };

}(jQuery));