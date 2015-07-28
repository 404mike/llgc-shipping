'use strict';

/**
 * @ngdoc function
 * @name shippingApp.controller:ShipCtrl
 * @description
 * # ShipCtrl
 * Controller of the shippingApp
 */
angular.module('shippingApp')
  .controller('ShipCtrl', function ($http,$scope,$routeParams) {


    if($routeParams.id == ''){
      $scope.data = '';
    }else{
      $http.get('/api/v1/shipslogbook?id='+$routeParams.id).
      success(function(data, status, headers, config) {
        $scope.data = data;
      }).
      error(function(data, status, headers, config) {
      });     
    }


  });
