app.controller('masterStudentsController', ['$scope', '$filter', 'Ajax', function($scope, $filter, Ajax) {

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
