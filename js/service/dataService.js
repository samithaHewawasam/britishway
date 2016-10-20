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


app.service('getDataService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function() {

    return Ajax.get({
      "url": "php/filters.php",
      "data": authoService.isLogged()
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
