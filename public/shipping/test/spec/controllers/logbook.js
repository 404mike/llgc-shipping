'use strict';

describe('Controller: LogbookCtrl', function () {

  // load the controller's module
  beforeEach(module('shippingApp'));

  var LogbookCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    LogbookCtrl = $controller('LogbookCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(LogbookCtrl.awesomeThings.length).toBe(3);
  });
});
