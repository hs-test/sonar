var SurveyController = (function ($) {
    return {
        summary: function () {
            SurveyController.Summary.init();
        }
    };
}(jQuery));

SurveyController.Summary = (function ($) {
    var attachEvents = function () {        
        StateController.initializeChozen();
        VleController.datePicker("#startdate");
        VleController.datePicker("#enddate");
        
        $('.export').click(function () {
            var querystring = window.location.search;
            window.location = '/admin/survey/export' + querystring;
        });
    };

    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));
