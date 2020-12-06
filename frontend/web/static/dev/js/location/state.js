var StateController = (function($) {
     return {
        createUpdate: function () {
            StateController.CreateUpdate.init();
        },
        initializeChozen: function () {
            $(".chzn-select").chosen({width: '100%', disable_search: true}).change(function (e) {
                var elem = $(this);
                var search = elem.data('search');
                if(typeof search === 'undefined' || search == '0') return;
                $.fn.CascadeLocation({
                    val: elem.val(),
                    parent: elem.data('parent'),
                    onSuccess: function (data) {
                        var options = '<option value="">Select</option>';
                        $.each(data.data, function(index, element) {
                            options += '<option value="'+element.code+'">'+element.name.toUpperCase()+'</option>'; 
                        });
                        var selectClass = elem.data('child-class');
                        $('.'+selectClass).html(options);
                        $('.'+selectClass).trigger("chosen:updated");
                    },
                    beforeSend: function (obj) {
                    }
                });
            });
        },
        getDiscom: function () {
            $('.stateDiscom').on('change', function (e) {
                 
                e.preventDefault();
                var elem = $(this);
                var stateCode = elem.val();
                if (stateCode === "") {
                    $(".getDiscom").val('');
                    $(".getDiscom").trigger("chosen:updated");
                    return;
                }
                
                $.ajax({type: 'post',
                    url: baseHttpPath + '/api/location/get-discom',
                    dataType: 'json',
                    data: {stateCode: stateCode, _csrf: yii.getCsrfToken()},
                    success: function (data, textStatus, jqXHR) {
                        if (data.success == "1") {
                            $(".getDiscom").html(data.template);
                            $(".getDiscom").trigger("chosen:updated");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.fn.ShowFlashMessages({type: 'error', message: jqXHR.responseText});
                    },
                    beforeSend: function (jqXHR, settings) {
                        $.fn.showScreenLoader();
                    },
                    complete: function (jqXHR, textStatus) {
                        $.fn.hideScreenLoader();
                    }
                });
            });
        }
    };
}(jQuery));

StateController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        
        createUpdateClass();
        deleteClass();
        
        $(document).on('submit', 'form.filterForm', function(event) {
            var container = $('#classDataList');
            $.pjax.defaults.scrollTo = false;
            $.pjax.submit(event, container);
        });
        
        updateClassModal();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
           updateClassModal();
           deleteClass();
        });
        
    };
    
    var updateClassModal = function () {
        $('.updateClass').on('click', function (e) {
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
                    if (data.success == '1') {
                        var $modal = $('#editStateModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $(".chzn-select").chosen({width: '100%', disable_search: true});
                        $('#editStateForm').unbind().on('submit', function(e){
                            e.preventDefault();
                            var message = 'State Updated Successfully!';
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
    
    var createUpdateClass = function () {

        $('#newStateForm').on('beforeSubmit', function (e) {
            var $modal = $('#newStateModal');
            var message = 'State Created Successfully!';
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
                    $(elem).trigger('reset');
                    $modal.modal('hide');
                    $.pjax.reload({container: '#classDataList', timeout:false});
                    $.fn.General_ShowNotification({message: message});
                }
                else {
                    $.each(data.errors, function(key, val) {
                        $( "#"+formId+" .field-state-"+key ).addClass('has-error').find('p').text(val);
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.classSubmitBtn').prop('disabled', false).html('Save');
                $().General_ShowErrorMessage({message: jqXHR.responseText});
            },
            beforeSend: function (jqXHR, settings) {
                $('.classSubmitBtn').prop('disabled', true).html('Please Wait...');
            },
            complete: function (jqXHR, textStatus) {
                $('.classSubmitBtn').prop('disabled', false).html('Save');
            }
        });
    };
    
    var deleteClass = function () {
        $('.deleteClass').on('click', function(e){
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if(typeof url === 'undefined' || url === '') {
                return;
            }
            
            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this state?",
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                        type: 'post',
                        url: url,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if(data.success == 1) {
                                $.pjax.reload({container: '#classDataList', timeout:false});
                                $.fn.General_ShowNotification({message: 'State Deleted Successfully!'});
                            }
                            else{
                                $.fn.General_ShowNotification({type: 'error',message: 'This record cannot be deleted. A child record exists!'});
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