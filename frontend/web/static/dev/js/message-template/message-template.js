/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var MessageTemplateController = (function($) {
     return {
        view: function () {
            MessageTemplateController.View.init();
        }
    };
}(jQuery));

MessageTemplateController.View = (function ($) {
    var attachEvents = function () {

        viewTemplate();
     //   updateClassModal();
    };
    
    var viewTemplate = function () {
        $('.viewtemplate').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');

            if (typeof url === 'undefined' || url === '') {
                return;
            }

            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data.success == "1") {
                        $('#viewTemplateModal').html(data.template);
                        $('#viewTemplateModal').modal('show');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-eye');
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    elem.find('.fa').addClass('fa-spin fa-spinner').removeClass('fa-eye');
                },
                complete: function (jqXHR, textStatus) {
                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-eye');
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

