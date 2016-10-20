app.config(function($routeProvider, $locationProvider) {

//$locationProvider.html5Mode(true);

    $routeProvider

        .when('/addati', {
            title: 'Add ATI',
            templateUrl: 'views/addAti.html',
            controller: 'addController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        .when('/addcourse', {
            title: 'Add Course',
            templateUrl: 'views/addCourse.html',
            controller: 'addController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        .when('/addsubject', {
            title: 'Add Subject',
            templateUrl: 'views/addSubject.html',
            controller: 'addController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        .when('/admin', {
            title: 'Admin',
            templateUrl: 'views/admin.php',
            controller: 'adminController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        .when('/report1', {
            title: 'Report',
            templateUrl: 'views/report1.php',
            controller: 'reportController',
            resolve: {
                getData: function(getReportService) {
                    return getReportService.get("report1");
                }
            }
        })
        .when('/report2', {
            title: 'Course Wise Summary',
            templateUrl: 'views/report2.php',
            controller: 'reportController',
            resolve: {
                getData: function(getReportService) {
                    return getReportService.get("report2");
                }
            }
        })
        .when('/report3', {
                    title: 'ATI Wise In Detail',
                    templateUrl: 'views/report3.php',
                    controller: 'reportController',
                    resolve: {
                        getData: function(getReportService) {
                            return getReportService.get("report3");
                        }
                    }
        })
        .when('/report4', {
                    title: 'ATI Wise Summary',
                    templateUrl: 'views/report4.php',
                    controller: 'reportController',
                    resolve: {
                        getData: function(getReportService) {
                            return getReportService.get("report4");
                        }
                    }
        })
        .when('/report5', {
                    title: 'Panel Wise Summary',
                    templateUrl: 'views/report5.php',
                    controller: 'reportController',
                    resolve: {
                        getData: function(getReportService) {
                            return getReportService.get("report5");
                        }
                    }
        })
        .when('/logout', {
            title: 'Logout',
            templateUrl: 'views/login.php',
            controller: 'accsessController'
        })
        .when('/', {
            title: 'Dashboard',
            templateUrl: 'views/add_students.html',
            controller: 'indexController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        .when('/addstudents', {
            title: 'Add no of Answer Scripts',
            templateUrl: 'views/addanswer.html',
            controller: 'indexController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        .when('/more', {
            title: 'More Information',
            templateUrl: 'views/moreInfo.html',
            controller: 'moreInfoController',
            resolve: {
                getId: function($location, getSatDataService) {
                  return getSatDataService.get($location.search().id);
                }
            }
        })
        .when('/assign1', {
            title: 'Assign Course to ATI',
            templateUrl: 'views/setCourseToAti.html',
            controller: 'indexController',
            resolve: {
                getData: function(getDataService) {
                  return getDataService.get();
                }
            }
        })
        .when('/assign2', {
            title: 'Assign Subject to Course',
            templateUrl: 'views/setSubjectToCourse.html',
            controller: 'indexController',
            resolve: {
                getData : function(getDataService) {
                  return getDataService.get();
                }
            }
        })
        // If 404
        .otherwise({
            redirectTo: '/'
        });
});
