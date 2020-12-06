var GrievanceController = (function ($) {
    return {
        summary: function () {
            GrievanceController.Summary.init();
        },
        createUpdate: function () {
            GrievanceController.CreateUpdate.init();
        },
        initializeChozen: function () {
             
            $(".chzn-select").chosen({width: '100%', disable_search: true}).change(function (e) {
                alert();
                var elem = $(this);
                var search = elem.data('search');
                if (typeof search === 'undefined' || search == '0')
                    return;
                $.fn.CascadeLocation({
                    val: elem.val(),
                    parent: elem.data('parent'),
                    onSuccess: function (data) {
                        var options = '<option value="">Select</option>';
                        $.each(data.data, function (index, element) {
                            options += '<option value="' + element.code + '">' + element.name.toUpperCase() + '</option>';
                        });
                        var selectClass = elem.data('child-class');
                        $('.' + selectClass).html(options);
                        $('.' + selectClass).trigger("chosen:updated");
                    },
                    beforeSend: function (obj) {
                    }
                });
            });
        },
        ckeditor: function () {
            CKEDITOR.replace('editor', {
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
                extraPlugins: 'justify,uploadimage,autogrow,image2,customstyles',
                removePlugins: 'liststyle,tabletools,scayt,contextmenu,elementspath',
                autoGrow_minHeight: 400,
                autoGrow_maxHeight: 1800,
                autoGrow_onStartup: true,
                disableNativeSpellChecker: false
            });

            CKEDITOR.on('instanceReady', function () {
                $.each(CKEDITOR.instances, function (instance) {
                    this.document.on("keyup", function (e) {
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                    });
                    this.document.on("paste", function (e) {
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                    });
                });
            });
        },
        import: function () {
            $().ShowFileName();
            $('.viewStat').on('click', function (e) {
                e.preventDefault();
                var elem = $(this);
                var url = elem.data('url');

                if (typeof url === 'undefined' || url === '') {
                    return;
                }
                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.success == "1") {
                            $('#viewStatModal').html(data.template);
                            $('#viewStatModal').modal('show');
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
        },
        viewMessageLog: function () {
            $('.viewMessageSummary').on('click', function (e) {
                e.preventDefault();
                var elem = $(this);
                var url = elem.data('url');
                
                if (typeof url === 'undefined' || url === '') {
                    return;
                }
                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.success == "1") {
                            $('#viewMessageLogModal').html(data.template);
                            $('#viewMessageLogModal').modal('show');
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
        },
        dateRangePicker: function (start, end, singledatepicker) {

            var options = {startDate: start, endDate: end, locale: {
                    format: "DD-MM-YYYY",
                    separator: " | "
                }
            };
            options.singleDatePicker = singledatepicker;
            $('.fromDatepicker').daterangepicker(options);
        },
        dateRangePickerStatusComparison: function(first, second,third,fourth){
            $('.firstDatePickerRange').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY',
                    cancelLabel: 'Clear'
                },
                autoclose: true,
                startDate: first,
                endDate: second,
                maxDate: new Date()
            });
            $('.secondDatePickerRange').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY',
                    cancelLabel: 'Clear'
                },
                autoclose: true,
                startDate: third,
                endDate: fourth,
                maxDate: new Date()
            });
        },
        date: function(date){
            $(".js-datePicker").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                endDate: '+0d',
                setDate: date
            });
        },
        datePicker: function (from_date, end_date) {

            $(".grievanceDate").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                date: from_date,
                endDate: end_date,
                setDate: from_date
            }).on("change", function () {

                var elem = $(this);
                var guid = elem.attr("data-guid");
                var date = elem.val();

                if (typeof date === 'undefined' || date === "") {
                    $().General_ShowErrorMessage({message: "Oops! invalid date"});
                    return;
                }
                if (typeof guid === 'undefined' || guid === "") {
                    return;
                }

                var params = {guid: guid, date: date, _csrf: yii.getCsrfToken()};
                GrievanceController.showDescription(elem, params);

            });
            
            $(".fromDatePicker").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('.toDatePicker').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('.toDatePicker').datepicker('setStartDate', null);
            });

            $(".toDatePicker").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('.fromDatePicker').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('.fromDatePicker').datepicker('setEndDate', null);
            });

        },
        showDescription: function (elem, params) {
            $.ajax({
                type: 'post',
                url: baseHttpPath + '/grievance/description-token',
                dataType: 'json',
                data: params,
                success: function (data, textStatus, jqXHR) {
                    if (data.success == "1") {
                        $('#updatestatusform').find('.description').val(data.token);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    $.fn.showScreenLoader();
                },
                complete: function (jqXHR, textStatus) {
                    $.fn.hideScreenLoader();
                }
            });
        },
        sendAjaxRequest: function (elem, params) {
            if (typeof params.url === 'undefined' || params.url === "") {
                $().General_ShowErrorMessage({message: "Oops! invalid url"});
                return;
            }
            if (typeof params.type === 'undefined' || params.type === "") {
                $().General_ShowErrorMessage({message: "Oops! invalid request type"});
                return;
            }

            $.ajax({
                type: params.type,
                url: params.url,
                dataType: 'json',
                data: params.postData,
                success: function (data, textStatus, jqXHR) {
                    if (data.success == "1") {
                        elem.data('status', data.status);
                        if (params.module == 'status') {
                            if (data.status == "1") {
                                elem.attr('title', 'Active');
                                elem.html("<a href='javascript:;' title='Active'><span class='badge badge-success'>Active</span><i class='fa fa-spin fa-spinner hide'></i></a>");
                            } else {
                                elem.attr('title', 'Inactive');
                                elem.html("<a href='javascript:;' title='Inactive'><span class='badge badge-danger'>Inactive</span><i class='fa fa-spin fa-spinner hide'></i></a>");
                            }
                        }
                        if (params.module == 'delete') {
                            toastr.success("Record deleted successfully.");
                            $.pjax.reload({container: '#DataList', timeout: false});
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (params.module == 'status') {
                        elem.find('.badge').removeClass('badge--spins');
                    }
                    if (params.module == 'delete') {
                        elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-trash'); // delete 
                    }
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    if (params.module == 'status') {
                        elem.find('.badge').addClass('badge--spins');
                    }
                    if (params.module == 'delete') {
                        elem.find('.fa').removeClass('fa-trash').addClass('fa-spin fa-spinner');
                    }
                },
                complete: function (jqXHR, textStatus) {
                    if (params.module == 'status') {
                        elem.find('.badge').removeClass('badge--spins');
                    }
                    if (params.module == 'delete') {
                        elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-trash');
                    }
                }
            });

        },
        
    };
}(jQuery));
GrievanceController.Summary = (function ($) {
    var attachEvents = function () {
        //updateStatus();
        deleteRecord();
        //sendSms();

        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            //updateStatus();
            deleteRecord();
            //sendSms();
        });

        $(document).on('pjax:beforeSend', function (event, xhr, textStatus, options) {
            //@todo
        });
    };

    var deleteRecord = function () {
        $('.deleteGrievanceRecord').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }
            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this record?",
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
                        var params = {url: url, type: 'post', module: 'delete', postData: {_csrf: yii.getCsrfToken()}};
                        GrievanceController.sendAjaxRequest(elem, params);
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

