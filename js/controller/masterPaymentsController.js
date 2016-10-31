app.controller('masterPaymentsController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {


function Payment(){

  this.master_reg_id = "";
  this.pay_type = 1;
  this.receipt = "";
  this.amount = "";
  this.pay_date = "";
  this.bank_name = "";
  this.reference = "";

}


$scope.master_payments = new Payment();

if (getData.hasOwnProperty('reg_no')) {

  $scope.master_payments.master_reg_id  = getData.reg_no.data[0].id;
  $scope.master_payments.master_reg_no  = getData.reg_no.data[0].reg_no;

}

if (getData.hasOwnProperty('new_receipt')) {

  $scope.master_payments.receipt  = getData.new_receipt.data[0].new_receipt;

}

$scope.findReceipt = function(pay_date){

  Ajax.get({
    "url": "php/master_payments/findReceipt.php",
    "data": {
      'pay_date': pay_date
    }
  }).then(function(response) {

    $scope.master_payments.receipt  = response.new_receipt.data[0].new_receipt;

  });

}


$scope.payTypeCheck = function(pay_type){

$scope.master_payments.pay_type = pay_type;
console.log(pay_type);

}

}]);
