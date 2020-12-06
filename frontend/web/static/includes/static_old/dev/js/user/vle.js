var VleController = (function ($) {
    return {
        createUpdate: function () {
            VleController.CreateUpdate.init();
        },
        facilitation: function () {
            VleController.Facilitation.init();
        },
        datePicker: function(selector) {
            $(selector).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                endDate: new Date()
            });
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
                        
                        VleController.deleteMedia();
                    } else {
                        $().General_ShowErrorMessage({message: 'Some error occured. Please try again!!'});
                    }
                }
            });
        },
        deleteMedia: function () {
            $('body').on('click', '.deleteFile', function (e) {
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

VleController.CreateUpdate = (function ($) {
    var isSent = 0;
    var attachEvents = function () {
        createUpdateClass();
        deleteClass();
//        uploadfiles();
        VleController.uploadMedia();
//        VleController.deleteMedia();
        
        $(document).on('submit', 'form.filterForm', function(event) {
            var container = $('#classDataList');
            console.log(container);
            $.pjax.defaults.scrollTo = false;
            $.pjax.submit(event, container);
            var querystring = window.location.search;
            exportMerchants('/admin/user/export-vle' + querystring);
        });
        exportMerchants();

        updateClassModal();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            $(".scrolling").getNiceScroll().remove();
            $(".scrolling").niceScroll({
                cursorwidth: '5px',
                zindex: 999,
                horizrailenabled: true,
                cursorcolor: "#39c3dd",
                autohidemode: false
            });
            updateClassModal();
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
    };
    
    var exportMerchants = function () {
        
        $('.exportVle').click(function () {
            var querystring = window.location.search;
            window.location = '/admin/user/export-vle' + querystring;
        });
        
        $('.exportVleFacilitationData').click(function () {
            var querystring = window.location.search;
            window.location = '/admin/user/vle-facilitation-registration-export' + querystring;
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
                    if (data.success === 1) {
                        var $modal = $('#editVleModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        StateController.initializeChozen();
                        $('#editVleForm, #reset-password-form').unbind().on('submit', function (e) {
                            e.preventDefault();
                            if(isSent == 1) {
                                return;
                            }
                            message = 'User Updated Successfully!';
                            isSent = 1;
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

        $('#newVleForm').on('beforeSubmit', function (e) {
            var $modal = $('#newVleModal');
            message = 'Vle Created Successfully!';
            sectionAjaxForm($(this), $modal, message);
        }).on('submit', function (e) {
            e.preventDefault();
        });
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
                    $.pjax.reload({container: '#classDataList', timeout:false});
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
                message: "Do you really want to delete this Vle?",
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data.success == 1) {
                                    $.pjax.reload({container: '#classDataList', timeout: false});
                                    $.fn.General_ShowNotification({message: 'Vle deleted successfully.'});
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

VleController.Facilitation = (function ($) {    
    var attachEvents = function () {
        VleController.uploadMedia();
        VleController.deleteMedia();
        $('.page-main-content').on('change', '.vleCertified', function(e) {
            
            var val = $(this).val();
            if(val == '0') {
                $('.certifiedYes').addClass('hide');
                $('.certifiedNo').removeClass('hide');
                $('#vlefacilitation-vle_ccc_certificate_roll_no').attr('required', false).val('');
                $('#vlefacilitation-vle_ccc_grade').attr('required', false).val('');
                
                $('#vlefacilitation-equivalent_qualification').attr('required',true);
                $('#vlefacilitation-equivalent_person').attr('required',true);
                $('#vlefacilitation-equivalent_university_name').attr('required',true);
                $('#vlefacilitation-equivalent_roll_no').attr('required', true);
                $('#vlefacilitation-equivalent_grade').attr('required', true);
            }
            else {
                $('.certifiedNo').addClass('hide');
                $('.certifiedYes').removeClass('hide');
                $('#vlefacilitation-vle_ccc_certificate_roll_no').attr('required', true);
                $('#vlefacilitation-vle_ccc_grade').attr('required', true);
                
                $('#vlefacilitation-equivalent_qualification').attr('required', false).val('');
                $('#vlefacilitation-equivalent_person').attr('required', false).val('');
                $('#vlefacilitation-equivalent_university_name').attr('required', false).val('');
                $('#vlefacilitation-equivalent_roll_no').attr('required', false).val('');
                $('#vlefacilitation-equivalent_grade').attr('required', false).val('');
            }
            
            $(".chzn-select").trigger('chosen:updated');
        });
        
        $('.page-main-content').on('change', '.vleRegistered', function(e) {
            var val = $(this).val();
            if(val == '0') {
                $('.vleRegisteredYes').addClass('hide');
                $('.vleRegisteredNo').removeClass('hide');
                $('#vlefacilitation-facilitation_center_no').attr('required', false).val('');
                
                $('#vlefacilitation-equivalent_qualification').attr('required', true);
                $('#vlefacilitation-equivalent_person').attr('required', true);
                $('#vlefacilitation-equivalent_university_name').attr('required', true);
                $('#vlefacilitation-equivalent_roll_no').attr('required', true);
                $('#vlefacilitation-equivalent_grade').attr('required', true);
                
            }
            else {
                $('.vleRegisteredYes').removeClass('hide');
                $('.vleRegisteredNo').addClass('hide');
                $('#vlefacilitation-facilitation_center_no').attr('required',true);
                
                $('#vlefacilitation-vle_ccc_certificate_roll_no').attr('required', false).val('');
                $('#vlefacilitation-vle_ccc_grade').attr('required', false).val('');
                
                $('#vlefacilitation-equivalent_qualification').attr('required', false).val('');
                $('#vlefacilitation-equivalent_person').attr('required', false).val('');
                $('#vlefacilitation-equivalent_university_name').attr('required', false).val('');
                $('#vlefacilitation-equivalent_roll_no').attr('required', false);
                $('#vlefacilitation-equivalent_grade').attr('required', false);
            }
            $(".chzn-select").trigger('chosen:updated');

        });
        
        $('.vleCertified').change();
        $('.vleRegistered').change();
        
        $('#vlefacilitation-connectivity_type').change(function(){
            var val = $(this).val();
            if(val == 'Other'){
                $('#vlefacilitation-connectivity_type_other').removeClass('hide').attr('required',true);
            }else{
                $('#vlefacilitation-connectivity_type_other').addClass('hide').attr('required',false);
            }
        }).trigger('change');
        
        
        
    };
    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));