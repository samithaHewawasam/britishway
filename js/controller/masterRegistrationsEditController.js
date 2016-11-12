app.controller('masterRegistrationsEditController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

  if (getData.hasOwnProperty('courses')) {
    $scope.courses = getData.courses.data;
  }

function Registration(){
}

$scope.master_registrations  = new Registration();

$scope.coursesAndBatches = function(course_id) {

  Ajax.get({
    "url": "php/master_registrations/coursesAndBatches.php",
    "data": {
      'course_id': course_id
    }
  }).then(function(response) {

    if (response.batches.data.length >= 1) {
      $scope.batches = response.batches.data;
    } else {
      $scope.batches = "";
    }

    if (response.fee_structures.data.length >= 1) {
      $scope.fee_structures = response.fee_structures.data;
    } else {
      $scope.master_registrations.fee_structures = "";
    }

    $scope.master_registrations = getData.registration;

  });

};

$scope.coursesAndBatches(getData.registration.course_id);



  $scope.findByFeeStructureId = function(id) {

    Ajax.post({
      "url": "php/master_registrations/findByFeeStructureId.php",
      "data": {
        'fee_id': id,
        'fullOrIns': $scope.master_registrations.full_or_ins
      }
    }).then(function(response) {

      if (response.hasOwnProperty('fee_structure')) {
        $scope.master_registrations.fee = response.fee_structure.data[0].gross;
        $scope.master_registrations.reg_fee = response.fee_structure.data[0].registration_fee;
      }
      if ($scope.master_registrations.fullOrIns == 0 && response.hasOwnProperty('fee_installments')) {
        $scope.master_registrations.fee_installments = response.fee_installments.data;
      }

    });

  };

  $scope.fullOrInsCheck = function(fullOrIns) {

    $scope.master_registrations.full_or_ins = fullOrIns;
    $scope.master_registrations.fee_installments = [];

    if (!$scope.master_registrations.fee_id) {
      alert("Please select the fee structure");

      return;
    }

    Ajax.post({
      "url": "php/master_registrations/findByFeeStructureId.php",
      "data": {
        'fee_id': $scope.master_registrations.fee_id,
        'fullOrIns': fullOrIns
      }
    }).then(function(response) {

      if (response.hasOwnProperty('fee_structure')) {
        $scope.master_registrations.fee = response.fee_structure.data[0].gross;
        $scope.master_registrations.reg_fee = response.fee_structure.data[0].registration_fee;
        }


      if (fullOrIns == 0 && response.hasOwnProperty('fee_installments')) {
        $scope.master_registrations.fee_installments = response.fee_installments.data;
      }

    });

  };


  $scope.savemaster_registrations = function(data){

    data.student_master_id = $location.search().id;

    Ajax.post({
      "url": "php/master_registrations/add.php",
      "data": data
    }).then(function(response) {

      if(response.commit  == 1){
        $scope.master_registrations = new MasterRegistrations();
        alert("Saved");
        window.location = "#payments_add?id="+response.last_insert_id;
      }else{
        alert("Error");
      }

   });

  };

}]);