GrievanceController.CreateUpdate = (function ($) {
    var isSent = 0;
    var formSubmit = true;
    var attachEvents = function () {

        $("#importform-file").change(function () {

            var fullPath = document.getElementById('importform-file').value;
            var allowedFiles = ["jpg", "jpeg", "pdf", "png"];

            var lblError = $('.fileUploadMessage');

            if (fullPath) {
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                $(".file-name").val(filename);

                var ext = fullPath.split('.').pop().toLowerCase();

                if ($.inArray(ext, allowedFiles) == -1) {
                    $('#documentUpload').addClass('has-error');
                    lblError.html("Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.");
                    formSubmit = false;
                    return;
                } else {
                    $('#documentUpload').removeClass('has-error');
                    lblError.html("");
                    formSubmit = true;
                }

            }
        });

        //StateController.initializeChozen();
        addMultipleComment();
        updateGrievanceStatus();
        addCcComment();
        updateDepositoryType();
        updateAdditionalDetails();
        reassignedDealingHead();
        sendEmail();
        scanReview();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            addMultipleComment();
            updateGrievanceStatus();
            addCcComment();
            reassignedDealingHead();
            updateAdditionalDetails();
            updateDepositoryType();
            sendEmail();
            scanReview();
        });

    };
    
     var sendEmail = function () {
        $('.sendEmailMessage').off().on('click', function (e) {

            e.preventDefault();
            var elem = $(this);
            var grievanceLogId = elem.data('activity-log-id');

            if (typeof grievanceLogId === 'undefined' || grievanceLogId === '') {
                return;
            }

            showEmailTemplate(grievanceLogId)

        });
    };
    
    var reassignedDealingHead = function () {

        $('.reassignedGrievance').off().on('click', function (e) {

            e.preventDefault();
            var elem = $(this);
            var guid = elem.data('guid');
            var url = elem.data('url');
            var guidLists = [];
            var dhIds = [];
            $('input:checkbox[name="id[]"]:checked').each(function () {
                guidLists.push($(this).data('guid'));
                dhIds.push($(this).data('dh'));
            });

            if (guidLists.length <= 0) {
                $().General_ShowErrorMessage({message: "Oops! kindly Select Grievances to Reassigned"});
                return;
            }
            if (dhIds.length <= 0) {
                $().General_ShowErrorMessage({message: "Oops! Dealing head not selected found"});
                return;
            }

            var uniquedhIds = dhIds.filter(function (itm, i, a) {
                return i == dhIds.indexOf(itm);
            });
            //-----------------------------
            $.ajax({
                url: url,
                type: "POST",
                data: {dh: uniquedhIds, _csrf: yii.getCsrfToken()},
                dataType: 'json',
                success: function (data) {
                    if (data.success === 1) {

                        var $modal = $('#reassignedGrievanceStatusModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});

                        $('#reassignedForm').on('submit', function (e) {
                            e.preventDefault();

                            var elem = $(this);
                            var url = elem.attr("action");
                            var formId = elem.attr("id");

                            if (elem.find('.has-error').length) {
                                return false;
                            }
                            var dealing_head = elem.find('.dealingHead :selected').val();
                            var message = 'SRN Details updated Successfully!';
                            var params = {dealing_head: dealing_head, guidList: guidLists, _csrf: yii.getCsrfToken()};

                            $.ajax({
                                type: 'post',
                                url: url,
                                dataType: 'json',
                                data: params,
                                success: function (data, textStatus, jqXHR) {
                                    
                                    $(elem).trigger('reset');
                                    $modal.modal('hide');
                                    
                                    var messageLog = Handlebars.compile(reassignedTargetLogs);
                                    var layout = messageLog(data);
                                    var $assignedmodal = $('#showReAssignedSuccessFailLogs');
                                    $assignedmodal.html(layout);
                                    $assignedmodal.modal('show');
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    elem.find('.fa').addClass('fa-edit').removeClass('fa-spin fa-spinner');
                                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                                },
                                beforeSend: function (jqXHR, settings) {
                                    elem.prop('disabled', true);
                                    elem.find('.fa').removeClass('fa-edit').addClass('fa-spin fa-spinner');
                                    $.fn.showScreenLoader();
                                },
                                complete: function (jqXHR, textStatus) {
                                    elem.prop('disabled', false);
                                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-edit');
                                    $.fn.hideScreenLoader();
                                }
                            });

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
    }
    
    var scanReview = function () {
        $('.updateScanReviewDetail').on('click', function (e) {
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
                        var $modal = $('#newScanReviewModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});
                        
                        $(".js-scanreviewdatePicker").datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            endDate: '+0d',
                        });
                        
                        $('#commentform').on('beforeSubmit', function (e) {
                            var message = 'Comment Added Successfully!';
                            sectionAjaxForm($(this), $modal, message, false);
                        }).on('submit', function (e) {
                            e.preventDefault();
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-qrcode');
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    elem.find('.fa').addClass('fa-spin fa-spinner').removeClass('fa-qrcode');
                },
                complete: function (jqXHR, textStatus) {
                    elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-qrcode');
                }
            });
        });
    };
     
    var addCcComment = function () {
        $('.addComment').on('click', function (e) {
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
                        var $modal = $('#newCommentModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});
                        
                        $('#commentform').on('beforeSubmit', function (e) {
                            var message = 'Comment Added Successfully!';
                            sectionAjaxForm($(this), $modal, message, false);
                        }).on('submit', function (e) {
                            e.preventDefault();
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
    
    var addMultipleComment = function () {
        $('.addMultipleComment').on('click', function (e) {
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
                        var $modal = $('#addMultipleCommentModel');
                        $modal.html(data.template);
                        $modal.modal('show');
                        
                        $('#commentform').on('beforeSubmit', function (e) {
                            var message = 'Comment Added Successfully!';
                            sectionAjaxForm($(this), $modal, message, false);
                        }).on('submit', function (e) {
                            e.preventDefault();
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
    
    var updateDepositoryType = function () {
        $('.updateDepository').on('click', function (e) {

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
                        var $modal = $('#updateDepositoryModel');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});

                        $('#grievance').on('beforeSubmit', function (e) {
                            var message = 'Depository updated Successfully!';
                            sectionAjaxForm($(this), $modal, message, false);
                        }).on('submit', function (e) {
                            e.preventDefault();
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
    
    var updateAdditionalDetails = function () {
        $('.updateAdditionalDetail').on('click', function (e) {
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
                        var $modal = $('#updateAdditionalDetailModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});
                        $('#grievance').on('beforeSubmit', function (e) {
                            var message = 'SRN Details updated Successfully!';
                            sectionAjaxForm($(this), $modal, message, false);
                        }).on('submit', function (e) {
                            e.preventDefault();
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
    
    var showEmailTemplate = function (id) {
        
        $.ajax({
            url: baseHttpPath + '/grievance/template?id=' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                if (data.success === 1) {
                    var $modal = $('#messageTemplateModal');
                    $modal.html(data.template);
                    $modal.modal('show');
                    $('#messageform').on('beforeSubmit', function (e) {
                        var message = 'Message Send Successfully!';
                        sectionAjaxForm($(this), $modal, message, false);
                    }).on('submit', function (e) {
                        e.preventDefault();
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

                $().General_ShowErrorMessage({message: jqXHR.responseText});
            },
            beforeSend: function (jqXHR, settings) {

            },
            complete: function (jqXHR, textStatus) {

            }
        });

    };
   
    var sectionAjaxForm = function (elem, $modal, message , showPreview) {
        
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
                    $(elem).trigger('reset');
                    $modal.modal('hide');
                    if (showPreview) {
                        if (data.grievance_activity_id == '') {
                            return;
                        }
                        
                        showEmailTemplate(data.grievance_activity_id);
                    }

                    $.pjax.reload({container: '#DataList', timeout: false});
                    toastr.success(message);

                } else {
                    $.each(data.errors, function (key, val) {
                        if (key == 'comments') {
                            $().General_ShowErrorMessage({message: 'Oops! kindly select atleast one value'});
                        }
                        $(".field-" + formId + "-" + key).addClass('has-error').find('p').text(val);
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
    
    var updateGrievanceStatus = function () {
        $('.updateGrievanceStatus').off().on('click', function (e) {
            e.preventDefault();

            var elem = $(this);
            var url = elem.data('url');
            var guid = elem.data('guid');
            var status = elem.data('status');
            var logId = elem.data('logid');
            var msgSent = elem.data('msgsent');

            var showPreview = false;
            if (typeof url === 'undefined' || url === "") {
                return;
            }

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    if (data.success === 1) {
                        var d = new Date();
                        var month = d.getMonth() + 1;
                        var day = d.getDate();

                        var currentDate = day + '-' +
                                (month < 10 ? '0' : '') + month + '-' +
                                (day < 10 ? '0' : '') + d.getFullYear();
                        GrievanceController.datePicker(currentDate, currentDate);

                        if (userRole == 3) {
                            if (status == '0') {
                                var dropdown = {1: 'FC'};
                            } else {
                                var dropdown = {2: 'RC'};
                            }
                            var params = {guid: guid, _csrf: yii.getCsrfToken(), date: currentDate};
                            GrievanceController.showDescription(elem, params);
                        }
                        if (userRole == 6 || userRole == 10 || userRole == 9) {
                            showPreview = false;
                            if (status == '3') {
                                showPreview = false;
                            }
                            var dropdown = {6: 'PAID'};
                        }
                        if (userRole == 4) {

                            if (status == '5') {
                                showPreview = true;
                            }
                            if (status == '7') {

                                var dropdown = {3: 'APPROVED', 4: 'REJECTED', 5: 'DISCREPANCY'};
                            } else {
                                var dropdown = {7: 'UNDER PROCESS', 4: 'REJECTED', 5: 'DISCREPANCY'};
                            }
                        }
                        
                        if (userRole == 1 || userRole == 8) {

                            if (status == '3' || status == '6' || status == '7' || status == '5') {
                                $().General_ShowErrorMessage({message: 'Oops! Status cannot be update for this SRN.'});
                                return;
                            }
                            if (status == '4') {
                                var dropdown = {2: 'RESUBMITTED PENDING'};
                            } else if (status == '0') {
                                showPreview = true;
                                var dropdown = {4: 'REJECTED'};
                            } else if (status == '2') {
                                showPreview = true;
                                var dropdown = {3: 'APPROVED', 4: 'REJECTED'};
                            }
                        } else {
                            if ((status == '3' || status == '4' || status == '6') && (userRole != 6 && userRole != 10 && userRole != 9)) {
                                $().General_ShowErrorMessage({message: 'Oops! Status cannot be update for this SRN.'});
                                return;
                            }
                        }

                        if (showPreview && logId !== '' && (msgSent == '2' || msgSent == '1')) {
                            showEmailTemplate(logId);
                            return;
                        }

                        var statusDropDown = Handlebars.compile(optionDropdownList);
                        var htmlLayout = statusDropDown(dropdown);

                        var $modal = $('#updateStatusModal');
                        $modal.html(data.template);

                        $modal.find('.grievanceDate').attr('data-guid', guid);
                        $modal.find('.applicationStatus').html(htmlLayout);
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});
                        GrievanceController.datePicker();
                        $modal.modal('show');

                        $('.applicationStatus').val('9');
                        $('.applicationStatus').trigger('chosen:updated');
                        $('.applicationStatus').on('change', function () {

                            var type = $(this).find('option:selected').val();
                            var className = $(this).data('class');
                            var classApproved = $(this).data('class-approved');
                            if (type == '5') {
                                showPreview = true;
                                getListtype($modal, 'DISCREPANCY');
                                $modal.find('.' + className).show();
                                $modal.find('.' + classApproved).hide();
                            } else if (type == '4') {
                                //showPreview = true;
                                getListtype($modal, 'REJECTED');
                                $modal.find('.' + className).show();
                                $modal.find('.' + classApproved).hide();
                            }
//                             else if (type == '6') {
//                                showPreview = true;
//                            }
                            else {

                                //$modal.find(".listTypes").val('').trigger("chosen:updated");
                                $modal.find(".listComments").prop("checked", false);
                                $modal.find('.' + className).hide();
                                $modal.find('.' + classApproved).show();
                                $modal.find(".requestedShare").val('');
                                $modal.find(".sharedAmount").val('');
                            }
                        });
                        
                        
                        $('#updatestatusform').on('beforeSubmit', function (e) {
                            var message = 'Status Updated Successfully!';
                            var statusSelected = $('.applicationStatus').find('option:selected').val();
                            if (statusSelected == '3' && userRole == 4) {
                                var approved_amount = $('#updatestatusform-approved_shares').val();
                                var approved_share = $('#updatestatusform-approved_amount').val();
                                if (approved_amount == '' && approved_share == '') {
                                    $().General_ShowErrorMessage({message: 'Please enter atleast one value.'});
                                    return;
                                }
                            }

                            sectionAjaxForm($(this), $modal, message, showPreview);
                        }).on('submit', function (e) {
                            e.preventDefault();
                            e.stopPropagation();
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
    
    var getListtype = function (elem, type) {
        $.ajax({
            type: 'POST',
            url: baseHttpPath + '/grievance/get-list',
            dataType: 'json',
            data: {type: type, _csrf: yii.getCsrfToken()},
            success: function (data, textStatus, jqXHR) {
                if (data.success == "1") {
                    if (data.optionGroup == '1') {
                        var dropDown = Handlebars.compile(groupCheckBoxListLayout);
                        var layout = dropDown({list: data.list});

                    } else {
                        var dropDown = Handlebars.compile(checkBoxListLayout);
                        var layout = dropDown(data.list);
                    }
                    
                    elem.find('.checkListBoxComments').html(layout);
                    $('.js-accordian').on('click', function () {
                        $(this).closest('.application-accordian__container').toggleClass('active').find('.application-accordian__list').slideToggle();
                    });

                    $(".select-on-check-all").on('change', function () {
                        var id = $(this).data('id');
                        if ($(this).is(':checked')) {
                            $('#' + id).find("input[type=checkbox]").each(function () {
                                $(this).prop("checked", true);
                            });
                            
                        } else {
                            $('#' + id).find("input[type=checkbox]").each(function () {
                                $(this).prop("checked", false);
                            });
                        }
                    });
               
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $().General_ShowErrorMessage({message: jqXHR.responseText});
            },
            beforeSend: function (jqXHR, settings) {
                $.fn.showScreenLoader();
            },
            complete: function (jqXHR, textStatus) {
                $.fn.hideScreenLoader();
                elem.find(".listTypes").trigger("chosen:updated");
            }
        });
    };

    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));