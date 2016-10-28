app.controller('masterRegistrationsController', ['$scope', 'dataService', '$filter', 'Ajax', 'getData', function($scope, dataService, $filter, Ajax, getData) {

console.log(getData);

$scope.save = function(data){

  Ajax.post({
    "url"   : "php/master_students/add.php",
    "data"  : data
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      window.location = "#registrations_add";

    }else{
      alert("Error found");
    }

  });

};

}]);
