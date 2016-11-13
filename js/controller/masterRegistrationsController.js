app.controller('masterRegistrationsController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

  if (getData.hasOwnProperty('courses')) {
    $scope.courses = getData.courses.data;
  }

  function MasterRegistrations() {
    this.reg_no = "";
    this.discount = 0;
    this.reg_date = (new Date()).toISOString().substring(0, 10);
    if (getData.hasOwnProperty('student_id')) {
      this.student_id = getData.student_id.data[0].student_id;
    }
    this.full_or_ins = 0;
  }
  $scope.master_registrations = new MasterRegistrations();

  $scope.getLastRegNo = function(course_id) {

    Ajax.post({
      "url": "php/master_registrations/getLastRegNoAndBatches.php",
      "data": {
        'course_id': course_id
      }
    }).then(function(response) {

      $scope.master_registrations = new MasterRegistrations();
      $scope.master_registrations.course_id = course_id;

      if (response.registrations.data.length >= 1) {
        $scope.master_registrations.reg_no = response.registrations.data[0].reg_no;
      } else {
        $scope.master_registrations.reg_no = "";
      }

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

    });

  };

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
      if (response.hasOwnProperty('fee_installments')) {
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


      if (response.hasOwnProperty('fee_installments')) {
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
        alert(response.error_alert);
      }

   });

  };


/*
  $scope.$watch('master_registrations.discount', function(newValue, oldValue) {

    if (typeof newValue == "undefined") {
      newValue = 0;
    }

    if (typeof oldValue == "undefined") {
      oldValue = 0;
    }

    if ($scope.master_registrations.full_or_ins == 0) {

      var remains = newValue - oldValue;

      for (var i = $scope.fee_installments_array.length - 1; i >= 0; i--) {
        if ($scope.fee_installments[i].amount == 0) {
          $scope.fee_installments.splice(i, 1);
        } else if ($scope.fee_installments_array[i].amount >= remains) {
          $scope.fee_installments_array[i].amount -= remains;
          break;
        }

      }

    }

  });

  */

}]);
