app.controller('masterPaymentsController', ['$scope', '$rootScope', '$location', 'Ajax', 'getData', '$modal', function($scope, $rootScope, $location, Ajax, getData, $modal) {


function Payment(){

  this.master_reg_id = "";
  this.pay_type = 1;
  this.receipt = "";
  this.cash_amount = "";
  this.cheque_amount = "";
  this.credit_amount = "";
  this.bank_amount = "";
  this.pay_date = (new Date()).toISOString().substring(0, 10);
  this.cheque_bank_name = "";
  this.cheque_reference = "";
  this.credit_bank_name = "";
  this.credit_reference = "";
  this.diposits_bank_name = "";
  this.diposits_reference = "";
  this.receipt_show = false;
  this.receipt_display = [];
}


$scope.master_payments = new Payment();

if (getData.hasOwnProperty('reg_no') && typeof getData.reg_no !== 'undefined') {

  $scope.master_payments.master_reg_id  = getData.reg_no.data[0].id;
  $scope.master_payments.master_reg_no  = getData.reg_no.data[0].reg_no;
  $scope.master_payments.name_initials  = getData.reg_no.data[0].name_initials;
  $scope.master_payments.due  = getData.reg_no.data[0].due;



}else if(getData.hasOwnProperty('new_receipt')){

  $scope.master_payments.master_reg_no = getData.new_receipt.data[0].new_receipt.substring(0, 2);

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

$scope.getThePayInfo = function(data){

  if(data.length != 11){
    return;
  }

  Ajax.get({
    "url": "php/master_payments/findRegNoByRegNo.php",
    "data": {
      'reg_no': data
    }
  }).then(function(response) {

    $scope.master_payments.master_reg_id  = response.reg_no.data[0].id;
    $scope.master_payments.master_reg_no  = response.reg_no.data[0].reg_no;
    $scope.master_payments.name_initials  = response.reg_no.data[0].name_initials;
    $scope.master_payments.due  = response.reg_no.data[0].due;
  });

};

$scope.savemaster_payments = function(data){

  Ajax.post({
    "url"   : "php/master_payments/add.php",
    "data"  : data
  }).then(function(response){

    if(response.commit  == 1){
      //window.location = "#payments_add";
      //$scope.master_payments = new Payment();
      $scope.master_payments.receipt_show = true;
      $scope.master_payments.receipt_display = response.data[0];
      $scope.master_payments.branch_name = response.branch_name;
    }else{
      alert(response.error_alert);
    }

  });

}

$scope.payTypeCheck = function(pay_type){

$scope.master_payments.pay_type = pay_type;

}


}]);
