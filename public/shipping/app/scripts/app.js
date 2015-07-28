'use strict';

/**
 * @ngdoc overview
 * @name shippingApp
 * @description
 * # shippingApp
 *
 * Main module of the application.
 */
angular
  .module('shippingApp', [
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
        templateUrl: 'shipping/app/views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'main'
      })
      .when('/about', {
        templateUrl: 'shipping/app/views/about.html',
        controller: 'AboutCtrl',
        controllerAs: 'about'
      })
      .when('/test', {
        templateUrl: 'shipping/app/views/test.html',
        controller: 'TestCtrl',
        controllerAs: 'test'
      })
      .when('/browse/:char?', {
        templateUrl: 'shipping/app/views/browse.html',
        controller: 'BrowseCtrl',
        controllerAs: 'browse'
      })
      .when('/ship:id?', {
        templateUrl: 'shipping/app/views/ship.html',
        controller: 'ShipCtrl',
        controllerAs: 'ship'
      })
      .when('/logbook:id?', {
        templateUrl: 'shipping/app/views/logbook.html',
        controller: 'LogbookCtrl',
        controllerAs: 'logbook'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
