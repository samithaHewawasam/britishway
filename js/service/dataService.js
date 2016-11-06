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


app.service('PaymentService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function(id) {

    return Ajax.get({
      "url": "php/master_payments/findRegNoById.php",
      "data": {'id' : id}
    });

  };

}]);

app.service('ReceiptService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function() {

    return Ajax.get({
      "url": "php/master_payments/new_receipt.php",
      "data": null
    });

  };

}]);

app.service('BatchEditService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function(id) {

    return Ajax.get({
      "url": "php/master_batches/edit.php",
      "data": {'id' : id}
    });

  };

}]);

app.service('ReportDefaultService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function() {

    return Ajax.get({
      "url": "php/report/default.php",
      "data": null
    });

  };

}]);

app.service('searchService', ['Ajax', 'authoService', function(Ajax, authoService) {

  this.get = function(r) {

    return Ajax.get({
      "url": "php/report/search.php",
      "data": {'reg_no' : r }
    });

  };

}]);
