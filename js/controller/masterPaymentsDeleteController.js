app.controller('masterPaymentsDeleteController', ['$scope', '$filter', 'Ajax', function($scope, $filter, Ajax) {

function masterPayments(){

  this.receipt_no = "";

}

$scope.master_payments = new masterPayments();

$scope.deletemaster_payments = function(data){

  Ajax.post({
    "url"   : "php/master_payments/delete.php",
    "data"  : data
  }).then(function(response){

    if(response.commit == 1){
      alert("Deleted");
      $scope.master_payments = new masterPayments();
    }else{
      alert("Error found");
    }

  });

};

}]);
