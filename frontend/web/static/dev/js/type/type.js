var TypeController = (function ($) {
    return {
        createUpdate: function () {
            TypeController.CreateUpdate.init();
        },
        updateStatus: function () {
            $('.updateStatus').on('click', function (e) {
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
                            elem.data('status', data.status);
                            var html = (data.status == "1") ? "<a href='javascript:;' title='Active'><span class='badge badge-success'>Active</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:;' title='Inactive'><span class='badge badge-danger'>Inactive</span><i class='fa fa-spin fa-spinner hide'></i></a>";
                            elem.html(html);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        elem.find('.badge').removeClass('hide');
                        elem.find('.fa').addClass('hide');
                        $().General_ShowErrorMessage({message: jqXHR.responseText});
                    },
                    beforeSend: function (jqXHR, settings) {
                        elem.find('.badge').addClass('hide');
                        elem.find('.fa').removeClass('hide');
                    },
                    complete: function (jqXHR, textStatus) {
                        elem.find('.badge').removeClass('hide');
                        elem.find('.fa').addClass('hide');
                    }
                });
            });
        }
    };
}(jQuery));

TypeController.CreateUpdate = (function ($) {
     
    var attachEvents = function () {
        deleteClass();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            deleteClass();
        });

    };

    var deleteClass = function () {
        $('.deleteType').on('click', function (e) {
             
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }
            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this type?",
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'button small blue'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button small grey'
                    }
                },
                callback: function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data.success == 1) {
                                    $.pjax.reload({container: '#DataList', timeout: false});
                                    $.fn.General_ShowNotification({message: 'Grievance Type deleted successfully.'});
                                }
                                else {
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