app.directive('focusMe', function ($timeout, $parse) {
    return {
        restrict:"A",
        scope:false,
        link: function (scope, element, attrs) {
          element[0].focus();
        }
    };
});
