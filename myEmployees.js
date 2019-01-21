angular.module('myApp', []).controller('employeeCtrl', function($scope) {
  $scope.edit = true;
  $scope.hideform = true;
  $scope.firstName = '';
  $scope.companyId = '';
  $scope.lastName = '';
  $scope.hidebox = true;
  $scope.incomplete = true;

$scope.moreDependents = [{employeeId: '0', firstName: 'firstName', lastName: 'lastName', age: 'age'}];
  $scope.createNewEmployee = function(){
    $scope.hideform = false;
    $scope.hidebox = true;
    $scope.hidesubmit = true;
    $scope.edit = true;
    $scope.companyId = '';
    $scope.firstName = '';
    $scope.lastName = '';
    $scope.numDep = '';
    $scope.incomplete = true;
  };

  $scope.$watch('companyId', function() {$scope.checkNotEmpty();});
  $scope.$watch('firstName', function() {$scope.checkNotEmpty();});
  $scope.$watch('lastName', function() {$scope.checkNotEmpty();});

  $scope.checkNotEmpty = function() {
    if ($scope.firstName == '' && $scope.lastName == '' && $scope.companyId == '') {
      $scope.incomplete = true;
      } else {
      $scope.incomplete = false;
    }
  };

  $scope.addDependents = function() {
    var newDependent = $scope.moreDependents.length+1;
    $scope.moreDependents.push({'employeeId' : '0' + newDependent, 'firstName' : 'firstName' + newDependent, 'lastName' : 'lastName' + newDependent, 'age' : 'age' + newDependent });
  };

});
