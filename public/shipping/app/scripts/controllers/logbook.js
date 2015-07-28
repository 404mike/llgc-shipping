'use strict';

/**
 * @ngdoc function
 * @name shippingApp.controller:LogbookCtrl
 * @description
 * # LogbookCtrl
 * Controller of the shippingApp
 */
angular.module('shippingApp')
  .controller('LogbookCtrl', function ($http,$scope,$routeParams) {

    if($routeParams.id == ''){
      $scope.data = '';
    }else{
      $http.get('/api/v1/logbook?id='+$routeParams.id).
      success(function(data, status, headers, config) {
        $scope.data = data;
      }).
      error(function(data, status, headers, config) {
      });     
    }

    $scope.getCrewPicture = function(){
      return Math.floor(Math.random() * 11) + 1  
    };

  });
