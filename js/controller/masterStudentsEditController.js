app.controller('masterStudentsEditController', ['$scope', 'getData', 'Ajax', function($scope, getData, Ajax) {

if(getData.error_alert){
  alert(getData.error_alert);
  return;
}

$scope.master_students = getData.student.data[0];

$scope.save = function(data){

  Ajax.post({
    "url"   : "php/master_students/edit.php",
    "data"  : data
  }).then(function(response){

    if(response.commit == 1){
      alert("Saved");
    }else{
      alert(response.error_alert);
    }

  });

};

}]);
