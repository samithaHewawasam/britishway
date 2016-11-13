app.config(function($routeProvider, $locationProvider) {

//$locationProvider.html5Mode(true);
    $routeProvider
        .when('/', {
            title: 'Dashboard',
            templateUrl: 'views/index.html',
            controller: 'indexController'
        })
        .when('/search', {
            title: 'Search',
            templateUrl: 'views/reports/search.html',
            controller: 'reportSearchController',
            resolve: {
                getData: function($location, searchService) {
                    return searchService.get($location.search().r);
                }
            }
        })
        .when('/income', {
            title: 'Income',
            templateUrl: 'views/reports/income.html',
            controller: 'reportIncomeController',
            resolve: {
                getData: function(ReportDefaultService) {
                    return ReportDefaultService.get();
                }
            }
        })
        .when('/batch_wise', {
            title: 'Batch Wise',
            templateUrl: 'views/reports/batch_wise.html',
            controller: 'reportBatchWiseController',
            resolve: {
                getData: function(ReportDefaultService) {
                    return ReportDefaultService.get();
                }
            }
        })
        .when('/registrations', {
            title: 'Registrations',
            templateUrl: 'views/reports/registrations.html',
            controller: 'reportRegistrationsController',
            resolve: {
                getData: function(ReportDefaultService) {
                    return ReportDefaultService.get();
                }
            }
        })
        .when('/dues', {
            title: 'Dues',
            templateUrl: 'views/reports/dues.html',
            controller: 'reportDuesController',
            resolve: {
                getData: function(ReportDefaultService) {
                    return ReportDefaultService.get();
                }
            }
        })
        .when('/students_add', {
            title: 'Students',
            templateUrl: 'views/master_students/add.html',
            controller: 'masterStudentsController'
        })
        .when('/registrations_add', {
            title: 'Registrations',
            templateUrl: 'views/master_registrations/add.html',
            controller: 'masterRegistrationsController',
            resolve: {
                getData: function($location, RegistrationService) {
                    return RegistrationService.get($location.search().id);
                }
            }
        })
        .when('/registrations_edit', {
            title: 'Registrations',
            templateUrl: 'views/master_registrations/edit.html',
            controller: 'masterRegistrationsEditController',
            resolve: {
                getData: function($location, RegistrationEditService, BatchService, $q ) {
                    return $q.all([RegistrationEditService.get($location.search().r), BatchService.get()]).then(function(results){

                      return {
                         'registration' : results[0].registration.data[0],
                         'installments' : results[0].installments.data[0],
                         'courses' : results[1].courses,
                         'reg_no' : $location.search().r
                      };
                  });
                }
            }
        })
        .when('/students_edit', {
            title: 'Students Edit',
            templateUrl: 'views/master_students/edit.html',
            controller: 'masterStudentsEditController',
            resolve: {
                getData: function($location, StudentEditService) {
                    return StudentEditService.get($location.search().s);
                }
            }
        })
        .when('/registrations_delete', {
            title: 'Registration Delete',
            templateUrl: 'views/master_registrations/delete.html',
            controller: 'masterRegistrationsDeleteController'
        })
        .when('/payments_delete', {
            title: 'Payment Delete',
            templateUrl: 'views/master_payments/delete.html',
            controller: 'masterPaymentsDeleteController'
        })
        .when('/payments_add', {
            title: 'Payments',
            templateUrl: 'views/master_payments/add.html',
            controller: 'masterPaymentsController',
            resolve: {
                getData: function($location, PaymentService, ReceiptService, $q) {

                  return $q.all([PaymentService.get($location.search().id), ReceiptService.get()]).then(function(results){

                    return {
                       'reg_no' : results[0].reg_no,
                       'new_receipt' : results[1].new_receipt
                    };
                });
            }
          }
        })
        .when('/batch_add', {
            title: 'Batches',
            templateUrl: 'views/master_batches/add.html',
            controller: 'masterBatchesController',
            resolve: {
                getData: function(BatchService) {
                    return BatchService.get();
                }
            }
        })
        .when('/batch_edit', {
            title: 'Batch Edit',
            templateUrl: 'views/master_batches/edit.html',
            controller: 'masterBatchesController',
            resolve: {
                getData: function($location, BatchEditService, BatchService, $q) {

                  return $q.all([BatchEditService.get($location.search().id), BatchService.get()]).then(function(results){

                    return {
                       'edit_batch' : results[0].edit_batch,
                       'courses' : results[1].courses,
                       'edit_batch_id' : $location.search().id
                    };
                });
            }
          }
        })
        // If 404
        .otherwise({
            redirectTo: '/'
        });
});
