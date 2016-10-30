app.service('dataService', function() {

  var data = {};

  return {
    get: function() {

      return data;

    },
    set: function(value) {
      Object.assign(data, value);
    }
  };

});


app.service('RegistrationService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function(id) {

    return Ajax.get({
      "url": "php/master_registrations/registrations.php",
      "data": { 'id' :id }
    });

  };

}]);

app.service('BatchService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function() {

    return Ajax.get({
      "url": "php/master_batches/courses.php",
      "data": null
    });

  };

}]);


app.service('getReportService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function(report) {

    return Ajax.get({
      "url": "php/"+report+".php",
      "data": authoService.isLogged()
    });

  };

}]);

app.service('getSatDataService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function(id) {

    return Ajax.get({
      "url": "php/sat_data.php",
      "data": { 'id' : id }
    });

  };

}]);
