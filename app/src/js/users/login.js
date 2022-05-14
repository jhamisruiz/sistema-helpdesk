var login = angular.module('export-Login-users', []);

login.controller('ctrLogin', function ($scope, $http, $window) {
    $scope.error = '';
    $scope.loginOK = '';

    $scope.LoginFunc = function () {
        $scope.error = '';
        $scope.loginOK = '';
        var form = $scope.login;
        var formt = new FormData();
        formt.append('loginUsers', JSON.stringify(form));
        formt.append('formulario', 'LOGIN');
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/usuarios',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            let sms = response.data;
            if (sms['login'] == 'OK') {
                $scope.loginOK = sms['sms'];
                $window.sessionStorage.setItem('user', JSON.stringify(sms['user']));
                window.location.reload();
            }
            if (sms['login'] == 'ERROR') {
                $scope.error = sms['sms'];
            }
            
        },
            function error(response) { alertify.error('Error: al iniciar'); }
        );
    }
});


try {
    var data = JSON.parse(sessionStorage.getItem('user'));
    var idnames = document.getElementById('idnames');
    var iduser_ses = document.getElementById('iduser_ses');
    var idnames_last = document.getElementById('idnames_last');
    idnames.innerHTML=data['names'];
    iduser_ses.innerHTML = data['user_name'];
    idnames_last.innerHTML = data['names'] + '<br>' + data['last_name'];

    function closeSession() {
        sessionStorage.removeItem("user");
    }
} catch (error) {
    
}