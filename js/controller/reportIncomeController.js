app.controller('reportIncomeController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

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

      this.getPayType  = function (id){
          if(id == 1){
            return "Cash";
          }else if(id == 2){
            return "Cheque";
          }else if(id == 3){
            return "Credit/Debit Card";
          }else if(id == 4){
            return "Bank Deposits";
          }
        }

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
      "url": "php/report/income.php",
      "data": {
        'startDate': newVal.date.startDate.toDate(),
        'endDate':  newVal.date.endDate.toDate(),
        'course_id' : newVal.course_id,
        'batch_id' : newVal.batch_id
      }
    }).then(function(response) {

      for(var pt in response){

        response[pt].payTypeTotal = 0;

        for(var ot in response[pt]){

          response[pt][ot].operatorTotal = 0;

          for(var ts = 0; ts < response[pt][ot].length; ts++){
            response[pt].payTypeTotal += parseFloat(response[pt][ot][ts].amount);
            response[pt][ot].operatorTotal += parseFloat(response[pt][ot][ts].amount);
          }

        }

      }

      $scope.incomes = response;


    });

  });


}]);
