/**
 * Created by demo on 19-Sep-14.
 */

var app =   angular.module('firstApp', ['ngRoute']);

app.config(['$routeProvider', function($routeProvider){

    $routeProvider.
        when('/', {templateUrl: 'views/list.html'}).
        otherwise(
            {redirectTo: '/'}
        )
}]);

app.controller('listCtrl',  function($scope){
    $scope.subject  =   [
        {name:'mobile', property:'calling'},
        {name:'mouse', property:'pointer'},
        {name:'keyboard', property:'typing'},
        {name:'screen', property:'view'}
    ]
});

app.controller('editCtrl', function ($scope, $routeParams) {

})



