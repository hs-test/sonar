/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var FinancialYearController = (function($) {
     return {
        createUpdate: function () {
            FinancialYearController.CreateUpdate.init();
        }
    };
}(jQuery));

FinancialYearController.CreateUpdate = (function ($) {
    var attachEvents = function () {

        deleteFinancialYear();
    
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
     
           deleteFinancialYear();
        });

        $(document).on('pjax:beforeSend', function (event, xhr, textStatus, options) {
          //@todo
        });
    };
    
    var initJs = function () {
        
    };

    var deleteFinancialYear = function () {
        $('.deletefinancialyear').on('click', function(e){
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if(typeof url === 'undefined' || url === '') {
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this Financial Year?",
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
                        url: url,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if(data.success == "1") {
                                toastr.success("Record deleted successfully.");
                                $.pjax.reload({container: '#fianancialyearDataList', timeout:false});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-trash');
                            $().General_ShowErrorMessage({message: jqXHR.responseText});
                        },
                        beforeSend: function (jqXHR, settings) {
                            elem.find('.fa').removeClass('fa-trash').addClass('fa-spin fa-spinner');
                        },
                        complete: function (jqXHR, textStatus) {
                            elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-trash');
                        }
                    });
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

