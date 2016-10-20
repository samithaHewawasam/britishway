app.controller('moreInfoController', ['$scope', 'dataService', '$filter', 'getId', 'Ajax', '$rootScope', function($scope, dataService, $filter, getId, Ajax, $rootScope) {

$rootScope.menus = dataService.get().menus;
$scope.sats = getId.sat.data;

}]);
