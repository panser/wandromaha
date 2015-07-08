/**
 * Created by Sergey on 7/8/2015.
 */

'use strict';

var citationGeneratorApp = angular.module('citationGeneratorApp', [
    ,'ngSanitize'
    ,'citationGeneratorServices'
    ,'citationGeneratorFilters'
    ,'citationGeneratorDirectives'
    ,'citationGeneratorControllers'
]);

citationGeneratorApp
    .config(['$locationProvider', function($locationProvider) {
        //$locationProvider.html5Mode(true);

    }])
;
