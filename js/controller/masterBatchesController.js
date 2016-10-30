app.controller('masterBatchesController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

  $scope.courses = getData.courses.data;

  function masterBatches(){
    this.batch_course_id = "";
    this.batch_code = "";
    this.batch_commence = "";
    this.batch_end = "";
    this.batch_intake = "";
  }

  $scope.master_batches = new masterBatches();

  if(getData.hasOwnProperty('edit_batch')){
    $scope.master_batches.id = getData.edit_batch_id;
    $scope.master_batches.batch_course_id = getData.edit_batch.data[0].batch_course_id;
    $scope.master_batches.batch_code =  getData.edit_batch.data[0].batch_code;
    $scope.master_batches.batch_commence =  getData.edit_batch.data[0].batch_commence;
    $scope.master_batches.batch_end =  getData.edit_batch.data[0].batch_end;
    $scope.master_batches.batch_intake =  getData.edit_batch.data[0].batch_intake;
  }


  $scope.courseSelect = function(course_id){

    Ajax.get({
      "url"   : "php/master_batches/batch_list.php",
      "data"  : { 'course_id' : course_id }
    }).then(function(response){

      $scope.master_batches = new masterBatches();
      $scope.master_batches.batch_course_id = course_id;
      $scope.batches = response.batches.data;
      $scope.master_batches.batch_code = response.new_batch.data[0].batch_code;

    });

  }

  $scope.savemaster_batches = function(data){

    Ajax.post({
      "url"   : "php/master_batches/add.php",
      "data"  : data
    }).then(function(response){

      $scope.batches.unshift({
        "batch_code" : $scope.master_batches.batch_code,
        "batch_commence" : $scope.master_batches.batch_commence,
        "batch_end" : $scope.master_batches.batch_end,
        "batch_intake" : $scope.master_batches.batch_intake,
        "id" : response.last_insert_id,
      });

      $scope.master_batches = new masterBatches();

    });

  }

  $scope.editmaster_batches = function(data){

    Ajax.post({
      "url"   : "php/master_batches/editSave.php",
      "data"  : data
    }).then(function(response){

      $scope.master_batches = new masterBatches();

    });

  }

  $scope.delete = function(id, index){

    var c = confirm("Are you sure?");
    if(!c){
      return;
    }

    Ajax.get({
      "url"   : "php/master_batches/delete.php",
      "data"  : { 'id' : id }
    }).then(function(response){

      if(response.commit  == 1){
        $scope.batches.splice(index, 1)
      }else{
        alert("Error");
      }

    });

  }

}]);
