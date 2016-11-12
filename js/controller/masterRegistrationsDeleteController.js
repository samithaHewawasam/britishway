app.controller('masterRegistrationsDeleteController', ['$scope', '$filter', 'Ajax', function($scope, $filter, Ajax) {

function masterRegistrations(){

  this.reg_no = "";

}

$scope.master_registrations = new masterRegistrations();

$scope.deletemaster_registrations = function(data){

  Ajax.post({
    "url"   : "php/master_registrations/delete.php",
    "data"  : data
  }).then(function(response){

    if(response.commit == 1){
      alert("Deleted");
      $scope.master_registrations = new masterRegistrations();
    }else{
      alert("Error found");
    }

  });

};

}]);
