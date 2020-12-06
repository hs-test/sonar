
var DashboardController = (function ($) {
    return {
        summary: function () {
            DashboardController.Summary.init();
        },
        graph: function (labels, pending , resolved)
        {
            Highcharts.chart('GrievancesMonthWise', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grievances Report Month Wise'
                },
                xAxis: {
                    categories: labels
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Grievances'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        }
                    }
                },
                series: [
                    {
                        name: 'Pending',
                        data: pending,
                        color: '#5cdb42'
                    },
                    {
                        name: 'Resolved',
                        data: resolved,
                        color: '#fd9309'
                    }
                ]
            });
        },
    };
}(jQuery));

DashboardController.Summary = (function ($) {
    var attachEvents = function () {

    };

    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));