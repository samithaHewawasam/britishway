app.controller('masterRegistrationsController', ['$scope', 'dataService', '$filter', 'Ajax', 'getData', function($scope, dataService, $filter, Ajax, getData) {

$scope.courses = getData.courses.data;

function MasterRegistrations(){
  this.reg_no = "";
}

$scope.master_registrations = new MasterRegistrations();


$scope.getLastRegNo = function(course_id){

  Ajax.post({
    "url"   : "php/master_registrations/getLastRegNoAndBatches.php",
    "data"  : { 'course_id' : course_id }
  }).then(function(response){

      if(response.registrations.data.length == 1){
        $scope.master_registrations.reg_no = response.registrations.data[0].reg_no;
      }else{
        $scope.master_registrations.reg_no = "";
      }
      
      if(response.batches.data.length == 1){
        $scope.batches = response.batches.data;
      }else{
        $scope.batches = "";
      }

  });

};

}]);
