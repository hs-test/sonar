var LocationApiController = (function ($) {
    return {
        getVillage: function () {
            $('.district').on('change', function (e) {
                e.preventDefault();
                var elem = $(this);
                var districtCode = elem.val();
                if (districtCode === "") {
                    $(".village").val('');
                    $(".village").trigger("chosen:updated");
                    return;
                }

                $.ajax({type: 'post',
                    url: baseHttpPath + '/api/location/get-village',
                    dataType: 'json',
                    data: {districtCode: districtCode, _csrf: yii.getCsrfToken()},
                    success: function (data, textStatus, jqXHR) {
                        if (data.success == "1") {
                            $('.village').html(data.template);
                            $(".village").trigger("chosen:updated");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $().ShowFlashMessages({type: 'error', message: jqXHR.responseText});
                    },
                    beforeSend: function (jqXHR, settings) {
                        $().showScreenLoader();
                    },
                    complete: function (jqXHR, textStatus) {
                        $().hideScreenLoader();
                    }
                });
            });
        },
        getDistrict: function () {
            $('.state').on('change', function (e) {
                e.preventDefault();
                var elem = $(this);
                var stateCode = elem.val();
                if (stateCode === "") {
                    $(".district").val('');
                    $(".district").trigger("chosen:updated");
                    return;
                }
                
                var userGuid = '';
                var roleId = $("#userform-role_id option:selected").val();
                if (roleId === "5" || roleId === "6") {
                    userGuid = $('#userform-guid').val();
                }
 
                $.ajax({type: 'post',
                    url: baseHttpPath + '/api/location/get-district',
                    dataType: 'json',
                    data: {stateCode: stateCode, userGuid: userGuid, _csrf: yii.getCsrfToken()},
                    success: function (data, textStatus, jqXHR) {
                        if (data.success == "1") {
                            $(".district").html(data.template);
                            $(".district").trigger("chosen:updated");
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