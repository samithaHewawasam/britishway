app.config(function($routeProvider, $locationProvider) {

//$locationProvider.html5Mode(true);

    $routeProvider

        .when('/students_add', {
            title: 'Students',
            templateUrl: 'views/master_students/add.html',
            controller: 'masterStudentsController',
            resolve: {
                getData: function(getDataService) {
                    return getDataService.get();
                }
            }
        })
        // If 404
        .otherwise({
            redirectTo: '/'
        });
});
