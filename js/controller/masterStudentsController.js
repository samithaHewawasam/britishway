app.controller('masterStudentsController', ['$scope', 'dataService', '$filter', 'Ajax', 'getData', function($scope, dataService, $filter, Ajax, getData) {

$scope.save = function(data){

  Ajax.post({
    "url"   : "php/master_students/add.php",
    "data"  : data
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      //window.location.reload();

    }else{
      alert("Error found");
    }

  });

};

}]);
