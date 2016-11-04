app.controller('reportIncomeController', ['$scope', 'dataService', '$location', 'Ajax', 'getData', function($scope, dataService, $location, Ajax, getData) {

  function Report(){

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
    }

  }

    $scope.report = new Report();

  if (getData.hasOwnProperty('courses') && getData.hasOwnProperty('batches')) {
    $scope.courses = getData.courses.data;
    $scope.batches = getData.batches.data;
  }

}]);
