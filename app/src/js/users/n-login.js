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
                window.location.assign('/');
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
    var idnames_last = document.getElementsByClassName('idnames_last');

    idnames.innerHTML=data['names'];
    iduser_ses.innerHTML = data['user_name'];

    for (let i = 0; i < idnames_last.length; i++) {
        idnames_last[i].innerHTML = data['names'] + '<br>' + data['last_name'];
        
    }

    function closeSession() {
        sessionStorage.removeItem("user");
    }
} catch (error) {
    
}


var sign = angular.module('app-SignUp', []);

sign.controller('ctrSign', function ($scope, $http, $window){
    $scope.Crear = { names: null, fecha_registro: null, last_name: null, phone: null, rep_password: null, password: null, user_name: null, email: null };
    $scope.confirm='';
    $scope.guardarUser= function(){
        var form = $scope.crear, p = new Date();
        console.log(form)
        form['names'] ='';
        form['last_name'] = '';
        form['fecha_registro'] = p.toDateString();

        var formt = new FormData();
        formt.append('usuarios', JSON.stringify(form));
        formt.append('formulario', 'USERS');
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/usuarios',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            $scope.confirm =response.data;
            alertify.success(response.data);
            window.location.assign('/login');
        },
            function error(response) { alertify.error('Error: al iniciar'); }
        );
    }
});