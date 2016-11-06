app.controller('reportSearchController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {


function Search(){
  this.registration = [];
  this.installments = [];
  this.payments     = [];
  this.getPayType  = function (id){
      if(id == 1){
        return "Cash";
      }else if(id == 2){
        return "Cheque";
      }else if(id == 3){
        return "Credit/Debit Card";
      }else if(id == 4){
        return "Bank Deposits";
      }
    }
}

$scope.search = new Search();

if(typeof getData.registration !== 'undefined'){
  $scope.search.registration = getData.registration.data;
}
if(typeof getData.installments !== 'undefined'){
  $scope.search.installments = getData.installments.data;
}
if(typeof getData.payments !== 'undefined'){
  $scope.search.payments = getData.payments.data;
}



}]);
