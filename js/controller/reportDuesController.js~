app.controller('reportDuesController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

  function Report(){

    this.course_id = "";
    this.batch_id = "";

    this.date = {
      startDate: moment(),
      endDate: moment()
    };

    this.setRanges = {
      ranges : {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      };

  }

    $scope.report = new Report();

  if (getData.hasOwnProperty('courses') && getData.hasOwnProperty('batches')) {
    $scope.courses = getData.courses.data;
    $scope.batches = getData.batches.data;
  }

  $scope.findBatchByCourseId = function(course_id){

    Ajax.get({
      "url": "php/report/findBatchByCourseId.php",
      "data": {
        'course_id': course_id
      }
    }).then(function(response) {

      if (typeof response.batches !== 'undefined') {
        $scope.batches = response.batches.data;
      } else {
        $scope.batches = "";
      }


    });

  }

  $scope.$watchCollection('report', function(newVal, oldVal){

    Ajax.post({
      "url": "php/report/dues.php",
      "data": {
        'startDate': newVal.date.startDate.toDate(),
        'endDate':  newVal.date.endDate.toDate(),
        'course_id' : newVal.course_id,
        'batch_id' : newVal.batch_id
      }
    }).then(function(response) {

      if(typeof response.dues !== "undefined"){

        $scope.dues = [];
        $scope.dues = response.dues.data;
        $scope.dues.total = 0;

        for(var i = 0; i < response.dues.data.length; i++){

          $scope.dues.total += parseInt(response.dues.data[i].upto);

        }

      }

    });

  });


}]);
