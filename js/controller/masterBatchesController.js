app.controller('masterBatchesController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

  $scope.courses = getData.courses.data;


  $scope.courseSelect = function(course_id){

    Ajax.get({
      "url"   : "php/master_batches/batch_list.php",
      "data"  : { 'course_id' : course_id }
    }).then(function(response){

      $scope.batches = response.batches.data;
      $scope.master_batches.batch_code = response.new_batch.data[0].batch_code;

    });

  }

  $scope.savemaster_batches = function(data){

    Ajax.post({
      "url"   : "php/master_batches/add.php",
      "data"  : data
    }).then(function(response){

    });

  }

}]);
