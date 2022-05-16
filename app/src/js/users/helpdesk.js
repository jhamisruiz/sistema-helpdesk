var ordenes = angular.module('app-helpdesk', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
ordenes.controller('ctrHelpdesk', function ($scope, $http) {
    $scope.form = { "message": '',"send":null};

    $scope.sendmsm=function(){
        $scope.form.send = $scope.form.message;
        $scope.form.message='';
    }
});