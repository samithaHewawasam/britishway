app.controller('masterRegistrationsController', ['$scope', 'dataService', '$filter', 'Ajax', 'getData', function($scope, dataService, $filter, Ajax, getData) {

$scope.courses = getData.courses.data;

function MasterRegistrations(){
  this.reg_no = "";
  this.student_id = getData.student_id.data[0].student_id;
  this.full_or_ins = 1;
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

      if(response.fee_structures.data.length == 1){
        $scope.fee_structures = response.fee_structures.data;
      }else{
        $scope.master_registrations.fee_structures = "";
      }

  });

};

$scope.findByFeeStructureId = function(id){

  Ajax.post({
    "url"   : "php/master_registrations/findByFeeStructureId.php",
    "data"  : { 'fee_id' : id, 'fullOrIns' : $scope.master_registrations.full_or_ins }
  }).then(function(response){

    $scope.master_registrations.fee = response.fee_structure.data[0].gross;
    $scope.master_registrations.reg_fee = response.fee_structure.data[0].registration_fee;
    if($scope.master_registrations.fullOrIns == 0){
      $scope.fee_installments = response.fee_installments.data;
    }

  });

};

$scope.fullOrInsCheck = function(fullOrIns){

  $scope.master_registrations.full_or_ins = fullOrIns;

if(!$scope.master_registrations.fee_id){
  alert("Please select the fee structure");
  return;
}

  Ajax.post({
    "url"   : "php/master_registrations/findByFeeStructureId.php",
    "data"  : { 'fee_id' : $scope.master_registrations.fee_id, 'fullOrIns' : fullOrIns }
  }).then(function(response){

    $scope.master_registrations.fee = response.fee_structure.data[0].gross;
    $scope.master_registrations.reg_fee = response.fee_structure.data[0].registration_fee;
    if(fullOrIns == 0){
      $scope.fee_installments = response.fee_installments.data;
    }

  });

};

}]);
