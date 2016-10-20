app.service('Ajax', ['$http', '$q', 'authoService', function($http, $q, authoService) {

var Ajax = {};

Ajax.post = function(data){

  var defer = $q.defer();

  $http({
      method: 'POST',
      url: data.url,
      data: data.data
    }).success(function(response) {
      defer.resolve(response);
    })
    .error(function(response) {
      defer.reject(response);
    });

  return defer.promise;

};

Ajax.get = function(data){

  var defer = $q.defer();

  $http({
      method: 'GET',
      url: data.url,
      params: data.data
    }).success(function(response) {
      defer.resolve(response);
    })
    .error(function(response) {
      defer.reject(response);
    });

  return defer.promise;

};

return Ajax;

}]);
