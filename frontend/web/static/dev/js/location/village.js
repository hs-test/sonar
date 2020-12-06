var VillageController = (function ($) {
    return {
        createUpdate: function () {
            VillageController.CreateUpdate.init();
        }
    };
}(jQuery));

VillageController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        createUpdateVillage();
        deleteVillage();
        
        $(document).on('submit', 'form.filterForm', function(event) {
            var container = $('#villageDataList');
            $.pjax.defaults.scrollTo = false;
            $.pjax.submit(event, container);
        });

        updateVillageModal();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            updateVillageModal();
            deleteVillage();
        });
        
        StateController.initializeChozen();

    };

    var updateVillageModal = function () {
        $('.updateVillage').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === "") {
                return;
            }

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    if (data.success === 1) {
                        var $modal = $('#editVillageModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        
                        $(".datepicker").datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            todayHighlight: true,
                            endDate: new Date()
                        });
                        
                        StateController.initializeChozen();
                        $('#editVillageForm').unbind().on('submit', function (e) {
                            e.preventDefault();
                            var message = 'Village Updated Successfully!';
                            sectionAjaxForm($(this), $modal, message);
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

    var createUpdateVillage = function () {

        $('#newVillageForm').on('beforeSubmit', function (e) {
            var $modal = $('#newVillageModal');
            var message = 'Village Created Successfully!';
            sectionAjaxForm($(this), $modal, message);
        }).on('submit', function (e) {
            e.preventDefault();
        });
    };
    
    var sectionAjaxForm = function (elem, $modal, message) {
        var url = elem.attr("action");
        var formId = elem.attr("id");
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
                    $(".chzn-select").not('#village-status').val('').trigger("chosen:updated"); 
                    $(elem).trigger('reset');
                    $modal.modal('hide');
                    $.pjax.reload({container: '#villageDataList', timeout: false});                
                    $.fn.General_ShowNotification({message: message});
                    location .reload();
                } else {
                    $.each(data.errors, function(key, val) {
                        $( "#"+formId+" .field-village-"+key ).addClass('has-error').find('p').text(val);
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.villageSubmitBtn').prop('disabled', false).html('Save');
                $().General_ShowErrorMessage({message: jqXHR.responseText});
            },
            beforeSend: function (jqXHR, settings) {
                $('.villageSubmitBtn').prop('disabled', true).html('Please Wait...');
            },
            complete: function (jqXHR, textStatus) {
                $('.villageSubmitBtn').prop('disabled', false).html('Save');
            }
        });
    };

    var deleteVillage = function () {
        $('.deleteVillage').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this Village?",
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data.success == 1) {
                                    $.pjax.reload({container: '#villageDataList', timeout: false});
                                    $.fn.General_ShowNotification({message: 'Village deleted successfully.'});
                                }
                                else{
                                    $.fn.General_ShowNotification({type: 'error', message: 'This record cannot be deleted. A child record exists!'});
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