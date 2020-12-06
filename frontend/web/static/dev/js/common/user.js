var UserController = (function ($) {
    var isSent = 0;
    return {
        summary: function () {
            UserController.Summary.init();
        },
        deleteUser: function () {

            $('.deleteUser').on('click', function (e) {
                e.preventDefault();
                var elem = $(this);
                var url = elem.data('url');
                if (typeof url === 'undefined' || url === '') {
                    return;
                }

                bootbox.confirm({
                    title: "Confirm",
                    message: "Do you really want to delete this User?",
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
                                    if (data.success == 1) {
                                        $.pjax.reload({container: '#userDataList', timeout: false});
                                        toastr.success("User deleted successfully.");
                                        //$.fn.General_ShowNotification({message: 'User deleted successfully'});
                                    } else {
                                        $.fn.General_ShowNotification({error: 'This user cannot be deleted'});
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
                            var html = (data.status == "10") ? "<a href='javascript:;' title='Active'><span class='badge badge-success'>Active</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:;' title='Inactive'><span class='badge badge-danger'>Inactive</span><i class='fa fa-spin fa-spinner hide'></i></a>";
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
        },
        changepassword: function () {
            $('.changePassword').on('click', function (e) {
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
                            var $modal = $('#changePasswordModel');
                            $modal.html(data.template);
                            $modal.modal('show');
                            $('#resetpasswordform').unbind().on('submit', function (e) {
                                e.preventDefault();
                                var formelem  = $(this);    
                                var url = formelem.attr("action");
                                var postData = formelem.serialize();
                                var formId = formelem.attr("id");

                                if (formelem.find('.has-error').length) {
                                    return false;
                                }

                                $.ajax({
                                    url: url,
                                    type: "POST",
                                    data: postData,
                                    dataType: 'json',
                                    success: function (data) {
                                        if (data.success == '1') {
                                            $(formelem).trigger('reset');
                                            $modal.modal('hide');
                                            toastr.success("User password changed successfully.");
                                            //$.fn.General_ShowNotification({message: message});
                                            $.pjax.reload({container: '#userDataList', timeout: false});
                                        } else {
                                            
                                            $.each(data.errors, function (key, val) {
                                                console.log(formId);
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
        },
        allowedgrievance: function () {
            $('.updateAllowedGrievance').on('click', function (e) {
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
                            var $modal = $('#updateAllowedGrievanceModel');
                            $modal.html(data.template);
                            $modal.modal('show');
                            $('#usertagerlog').unbind().on('submit', function (e) {
                               
                                e.preventDefault();
                                var formelem = $(this);
                                var url = formelem.attr("action");
                                var postData = formelem.serialize();
                                var formId = 'usertargetlog';

                                if (formelem.find('.has-error').length) {
                                    return false;
                                }

                                $.ajax({
                                    url: url,
                                    type: "POST",
                                    data: postData,
                                    dataType: 'json',
                                    success: function (data) {
                                        if (data.success == '1') {
                                            $(formelem).trigger('reset');
                                            $modal.modal('hide');
                                            toastr.success("Allowed SRN updated successfully.");
                                            $.pjax.reload({container: '#userDataList', timeout: false});
                                            $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
                                                 UserController.allowedgrievance();
                                                 UserController.viewTargetLogs();
                                            });
                                            
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
        },
        viewTargetLogs: function () {
            $('.viewTargetLogs').on('click', function (e) {
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
                            $('#viewTargetLogsModel').html(data.template);
                            $('#viewTargetLogsModel').modal('show');
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
         
    };
}(jQuery));

UserController.Summary = (function ($) {
    var attachEvents = function () { 
        LocationApiController.getDistrict();
        
        $('#userform-role_id').on('change', function (e) {
            e.preventDefault();
            var elem = $(this);

            var roleId = elem.val();
            if (roleId == '4') {
                $('.discomRole').removeClass('hide');
            } else {
                $('.discomRole').addClass('hide');
                $('userform-discom_id').val('').trigger('chosen:updated');
            }
        });
        
        $('.addLocation').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);

            var roleId = $("#userform-role_id option:selected").val();
            if (roleId === "") {
                $.fn.General_ShowNotification({type: 'error', message: "User role cannot be blank."});
                return;
            }

            var state = $(".state option:selected").val();
            if (state === "") {
                $.fn.General_ShowNotification({type: 'error', message: "State cannot be blank."});
                return;
            }
            
            var userGuid = $('#userform-guid').val();
            if(typeof userGuid === "undefined" || userGuid === "") {
               $.fn.General_ShowNotification({message: "Invalid request."});
               return;
            } 
            
            var district = $(".district option:selected").val();
            if (roleId == '4' && district === "") {
               $.fn.General_ShowNotification({type: 'error', message: "District cannot be blank."});
               return; 
            }
            

            $.ajax({
                url: baseHttpPath+'/user/add-permission',
                type: "POST",
                data: {userGuid: userGuid, stateCode: state, districtCode: district, _csrf: yii.getCsrfToken()},
                dataType: 'json',
                success: function (data) {
                    $('.table').removeClass('hide');
                    var total = $('#locationTable tr').length;
                    if (roleId == '2' || roleId == '3' || roleId == '10') {
                        
                        $('.stateUserPermission').append(
                                '<tr>' +
                                '<td>' + (parseInt(total)) + '</td>' +
                                '<td>' + data.stateName + '</td>' +
                                '<td><a href="javascript:void(0)" class="revokePermission icons icons__delete" data-id="' + data.id + '"><i class="fa fa-trash"></i></a></td></tr>');
                    } else if (roleId == '4' || roleId == '5' || roleId == '6') {
                        
                        $('.stateUserPermission').append(
                                '<tr>' +
                                '<td>' + (parseInt(total)) + '</td>' +
                                '<td>' + data.stateName + '</td>' +
                                '<td>' + data.districtName + '</td>' +
                                '<td><a href="javascript:void(0)" class="revokePermission icons icons__delete" data-id="' + data.id + '"><i class="fa fa-trash"></i></a></td></tr>');

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    $(elem).prop('disabled', true).html('Please Wait...');
                },
                complete: function (jqXHR, textStatus) {
                    $(elem).prop('disabled', false).html('Add');
                }
            });
        });
        
        
        $('.stateUserPermission').on('click', '.revokePermission', function (e) {
            e.preventDefault();
            var elem = $(this);
            var id = elem.data('id');
            var userGuid = $('#userform-guid').val();
            if (typeof userGuid === "undefined" || userGuid === "" || typeof id === "undefined" || id === "") {
                $.fn.General_ShowNotification({message: "Invalid request."});
                return;
            }

            bootbox.confirm({
                title: "Confirm",
                message: 'Do you really want to revoke user permission?',
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'button blue small'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button grey small'
                    }
                },
                callback: function (result) {
                    if (result == true) {
                        $.ajax({
                            url: baseHttpPath + '/user/revoke-permission',
                            type: "POST",
                            data: {userGuid: userGuid, id: id, _csrf: yii.getCsrfToken()},
                            dataType: 'json',
                            success: function (data) {
                               $(elem).closest('tr').remove();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $().General_ShowErrorMessage({message: jqXHR.responseText});
                            },
                            beforeSend: function (jqXHR, settings) {
                                $(elem).find('.fa').removeClass('fa-trash').addClass('fa-spin fa-spinner');
                            },
                            complete: function (jqXHR, textStatus) {
                                $(elem).find('.fa').addClass('fa-trash').removeClass('fa-spin fa-spinner');
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