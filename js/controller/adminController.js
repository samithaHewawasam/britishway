app.controller('adminController', ['$scope', 'dataService', '$filter', 'getData', 'Ajax', '$rootScope', function($scope, dataService, $filter, getData, Ajax, $rootScope) {

$scope.courses = getData.courses.data;
$scope.subjects = getData.subjects.data;
$rootScope.menus = dataService.get().menus;

$scope.courseSelect = function(course_id){
  $scope.subjects = $filter('subjects')(getData.subjects.data, course_id);
};

$scope.savesubject_panel = function(panel){

  Ajax.post({
    "url"   : "php/panel.php",
    "data"  : panel
  }).then(function(response){

    if(response.commit == 1){
      alert("Updated");
      window.location.reload();

      $scope.subject_panel = "";
    }else{
      alert("Error found");
    }

  });

};

}]);
