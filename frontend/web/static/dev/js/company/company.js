/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var CompanyController = (function ($) {
    return {
        createUpdate: function () {
            CompanyController.CreateUpdate.init();
        }
    };
}(jQuery));

CompanyController.CreateUpdate = (function ($) {
    var attachEvents = function () {

        //  createUpdateClass();
        deleteCompany();
        deleteCompanyUser();
        viewCmp();
        updateCompanyInfo();
        //   updateClassModal();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            deleteCompany();
            deleteCompanyUser();
            viewCmp();
            updateCompanyInfo();
        });
    };

    var viewCmp = function () {
        $('.viewcompany').on('click', function (e) {
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
                        $('#viewCompanyModal').html(data.template);
                        $('#viewCompanyModal').modal('show');
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

    var deleteCompany = function () {
        $('.deleteCompany').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this company?",
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
                                if (data.success == "1") {
                                    toastr.success("Record deleted successfully.");
                                    $.pjax.reload({container: '#companyDataList', timeout: false});
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
    
    var deleteCompanyUser = function () {
        $('.deleteCompanyUser').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this user?",
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
                                if (data.success == "1") {
                                    toastr.success("Record deleted successfully.");
                                    $.pjax.reload({container: '#DataList', timeout: false});
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

    var addMoreRow = function () {

        var next = 2;
        $('.addCompanyInfoBtn').on('click', function (e) {

            console.log(next);
            e.preventDefault();
            var container = $('.companyUserContainer').find('.row').length;
            if (container >= 6) {
                return;
            }

            var removeId = 'removeClassSectionBlock' + next;
            var counter = next;
            next = next + 1;

            var source = $("#companyInfoBlock").html();
            var template = Handlebars.compile(source);
            var html = template({removeId: removeId, counter: counter});

            $('.companyUserContainer').append(html);

            $('.removeBlock').click(function (e) {
                e.preventDefault();
                var containerId = $(this).attr('id');
                $('.' + containerId).remove();

            });

        });
    };
    var updateCompanyInfo = function () {
        $('.addCompanyInfoBtn').on('click', function (e) {
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
                        var $modal = $('#addCompanyInfoModal');
                        $modal.html(data.template);
                        $modal.modal('show');
                        $modal.find(".chzn-select").chosen({width: '100%', disable_search: false});
                        $('#companyinfo').on('beforeSubmit', function (e) {
                            var message = 'company info added successfully!';
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
                    $(elem).trigger('reset');
                    $modal.modal('hide');

                    $.pjax.reload({container: '#DataList', timeout: false});
                    toastr.success(message);

                } else {
                    $.each(data.errors, function (key, val) {
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

    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));

