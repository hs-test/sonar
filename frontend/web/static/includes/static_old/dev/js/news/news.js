

var NewsController = (function ($) {
    return {
        createUpdate: function () {
            NewsController.CreateUpdate.init();
        },
        sendAjaxRequest: function (elem,params) {
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
                data:params.postData,
                success: function (data, textStatus, jqXHR) {
                    if (data.success == "1") {
                        elem.data('status', data.status);
                        if (params.module == 'status') {
                            if (data.status == "1") {
                                elem.attr('title', 'Active');
                                elem.html("<span class='badge badge-success'><span class='title'>Active</span> <i class=''></i></span>");
                            } else {
                                elem.attr('title', 'Inactive');
                                elem.html("<span class='badge badge-danger'><span class='title'>Inactive</span> <i class=''></i></span>");
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
                  
        }
    };
}(jQuery));
NewsController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        updateStatus();
        deleteRecord();
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            updateStatus();
            deleteRecord();
        });

        $(document).on('pjax:beforeSend', function (event, xhr, textStatus, options) {
            //@todo
        });
    };
  

    var deleteRecord = function () {
        $('.deleteNewsRecord').on('click', function (e) {
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
                        NewsController.sendAjaxRequest(elem, params);
                    }
                }
            });
        });
    };
    var updateStatus = function (e) {
        $('.updateNewsStatus').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }
            var params = {url: url, type: 'post', module: 'status', postData: {_csrf: yii.getCsrfToken()}};
            NewsController.sendAjaxRequest(elem, params);
        });
    };
    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));