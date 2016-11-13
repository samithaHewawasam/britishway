module.exports = function(grunt) {

  grunt.initConfig({
    uglify: {
      my_target: {
        files: {
          'dist/britishway.min.js': ['bower_components/angular/angular.js',
          'bower_components/angular-route/angular-route.js',
          'bower_components/angular-cookies/angular-cookies.js',
          'bower_components/jquery/dist/jquery.js',
          'bower_components/bootstrap/dist/js/bootstrap.js',
          'bower_components/angular-animate/angular-animate.js',
          'bower_components/angular-strap/dist/angular-strap.js',
          'bower_components/angular-strap/dist/angular-strap.tpl.js',
          'bower_components/moment/moment.js',
          'bower_components/bootstrap-daterangepicker/daterangepicker.js',
          'bower_components/angular-daterangepicker/js/angular-daterangepicker.js',
          'bower_components/angular-loading-bar/build/loading-bar.js',
          'js/app.js',
          'js/service/*.js',
          'js/controller/*.js',
          'js/directive/*.js'        ]
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.registerTask('default', ['uglify']);

};
