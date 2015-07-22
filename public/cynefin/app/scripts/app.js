'use strict';

/**
 * @ngdoc overview
 * @name cynefinApp
 * @description
 * # cynefinApp
 *
 * Main module of the application.
 */
angular
  .module('cynefinApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'cynefin/app/views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'main'
      })
      .when('/about', {
        templateUrl: 'cynefin/app/views/about.html',
        controller: 'AboutCtrl',
        controllerAs: 'about'
      })
      .when('/test', {
        templateUrl: 'cynefin/app/views/test.html',
        controller: 'TestCtrl',
        controllerAs: 'test'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
