app.config(function($routeProvider, $locationProvider) {

//$locationProvider.html5Mode(true);

    $routeProvider
        .when('/', {
            title: 'Dashboard',
            templateUrl: 'views/index.html',
            controller: 'masterStudentsController'
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
