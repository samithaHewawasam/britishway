app.controller('accsessController', ['$scope', '$location', '$rootScope', '$cookies', function($scope, $location, $rootScope, $cookies) {
	$cookies.put('loggedIn', false);
	$cookies.remove('loggedIn');

	//after logout user redirect to home page
	$location.path('views/index.html');

}]);
