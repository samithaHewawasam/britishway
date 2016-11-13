app.controller('masterStudentsController', ['$scope', '$filter', 'Ajax', function($scope, $filter, Ajax) {

$scope.save = function(data){

  Ajax.post({
    "url"   : "php/master_students/add.php",
    "data"  : data
  }).then(function(response){

    if(response.commit == 1 && response.last_insert_id != 0){
      window.location = "#registrations_add?id="+response.last_insert_id;
    }else if(response.last_insert_id == 0){
      alert("Error");
    }else{
      alert(response.error_alert);
    }

  });

};

}]);
