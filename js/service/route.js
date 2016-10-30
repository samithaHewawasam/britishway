app.config(function($routeProvider, $locationProvider) {

//$locationProvider.html5Mode(true);

    $routeProvider

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
        // If 404
        .otherwise({
            redirectTo: '/'
        });
});
