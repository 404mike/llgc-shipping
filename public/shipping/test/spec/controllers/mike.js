'use strict';

describe('Controller: MikeCtrl', function () {

  // load the controller's module
  beforeEach(module('shippingApp'));

  var MikeCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    MikeCtrl = $controller('MikeCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(MikeCtrl.awesomeThings.length).toBe(3);
  });
});
