'use strict';

var citationGeneratorFilters = angular.module('citationGeneratorFilters', []);

citationGeneratorFilters.filter("generateCitation", function () {
    // value - данные для которых применяется фильтр
    // toUpper - аргумент передаваемый фильтру
    return function (value, styleName) {
        // проверка переменной value на наличие строки
        if (angular.isObject(value)) {
            if (styleName == 'style1') {
                var processedValue = value.field1 + ' ' + value.field2;
                return processedValue;
            }
        } else {
            return value;
        }
    };
});