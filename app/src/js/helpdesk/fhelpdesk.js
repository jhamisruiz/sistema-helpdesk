var ordenes = angular.module('app-helpdesk', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
ordenes.controller('ctrHelpdesk', function ($scope, $http, $timeout) {
    $scope.form = { "message": '', "send": null };
    $scope.listChats=[];
    $scope.userNames='';
    $scope.listf2fChat=[];
    $scope.sendmsm = function () {
        $scope.form.send = $scope.form.message;
        $scope.form.message = '';
    }
    angular.element(window.document.body).ready(function () {
        listaChat();
    });
    var listaChat = function () {
        $http({
            method: 'GET',
            url: window.location.origin + '/v1/helpdeskchat/0?length=clientes&search='
        }).then(function (result) {
            var c = result.data;
            $scope.listChats = c
            //$timeout(listaChat, 500);
        });
    }
    $scope.f2fChat = function (id) {
        $http({
            method: 'GET',
            url: window.location.origin + '/v1/helpdeskchat/' + id + '?length=lsf2dChat&search=' + id
        }).then(function (result) {
            var c = result.data;
            $scope.listf2fChat = c
            $scope.userNames = c[0].razon_social + '-' + c[0].names + '' + c[0].last_name
        });
    }

});