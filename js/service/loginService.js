app.service('loginService', ['Ajax', function(Ajax) {

  this.login = function(login) {

    return Ajax.post({
      "url"   : "php/login.php",
      "data"  : login
    });

  };


}]);
