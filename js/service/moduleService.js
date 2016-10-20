app.service('moduleService', ['$http', '$q', function($http, $q) {

  this.functions = function(login) {

    var defer = $q.defer();

    $http({
        method: 'GET',
        url: "index/login",
        params: login
      }).success(function(response) {
        defer.resolve(response);
      })
      .error(function(response) {
        defer.reject(response);
      });

    return defer.promise;

  };


}]);
