'use strict';

/**
 * @ngdoc function
 * @name shippingApp.controller:BrowseCtrl
 * @description
 * # BrowseCtrl
 * Controller of the shippingApp
 */
angular.module('shippingApp')
  .controller('BrowseCtrl', function ($http,$scope,$routeParams) {


    if($routeParams.char == ''){
      $scope.data = '';
    }else{
      $http.get('/api/v1/ships?char='+$routeParams.char).
      success(function(data, status, headers, config) {
        $scope.data = data;
      }).
      error(function(data, status, headers, config) {
      });     
    }
    
  });
