var app = angular.module('exam_module', ['ngRoute', 'ngCookies', 'ngAnimate', 'mgcrea.ngStrap', 'daterangepicker']);

app.run(['$rootScope', '$route', function($rootScope, $route) {
    $rootScope.$on('$routeChangeSuccess', function() {
      $rootScope.title = $route.current.title;
    });

    $rootScope.exportData = function () {


          var blob = new Blob([document.getElementById('excel_export').innerHTML], {
              type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
          });
          saveAs(blob, "Report.xls");

   };

}]);
