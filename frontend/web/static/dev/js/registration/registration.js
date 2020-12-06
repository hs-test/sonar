var RegistrationController = (function ($) {
    return {
        createUpdate: function () {
            RegistrationController.CreateUpdate.init();
        },
        uploadMedia: function () {
            $('a.uploadFileBtn').uploadFile({
                maxImage: 1,
                cloudUpload: true,
                addRemoveLinks: false,
                acceptedFiles: ".jpg,.png,.gif",
                onSuccess: function (file, response, elem) {
                    
                    if (response.success == "1") {
                        var media = response.media;
                        var source = $("#single-upload-media-template").html();
                        var template = Handlebars.compile(source);
                        var html = template({media: media.cdnPath, id: media.orig, guid: media.guid, file: response.fileName});
                        
                        $(elem).parents('.mediaContainer').find('input[type="hidden"]').val(media.orig);
                        
                        $(elem).parents('.mediaContainer').find('.mediaUploadBox').addClass('hide');
                        $(elem).parents('.mediaContainer').find('.mediaResultset').removeClass('hide');
                        $(elem).parents('.mediaContainer').find('.mediaResultset').html(html);

                        $('#uploadImageModal').modal('hide');
                        
                        RegistrationController.deleteMedia(elem);
                    } else {
                        $().General_ShowErrorMessage({message: 'Some error occured. Please try again!!'});
                    }
                }
            });
        },
        deleteMedia: function (elem) {
            
            if(elem == undefined){
                var target = $('.deleteFile');
            }else{
                var target = $(elem).parents('.mediaContainer').find('.deleteFile');
            }
            
            
            
            target.on('click', function (e) {
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
                                        
                                        $(elem).parents('.mediaContainer').find('.mediaUploadBox').removeClass('hide');
                                        
                                        $(elem).parents('.mediaContainer').find('input[type="hidden"]').val('');
                                        
                                        $(elem).parents('.mediaContainer').find('.mediaResultset').addClass('hide');
                                        $(elem).parents('.mediaContainer').find('.mediaResultset').html('');
                                        
                                        toastr.success("File deleted.");
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
        }
    };
}(jQuery));

RegistrationController.CreateUpdate = (function ($) {
    
    RegistrationController.deleteMedia();
    
    var attachEvents = function () {
//        createUpdateClass();
        deleteClass();
//        uploadfiles();
        RegistrationController.uploadMedia();
//        RegistrationController.deleteMedia();
        
        $(document).on('submit', 'form.filterForm', function(event) {
            var container = $('#DataList');
            console.log(container);
            $.pjax.defaults.scrollTo = false;
            $.pjax.submit(event, container);
            var querystring = window.location.search;
            exportMerchants('/admin/user/export-vle' + querystring);
        });
        

//        updateClassModal();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            $(".scrolling").getNiceScroll().remove();
            $(".scrolling").niceScroll({
                cursorwidth: '5px',
                zindex: 999,
                horizrailenabled: true,
                cursorcolor: "#39c3dd",
                autohidemode: false
            });
//            updateClassModal();
            deleteClass();
        });
        
        StateController.initializeChozen();
        
        // start-date
        $("#startdate").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#enddate').datepicker('setStartDate', minDate);
        });

        // end-date
        $("#enddate").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        });
        
        $(".dob").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            // current date - 12 years
            endDate: new Date((new Date).getFullYear()-12,(new Date).getMonth(),(new Date).getDate())
        }).on('changeDate', function (selected) {
//            var maxDate = new Date(selected.date.valueOf());
//            $('.datepicker').datepicker('setEndDate', maxDate);
        });
        
        $('.exportData').click(function () {
            var querystring = window.location.search;
            window.location = '/admin/registration/export' + querystring;
        });
        
        $('.exportDataHealth').click(function () {
            var querystring = window.location.search;
            window.location = '/admin/health-service-registration/export' + querystring;
        });
        
        // if already registered then require previous roll no.
        $('#registration-applied_previously').change(function(){
            var val = $(this).val();
            if(val == 0){
                $('#registration-previous_roll_no').attr('required',false).attr('readonly',true).val('');
            }else{
                $('#registration-previous_roll_no').attr('required',true).attr('readonly',false);
            }
            
        }).trigger('change')
        
    };
    
    
    var sectionAjaxForm = function (elem, $modal, message) {
        var url = elem.attr("action");
        var postData = elem.serialize();
        var formId = elem.attr("id");

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
                    $(".chzn-select").not('#vleform-status').val('').trigger("chosen:updated"); 
                    $(elem).trigger('reset');
                    $modal.modal('hide');
                    $.fn.General_ShowNotification({message: message});
                    $.pjax.reload({container: '#DataList', timeout:false});
                }
                else {
                    $.each(data.errors, function(key, val) {
                        $( "#"+formId+" .field-vleform-"+key ).addClass('has-error').find('p').text(val);
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
                isSent = 0;
            }
        });
    };

    var deleteClass = function () {
        $('.deleteClass').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this record?",
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data.success == 1) {
                                    $.pjax.reload({container: '#DataList', timeout: false});
                                    $.fn.General_ShowNotification({message: 'Record deleted successfully.'});
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

