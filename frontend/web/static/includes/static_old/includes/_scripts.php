<!-- Begin Core Plugins -->
<script type="text/javascript" src="dist/vendors/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="dist/vendors/bootstrap/js/bootstrap.min.js"></script>
<!-- End Core Plugins -->

<!-- Begin Page Level Plugins -->
<script type="text/javascript" src="dist/vendors/chosen-bootstrap/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="dist/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="dist/vendors/jquery.switchery/js/switchery.js"></script> 
<script type="text/javascript" src="dist/vendors/jquery.nicescroll/js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="dist/vendors/chosen-bootstrap/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="dist/vendors/multiselect-bootstrap/js/bootstrap-select.js"></script>
<script type="text/javascript" src="dist/vendors/jquery.tipped/js/tipped.js"></script>
<script type="text/javascript" src="dist/vendors/bootbox.min.js"></script>
<script type="text/javascript" src="dist/vendors/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="dist/vendors/highcharts/js/highcharts-3d.js"></script>
<script type="text/javascript" src="dist/vendors/highcharts/js/highcharts-more.js"></script> 
<!-- End Page Level Plugins -->
<script type="text/javascript" src="dist/js/app.js"></script>

<script>
    $('.bootboxBtn').click(function () {
        bootbox.confirm({
            title: "Confirm",
            message: "Do you really want to delete this call to action?",
            callback: function (result) {
                if (result === true) {
                    window.location = urlStr;
                }
            }
        });
    });
</script> 

<script type="text/javascript">
Highcharts.chart('chart-1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Average'
    },
    subtitle: {
        text: 'Source: source.com'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Counts'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} Records</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Total',
        color: '#fc9d43',
        data: [1500, 1600, 1550, 1800, 1608]

    }, {
        name: 'Approved',
        color: '#d8e667',
        data: [1350, 1400, 1500, 1650, 1600]

    }, {
        name: 'Pending',
        color: '#775cb0',
        data: [250, 200, 50, 150, 8]

    }, {
        name: 'Rejected',
        color: '#e7564e',
        data: [15, 12, 10, 05, 03]

    }]
});
</script>


<script type="text/javascript">
Highcharts.chart('chart-2', {
     chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Average'
    },
    subtitle: {
        text: 'Source: source.com'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Counts'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} Records</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Total',
        color: '#37a5c5',
        data: [1500, 1600, 1550, 1800, 1608]

    }, {
        name: 'Approved',
        color: '#d8e667',
        data: [1350, 1400, 1500, 1650, 1600]

    }, {
        name: 'Pending',
        color: '#775cb0',
        data: [250, 200, 50, 150, 8]

    }, {
        name: 'Rejected',
        color: '#e7564e',
        data: [15, 12, 10, 05, 03]

    }]
});
</script>