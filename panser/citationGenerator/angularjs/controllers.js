'use strict';

var citationGeneratorControllers = angular.module('citationGeneratorControllers', []);

citationGeneratorControllers.controller('DefaultController', ['$scope', function($scope) {

    $scope.data = {
        url: {
            form: 'angularjs/partials/include/form.html'
        }
    };

    $scope.clickHandler = function () {
        alert('HI!!!');
    }

}]);

citationGeneratorControllers.controller('FormController', ['$scope', function($scope) {

}]);
