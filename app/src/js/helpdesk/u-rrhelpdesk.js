var ordenes = angular.module('app-helpdesk', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
ordenes.controller('ctrHelpdesk', function ($scope, $http, $timeout) {
    $scope.form = { "message": '', "id_cliente": null, "id_helpdesk": null, "prioridad": null, };
    $scope.listChats = [];
    $scope.listPrioridad = [];
    $scope.userNames = '';
    $scope.userid = 0;
    $scope.listf2fChat = [];
    $scope.idchat = 0;
    $scope.idcliento = 0;
    $scope.sendmsm = function () {
        let form = $scope.form;
        var data = JSON.parse(sessionStorage.getItem('user'));
        let chtclient = $scope.listf2fChat;
        if (form.message) {
            form.id_cliente = chtclient[0].id_cliente
            form.prioridad = chtclient[0].prioridad
            form.id_helpdesk = data.id
            var formt = new FormData();
            formt.append('data', JSON.stringify(form));
            formt.append('formulario', 'POSTRESPUESTA');
            $http({
                method: 'POST',
                url: window.location.origin + '/v1/helpdesk-chat',
                data: formt,
                headers: { 'Content-Type': undefined }
            }).then(function success(response) {
                $scope.scrollChatBottom();
                $scope.f2fChat(chtclient[0].id_cliente);
                $scope.form.message = '';
            }
            );
        }
    }
    angular.element(window.document.body).ready(function () {
        let data = JSON.parse(sessionStorage.getItem('user'));
        $scope.userid = data['id']
        listaChat();
        prioridad();
        $scope.scrollChatBottom();
    });
    var prioridad = function () {
        $http.get(window.location.origin + '/v1/helpdesk-chat/0?length=prioridad&search=' + $scope.userid).then(function (result) {
            var c = result.data;
            $scope.listPrioridad = c
            $timeout(prioridad, 500);
        });
    }
    var listaChat = function () {
        $http.get(window.location.origin + '/v1/helpdesk-chat/0?length=lsChat&search=' + $scope.userid).then(function (result) {
            var c = result.data;
            $scope.listChats = c
        });
        $timeout(listaChat, 500);
    }
    $scope.f2fChat = function (id) {
        $scope.idcliento = id
        f2fChatGuardar();
    }
    var f2fChatGuardar = function () {
        let id = $scope.idcliento
        let identi = 0;
        if (identi == 3) {
            identi = 0;
        } else {
            if (id) {
                $http.get(window.location.origin + '/v1/helpdesk-chat/' + id + '?length=lsf2dChat&search=' + id).then(function (result) {
                    var c = result.data;
                    $scope.listf2fChat = c
                    $scope.userNames = c[0].razon_social + '-' + c[0].names + '' + c[0].last_name
                    $scope.scrollChatBottom($scope.identi);
                });
            }
        }
        $timeout(f2fChatGuardar, 500);
    }
    $scope.identi = 0;
    $scope.funcin = function (i){
        $scope.identi = 0;
    }
    $scope.scrollChatBottom = function (c) {
        //$scope.identi = 0;
        if ($scope.identi > 3) {
            $scope.identi = c;
        } else {
            $scope.identi = $scope.identi + 1;
            var objDiv = document.getElementById("messageschat");
            objDiv.scrollTop = objDiv.scrollHeight;
        }
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

    $scope.otraArea = function (i) {
        var id = $scope.idchat;
        var formt = new FormData();
        formt.append('data', JSON.stringify({ id: id, id_area: i }));
        formt.append('formulario', 'OTROS');
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/helpdesk-chat',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            alertify.success("OK: se derivo el chat");
        },
            function error(response) { alertify.error("ERROR: no se derivo el chat."); }
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
    function derivando(i) {
        angular
            .element(document.querySelector('[ng-controller="ctrHelpdesk"]'))
            .scope()
            .otraArea(i);
    }
} catch (error) {
    //error
}

function hsscrollChatBottom() {
    angular
        .element(document.querySelector('[ng-controller="ctrHelpdesk"]'))
        .scope()
        .funcin(0); //actualizar precio
    var objDiv = document.getElementById("messageschat");
    objDiv.scrollTop = objDiv.scrollHeight;
}