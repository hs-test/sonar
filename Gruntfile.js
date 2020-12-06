module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        //Minify JS
        uglify: {
            options: {
                mangle: false
            },
            product: {
                files: {
                    "frontend/web/static/dist/deploy/app.min.js": [
                        "frontend/web/static/dist/js/jquery.min.js",
                        "frontend/web/static/dist/js/moment.js",
                        "frontend/web/static/dist/js/scripts.min.js",
                        "frontend/web/static/dist/js/prettify.js",
                        "frontend/web/static/dist/js/jscolor.js",
                        "frontend/web/static/dist/js/app.js",
                        "frontend/web/static/dist/vendors/bootstrap/js/bootstrap.min.js",
                        "frontend/web/static/dist/vendors/bootstrap-modal.js",
                        "frontend/web/static/dist/vendors/bootstrap-modalmanager.js",
                        "frontend/web/static/dist/vendors/chosen-bootstrap/js/chosen.jquery.min.js",
                        "frontend/web/static/dist/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js",
                        "frontend/web/static/dist/vendors/bootstrap-daterangepicker/moment.min.js",
                        "frontend/web/static/dist/vendors/bootstrap-daterangepicker/daterangepicker.js",
                        "frontend/web/static/dist/vendors/jquery.switchery/js/switchery.js",
                        "frontend/web/static/dist/vendors/jquery.nicescroll/js/jquery.nicescroll.min.js",
                        "frontend/web/static/dist/vendors/multiselect-bootstrap/js/bootstrap-select.js",
                        "frontend/web/static/dist/vendors/bootbox.min.js",
                        "frontend/web/static/dist/vendors/jquery.noty-2.3.8/js/noty/packaged/jquery.noty.packaged.min.js",
                        "frontend/web/static/dist/vendors/jquery.tipped/js/tipped.js",
                        "frontend/web/static/dist/vendors/highcharts/highcharts.js",
                        "frontend/web/static/dist/vendors/dropzone/dropzone.js",
                        "frontend/web/static/dist/vendors/owlcarousel/js/owl.carousel.js",
                        "frontend/web/static/dist/vendors/handlebars-v4.0.5.js",
                        "frontend/web/static/dist/vendors/toaster/toastr.min.js",
                        "frontend/web/static/dist/vendors/map-responsive/js/jquery.rwdImageMaps.js",
                        "frontend/web/static/dist/js/waypoints.min.js",
                        "frontend/web/static/dist/js/jquery.counterup.min.js",
                        "frontend/web/static/dev/js/common/common.js",
                        "frontend/web/static/dev/js/common/app.js",
                        "frontend/web/static/dev/js/common/location.js",
                        "frontend/web/static/dev/js/common/user.js",
                        "frontend/web/static/dev/js/common/flash-message.js",
                        "frontend/web/static/dev/js/common/upload-file.js",
                        "frontend/web/static/dev/js/page/page.js",
                        "frontend/web/static/dev/js/slider/slider.js",
                        "frontend/web/static/dev/js/module/module.js",
                        "frontend/web/static/dev/js/news/news.js",
                        "frontend/web/static/dev/js/grievance/grievance.js",
                        "frontend/web/static/dev/js/company/company.js",
                        "frontend/web/static/dev/js/listtype/listtype.js",
                        "frontend/web/static/dev/js/financialyear/financial_year.js",
                        "frontend/web/static/dev/js/common/discom.js",
                        "frontend/web/static/dev/js/message-template/message-template.js",
                        "frontend/web/static/dev/js/location/location-cascade.js",
                        "frontend/web/static/dev/js/location/state.js",
                        "frontend/web/static/dev/js/location/district.js",
                        "frontend/web/static/dev/js/location/block.js",
                        "frontend/web/static/dev/js/location/panchayat.js",
                        "frontend/web/static/dev/js/location/village.js",
                        "frontend/web/static/dev/js/type/type.js",
                        "frontend/web/static/dev/js/dashboard/dashboard.js",
                        "frontend/web/static/dev/js/common/templates.js",
                    ]
                }
            },
//            frontend: {
//                files: {
//                    "frontend/web/static/frontend/dist/deploy/app.min.js": [
//                        "frontend/web/static/frontend/static/plugins/jquery/js/jquery.min.js",
//                        "frontend/web/static/frontend/static/plugins/bootstrap/js/popper.min.js",
//                        "frontend/web/static/frontend/static/plugins/bootstrap/js/bootstrap.min.js",
//                        "frontend/web/static/frontend/static/plugins/newsticker/js/jquery.vticker-min.js",
//                        "frontend/web/static/frontend/static/plugins/slick/js/slick.min.js",
//                        "frontend/web/static/frontend/static/plugins/fancybox/js/jquery.fancybox.js",
//                        "frontend/web/static/frontend/static/js/app.js",
//                        "frontend/web/static/dev/js/location/location-cascade.js",
//                        "frontend/web/static/dev/js/grievance/grievance.js"
//                    ]
//                }
//            }
        },
        cachebreaker: {
            prod: {
                options: {
                    match: ['app.min.js', 'output.min.css']
                },
                files: {
                    src: [
                        'frontend/modules/admin/views/layouts/partials/_scripts.php',
                        'frontend/modules/admin/views/layouts/main.php',
                       // 'frontend/views/layouts/partials/_scripts.php',
                      //  'frontend/views/layouts/main.php'
                    ]
                }
            }
        },
        //Minify Css Files
        cssmin: {
            options: {
                // processImport: false,
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            product: {
                files: {
                    'frontend/web/static/dist/deploy/output.min.css': [
                        "frontend/web/static/dist/css/vendor.css",
                        "frontend/web/static/dist/css/prettify.css",
                        "frontend/web/static/dist/vendors/dropzone/css/dropzone.css",
                        "frontend/web/static/dist/vendors/toaster/toastr.css",
                        "frontend/web/static/dist/vendors/multiselect-bootstrap/dist/css/bootstrap-select.min.css",
                        "frontend/web/static/dist/vendors/fancybox/dist/jquery.fancybox.min.css",
                        "frontend/web/static/dist/vendors/bootstrap-daterangepicker/daterangepicker.css",
                        "frontend/web/static/dist/css/default.css"
                    ]
                }
            },
//            frontend: {
//                files: {
//                    'frontend/web/static/frontend/dist/deploy/output.min.css': [
//                        'frontend/web/static/frontend/dist/css/vendor.css',
//                        'frontend/web/static/frontend/dist/css/default.css'
//                    ]
//                }
//            }
        },
        sass: {// Task
            dist: {// Target
                options: {// Target options
                    //style: 'compressed'
                    compress: false,
                    sourcemap: 'none'
                },
                files: {// Dictionary of files
                    'frontend/web/static/frontend/static/css/default.css': 'frontend/web/static/frontend/static/css/sass/default.scss',
                    'frontend/web/static/frontend/static/css/vendors.css': 'frontend/web/static/frontend/static/css/sass/vendors.scss',
                    'frontend/web/static/dist/css/default.css': 'frontend/web/static/dist/sass/default.scss',
                    'frontend/web/static/dist/css/vendor.css': 'frontend/web/static/dist/sass/vendors.scss'
                }
            }
        },
        watch: {
            css: {
                files: [
                    'frontend/web/static/frontend/static/css/sass/**/*.scss',
                    'frontend/web/static/dist/sass/**/*.scss'
                ],
                tasks: ['sass'],
                options: {
                    spawn: false,
                    livereload: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-cache-breaker');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-sass');

    // Default task(s).
    grunt.registerTask('default', ['uglify', 'cssmin', 'cachebreaker']);
};