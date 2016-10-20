app.service('authoService', ['$cookies', '$location', function($cookies, $location) {

  this.set = function(user) {

    var loggedIn = new Date();
    user.loggedIn = loggedIn.toUTCString();
    $cookies.put("loggedIn", true);
    $cookies.put("user_id", user.user_id.$id);
    $cookies.put("user_name", user.user_name);
    $cookies.put("lastLogDate", user.loggedIn);

  };

  this.isLogged = function() {

    return ($cookies.get("loggedIn")) ? $cookies.getAll() : false;

  };
  
  this.logout = function(){

  	return $cookies.remove("loggedIn") &&  $cookies.remove("user_id") &&  $cookies.remove("user_name") && $cookies.remove("lastLogDate") && $location.path("/") && true;
  
  } 

}]);
