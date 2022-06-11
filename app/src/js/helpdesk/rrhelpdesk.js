var ordenes = angular.module('app-helpdesk', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
ordenes.controller('ctrHelpdesk', function ($scope, $http, $timeout) {
    $scope.form = { "message": '', "send": null };
    $scope.listChats = [];
    $scope.listPrioridad=[];
    $scope.userNames = '';
    $scope.listf2fChat = [];
    $scope.idchat = 0;

    $scope.sendmsm = function () {
        $scope.form.send = $scope.form.message;
        $scope.form.message = '';
    }
    angular.element(window.document.body).ready(function () {
        listaChat();
        prioridad();
    });
    var prioridad = function () {
        $http.get(window.location.origin + '/v1/helpdesk-chat/0?length=prioridad&search=').then(function (result) {
            var c = result.data;
            $scope.listPrioridad = c
            $timeout(prioridad, 500);
        });
    }
    var listaChat = function () {
        $http.get(window.location.origin + '/v1/helpdesk-chat/0?length=lsChat&search=').then(function (result) {
            var c = result.data;
            $scope.listChats = c
            $timeout(listaChat, 500);
        });
    }
    $scope.f2fChat = function (id) {
        $http.get(window.location.origin + '/v1/helpdesk-chat/' + id + '?length=lsf2dChat&search=' + id).then(function (result) {
            var c = result.data;
            $scope.listf2fChat = c
            $scope.userNames = c[0].razon_social + '-' + c[0].names + '' + c[0].last_name
        });
    }

    $scope.hacerCritico = function (i) {
        var id = $scope.idchat;
        var formt = new FormData();
        formt.append('data', JSON.stringify({ id: id, prioridad: i }));
        formt.append('formulario', 'POSTC');
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/helpdesk-chat',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            alertify.success("OK: se agrego el chat como critico:" + response.data + "");
        },
            function error(response) { alertify.error("ERROR: no se agrego el chat."); }
        );
    }

    ////////////////
    $scope.isVisible = false;

    $scope.hideMenu = function () {
        document.getElementById(
            "contextMenu").style.display = "none";
    }
    $scope.rightClick = function (e) {
        $scope.idchat = parseInt(e.target.id);
        e.preventDefault();
        if (document.getElementById(
            "contextMenu").style.display == "block")
            hideMenu();
        else {
            var menu = document
                .getElementById("contextMenu")

            menu.style.display = 'block';
            menu.style.left = e.pageX + "px";
            menu.style.top = e.pageY + "px";
        }
    }

});
ordenes.directive("ngContextmenu", function () {
    contextMenu = { replace: false };
    contextMenu.restrict = "AE";

    contextMenu.scope = { "visible": "=" };
    contextMenu.link = function ($scope, lElem, lAttr) {
        lElem.on("contextmenu", function (e) {

            e.preventDefault();

            angular
                .element(document.querySelector('[ng-controller="ctrHelpdesk"]'))
                .scope().rightClick(e);

            $scope.$apply(function () {
                $scope.visible = true;
            })



        });
    };
    return contextMenu;
});


try {
    document.onclick = hideMenu;
    function hideMenu() {
        document.getElementById("contextMenu").style.display = "none"
    }

    function enviando(i) {
        angular
            .element(document.querySelector('[ng-controller="ctrHelpdesk"]'))
            .scope()
            .hacerCritico(i);
    }
} catch (error) {
    //error
}

