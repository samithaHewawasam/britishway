app.controller('addController', ['$scope', 'dataService', '$filter', 'Ajax', 'getData', function($scope, dataService, $filter, Ajax, getData) {

$scope.courses_filter = getData.courses.data;
$scope.atis = getData.atis.data;
$scope.subjects = getData.subjectsDetail.data;

$scope.saveati = function(){

  Ajax.post({
    "url"   : "php/add.php",
    "data"  : $scope.ati
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      window.location.reload();

      $scope.ati = {};
    }else{
      alert("Error found");
    }

  });

};

$scope.savecourses = function(){

  Ajax.post({
    "url"   : "php/add.php",
    "data"  : $scope.courses
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      window.location.reload();

      $scope.courses = {};
    }else{
      alert("Error found");
    }

  });

};

$scope.savesubjects = function(subject_data){

  Ajax.post({
    "url"   : "php/add.php",
    "data"  : $scope.subject_data
  }).then(function(response){

    if(response.commit == 1){
      alert("Added");
      window.location.reload();
      $scope.subjects = {};
    }else{
      alert("Error found");
    }

  });

};

$scope.deleteAti = function(id){

  var c = confirm("Are you sure?");

  if(!c){
    return true;
  }

  Ajax.post({
    "url"   : "php/deleteAti.php",
    "data"  : {'id' : id }
  }).then(function(response){

    if(response.commit == 1){
      alert("Deleted");
      window.location.reload();
    }else{
      alert("Error found");
    }

  });

};

$scope.deleteCourse = function(id){

  var c = confirm("Are you sure?");

  if(!c){
    return true;
  }

  Ajax.post({
    "url"   : "php/deleteCourse.php",
    "data"  : {'id' : id }
  }).then(function(response){

    if(response.commit == 1){
      alert("Deleted");
      window.location.reload();
    }else{
      alert("Error found");
    }

  });

};

$scope.deleteSubject = function(id){

  var c = confirm("Are you sure?");

  if(!c){
    return true;
  }

  Ajax.post({
    "url"   : "php/deleteSubject.php",
    "data"  : {'id' : id }
  }).then(function(response){

    if(response.commit == 1){
      alert("Deleted");
      window.location.reload();
    }else{
      alert("Error found");
    }

  });

};


}]);
