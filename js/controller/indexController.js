app.controller('indexController', ['$scope', 'dataService', '$filter', 'getData', 'Ajax', '$rootScope', function($scope, dataService, $filter, getData, Ajax, $rootScope) {

$scope.courses = getData.courses.data;
$scope.atis = getData.atis.data;
$scope.subjects = getData.subjects.data;
$scope.student_sats = getData.student_sats.data;
$rootScope.menus = dataService.get().menus;
$scope.aticourses = getData.aticourses.data;

$scope.courseSelect = function(course_id){
  $scope.subjects = $filter('subjects')(getData.subjects.data, course_id);
};

$scope.savestudents_sat = function(sat){

  Ajax.post({
    "url"   : "php/satStatus.php",
    "data"  : sat
  }).then(function(response){

    if(response.commit == 1){
      alert("Updated");
      window.location.reload();

      $scope.students_sat = "";
    }else{
      alert("Error found");
    }

  });

};

$scope.saveati_courses = function(ati_courses){

  Ajax.post({
    "url"   : "php/add.php",
    "data"  : ati_courses
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      window.location.reload();
      $scope.students_sat = "";
    }else{
      alert("Error found");
    }

  });

};

$scope.delete = function(id){

  var c = confirm("Are you sure?");

  if(!c){
    return true;
  }

  Ajax.post({
    "url"   : "php/delete.php",
    "data"  : {'id' : id }
  }).then(function(response){

    if(response.commit == 1){
      alert("Deleted");
      window.location.reload();
    }else{
      alert("Error found");
    }

  });

};

}]);
