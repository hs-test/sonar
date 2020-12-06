var DiscomController = (function($) {
     return {
        createUpdate: function () {
            DiscomController.CreateUpdate.init();
        }
    };
}(jQuery));

DiscomController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        
        createUpdateDiscom();
        deleteDiscom();
        
        $(document).on('submit', 'form.filterForm', function(event) {
            var container = $('#discomDataList');
            $.pjax.defaults.scrollTo = false;
            $.pjax.submit(event, container);
        });
        
        updateDiscomModal();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
           updateDiscomModal();
           deleteDiscom();
        });
        
    };
    
    var updateDiscomModal = function () {
        $('.updateDiscom').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.attr('href');
            if (typeof url === 'undefined' || url === "") {
                return;
            }

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    if (data.success == '1') {
                        var $modal = $('#editDiscomModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $('#editDiscomForm').unbind().on('submit', function(e){
                            e.preventDefault();
                            var message = 'Discom Updated Successfully!';
                            ajaxForm($(this), $modal, message);
                            return false;
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-pencil');
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    elem.find('.fa').addClass('fa-spin fa-spinner').removeClass('fa-pencil');
                },
                complete: function (jqXHR, textStatus) {
                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-pencil');
                }
            });
        });
    };
    
    var createUpdateDiscom = function () {
        $('#newDiscomForm').on('beforeSubmit', function (e) {
            var $modal = $('#newDiscomModal');
            var message = 'Discom Created Successfully!';
            ajaxForm($(this), $modal, message);
        }).on('submit', function (e) {
            e.preventDefault();
        });
    };
    
    var ajaxForm = function (elem, $modal, message) {
        var url = elem.attr("action");
        var postData = elem.serialize();

        if (elem.find('.has-error').length) {
            return false;
        }

        $.ajax({
            url: url,
            type: "POST",
            data: postData,
            dataType: 'json',
            success: function (data) {
                if (data.success == '1') { 
                    $(elem).trigger('reset');
                    $modal.modal('hide');
                    $.pjax.reload({container: '#discomDataList', timeout:false});
                    $.fn.General_ShowNotification({message: message});
                }
                else {
                     
                    $().General_ShowErrorMessage({message: data.errors});
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.discomSubmitBtn').prop('disabled', false).html('Save');
                $().General_ShowErrorMessage({message: jqXHR.responseText});
            },
            beforeSend: function (jqXHR, settings) {
                $('.discomSubmitBtn').prop('disabled', true).html('Please Wait...');
            },
            complete: function (jqXHR, textStatus) {
                $('.discomSubmitBtn').prop('disabled', false).html('Save');
            }
        });
    };
    
    var deleteDiscom = function () {
        $('.deleteDiscom').on('click', function(e){
            e.preventDefault();
            var elem = $(this);
            var url = elem.attr('href');
            if(typeof url === 'undefined' || url === '') {
                return;
            }
            
            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this discom?",
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Ok',
                        className: 'button blue small'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button grey small'
                    }
                },
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                        type: 'post',
                        url: url,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if(data.success == 1) {
                                $.pjax.reload({container: '#discomDataList', timeout:false});
                                toastr.success("Discom deleted successfully.");
                            }
                            else{
                                $.fn.General_ShowNotification({type: 'error',message: 'This record cannot be deleted. due to raise some error.'});
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