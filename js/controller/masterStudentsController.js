app.controller('masterStudentsController', ['$scope', 'dataService', '$filter', 'Ajax', 'getData', function($scope, dataService, $filter, Ajax, getData) {

$scope.courses_filter = getData.courses.data;
$scope.atis = getData.atis.data;
$scope.subjects = getData.subjectsDetail.data;

$scope.saveati = function(){

  Ajax.post({
    "url"   : "php/add.php",
    "data"  : $scope.ati
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      window.location.reload();

      $scope.ati = {};
    }else{
      alert("Error found");
    }

  });

};

}]);
