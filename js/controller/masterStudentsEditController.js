app.controller('masterStudentsEditController', ['$scope', 'getData', 'Ajax', function($scope, getData, Ajax) {

$scope.master_students = getData.student.data[0];

}]);
