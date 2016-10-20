app.controller('reportController', ['$scope', 'dataService', '$filter', 'getData', 'Ajax', '$rootScope', function($scope, dataService, $filter, getData, Ajax, $rootScope) {

$scope.reports = getData.data;
$rootScope.menus = dataService.get().menus;

}]);
