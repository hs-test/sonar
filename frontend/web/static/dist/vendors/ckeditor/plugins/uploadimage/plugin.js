CKEDITOR.plugins.add('uploadimage', {
    icons: 'uploadimage',
    init: function (editor) {
        editor.addCommand('callUploadImage', {
            exec: function (editor) {
                var ckeditor = editor;
                $.fn.uploadCKEditorFile({
                    onSuccess: function (file, response) {
                        if (response.success == "1") {
                            
                            var mediaPath = response.media['cdnPath'];
                            var extensionImageStr = allowedImageExtension;
                            var extensionImgArr = extensionImageStr.split(',');
                            var ext = "."+response.extension;
                            if($.inArray(ext, extensionImgArr) !== -1) {
                                ckeditor.insertHtml('<p><img class="img-responsive" style="max-width: 100% !important;" src="' + mediaPath + '"/></p>');
                            }
                            else {
                               ckeditor.insertHtml('<p><a href="'+mediaPath+'">'+mediaPath+'</a></p>'); 
                            }
                            
                        } else {
                            $().General_ShowErrorMessage({message: 'While save file in remote cdn error.'});
                        }
                    }
                });
            }
        });
        editor.ui.addButton('UploadImage', {
            label: 'Upload Image',
            command: 'callUploadImage',
            toolbar: 'insert'
        });
    }
});

(function ($) {
    $.fn.uploadCKEditorFile = function (options) {
        var defaults = {
            maxFilesize: 5,
            uploadMultiple: false,
            addRemoveLinks: true,
            acceptedFiles: allowedImageExtension + ',' + allowedFileExtension,
            onSuccess: function () {},
            onError: function () {},
            beforeSend: function () {},
            beforeAdded: function () {},
            onComplete: function () {}
        };
        var opts = $.extend({}, defaults, options);
        var $modal = $('#uploadImageModal');

        $.fn.upload($modal, opts, this);
    };
}(jQuery));