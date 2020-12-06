var PageController = (function ($) {
    return {
        createUpdate: function () {
            PageController.CreateUpdate.init();
        },
        initCKEditor: function (selector) {
            CKEDITOR.replace(selector, {
                height: 800,
                toolbar: [
                    {name: 'document', items: ['Source']},
                    {name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic', 'Underline', '-', 'Strike', '-', 'RemoveFormat', 'CopyFormatting', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Link', 'Unlink']},
                    {clipboard: 'clipboard', items: ['PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
                    {name: 'styles', items: ['Styles', 'Format', 'FontSize']},
                    {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', '-', 'Embed', '-', 'UploadImage']},
                    {name: 'tools', items: ['Maximize']}
                ],
                allowedContent: true,
                extraPlugins: 'justify,autogrow,image2,customstyles',
                removePlugins: 'liststyle,tabletools,scayt,contextmenu',
                autoGrow_minHeight: 400,
                autoGrow_maxHeight: 1800,
                autoGrow_onStartup: true,
                disableNativeSpellChecker: false,
            });
        },
    };
}(jQuery));

PageController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        PageController.initCKEditor('editor');
    };
    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));