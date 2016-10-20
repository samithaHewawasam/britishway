app.service("user", function('Ajax', $rootScope) {

  this.info = function(user_id) {

    var responseData = {};

    Ajax.get({
      "url": "user/info",
      "data": {
        "user_id": user_id
      }
    }).then(function(response) {
      responseData = response;
    });

    return responseData;

  });
});
