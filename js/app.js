var app = angular.module('exam_module', ['ngRoute', 'ngCookies', 'ngAnimate', 'mgcrea.ngStrap']);
app.filter('subjects', function() {

return function(input, course_id) {
  var subjects = [];
    for (var i = 0; i < input.length; i++) {
      if(input[i].course == course_id){
        subjects.push({
          "id" : input[i].id,
          "subject_name" : input[i].subject_name
        });
      }
    }

  return subjects;

  }
});

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
