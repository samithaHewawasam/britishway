app.controller('loginController', ['$scope', 'loginService', '$location', 'dataService', '$rootScope', function($scope, loginService, $location, dataService, $rootScope) {

$rootScope.location = $location;

  $scope.loginForm = function(data) {

    loginService.login(data).then(function(response) {

      if (response == 'null') {

        alert("Invalid username or password");

      } else {

      	dataService.set({ 'menus' : response });
        $location.path("home");


      }

    });
  };



}]);
