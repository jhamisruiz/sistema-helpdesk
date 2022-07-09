
var app = angular.module('usuarios-app', ['angularMoment', 'ngAnimate', 'ngSanitize', 'ui.bootstrap']);
app.service('httpCtrl', function ($http) {
    ///list
    this.selectUsuarios = function (length, search) {
        return $http({
            method: 'GET',
            url: window.location.origin + '/v1/usuarios/0?length=' + length + '&search=' + search,
        }).then(function success(response) {
            var res = response.data;
            for (let index = 0; index < res.length; index++) {
                res[index].index = (index + 1);
            }
            return res;
        },
            function error(response) { alertify.error(response.data); }
        );
    };
    ///select by id to edit
    this.getUsuario = function (id) {
        return $http({
            method: 'GET',
            url: window.location.origin + '/v1/usuarios/' + id,
        }).then(function success(response) { return response.data; },
            function error(response) { alertify.error(response.data); }
        );
    }
    ////POST
    this.postData = function (form) {
        return $http({
            method: 'POST',
            url: window.location.origin + '/v1/usuarios',
            data: form,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) { return response; },
            function error(response) { alertify.error(response.data); }
        );
    };
    //PUT
    this.putUsuario = function (form) {
        return $http({
            method: 'PUT',
            url: window.location.origin + '/v1/usuarios/?id=' + form['id'],
            data: form,
        }).then(function success(response) { return response; },
            function error(response) { alertify.error(response.data); }
        );
    }
    // activar Usuario PUT
    this.activarUsuario = function (data) {
        return $http({
            method: 'PUT',
            url: window.location.origin + '/v1/usuarios/?active=' + data['id'],
            data: data,
        }).then(function success(response) {
            return response;
        },
            function error(response) { alertify.error(response.data); }
        );
    }
    /// reset passwords PUT
    this.sendPassword = function (data) {
        return $http({
            method: 'PUT',
            url: window.location.origin + '/v1/usuarios/?rs=' + data['id'],
            data: data,
        }).then(function success(response) { return response; },
            function error(response) { alertify.error(response.data); }
        );
    }
    ////DELETE
    this.deleteusuario = function (id) {
        return $http({
            method: 'DELETE',
            url: window.location.origin + '/v1/usuarios',
            data: id,
        }).then(function success(response) { return response; },
            function error(response) { alertify.error(response.data); }
        );
    };

});
///////////////////////// CONTROLLER 1 /////////////////////////////
app.controller('listUsuariosC', function ($scope, $timeout, $http, httpCtrl) {
    $scope.usuariosLists = [];
    $scope.search = '';
    $scope.length = 5;
    $scope.permisos = [];
    $scope.iduser = 0;
    // funtion list
    var selectUsuariosList = function () {
        httpCtrl.selectUsuarios($scope.length, $scope.search).then(function (data) {
            $scope.totalItems = data.length;
            for (let i = 0; i < data.length; i++) {
                var arr = '[' + data[i]['permisos'] + ']';
                data[i]['permisos'] = JSON.parse(arr);
            }
            $scope.usuariosLists = data;
        })
    }
    $scope.usuarioPermisos = function (id) {
        $scope.iduser = id;
        $scope.permisos.length = 0;

        var usuarios = $scope.usuariosLists;

        function extrac(data) { return data.id === id; }

        let usuario = usuarios.find(extrac)

        var permiso = [], permisos = usuario['permisos'];
        var con = true;
        for (let i = 1; i < 5; i++) {
            con = true;
            if (permisos[0]) {
                for (let e = 0; e < permisos.length; e++) {
                    if (permisos[e]['id_permiso'] == i) {
                        permiso.push({ id_usuario: permisos[0]['id_usuario'], id_permiso: i });
                        con = false;
                    }
                }
            }
            if (con) {
                permiso.push({ id_usuario: id, id_permiso: 0 })
                con = true;
            }
        }
        $scope.permisos = permiso;
    };
    $scope.savePermisos = function (id) {

        var checked = [];
        $("input[name='permisos[]']:checked").each(function () {
            checked.push($(this).val());
        });

        var formt = new FormData();
        formt.append('permisos', JSON.stringify(checked));
        formt.append('id', id);
        formt.append('formulario', 'PERMISOS');
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/usuarios',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            alertify.success(response.data);
            $scope.length = 1000;
            selectUsuariosList();
        },
            function error(response) { alertify.error(response.data); }
        );
    }
    angular.element(window.document.body).ready(function () {
        $scope.length = 1000;
        selectUsuariosList();
    });
    // search
    $scope.searchUsuarios = function () {
        $timeout(selectUsuariosList, 300);
    };
    //modal edit by id
    $scope.editUsuario = function (id) {
        $scope.$broadcast("formLoadModal", 'true');// envia y activa 'spinner-border'
        httpCtrl.getUsuario(id).then(function (data) {
            $scope.$broadcast("getbyidUsuario", data); ///jala de controller child
        })
    }
    //activar usuario
    $scope.activarUsuario = function (id, s, i) {
        var act = { "id": id, "estado": s }
        httpCtrl.activarUsuario(act).then(function (data) {
            if (data.data == 'OK' || data.status == 200) {
                var users = $scope.usuariosLists;
                users[i.$index].estado = s;
                if (s == 1) {
                    Swal.fire({
                        position: 'middle',
                        icon: 'success',
                        title: 'El estado se ha activado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                if (s == 0) {
                    Swal.fire({
                        position: 'middle',
                        icon: 'warning',
                        title: 'El estado se ha desactivado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
            //data = activado
        })
    };

    $scope.openreset = function (id) {
        $scope.$broadcast("openreset", id); ///jala de controller child
    };

    //delete by id
    $scope.deleteUsuario = function (id) {
        Swal.fire({
            title: 'Está seguro?',
            text: "El Usuario se eliminara definitivamente!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#dd6b55',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                httpCtrl.deleteusuario(id).then(function (data) {
                    selectUsuariosList();
                    if (data.data == 'OK' || data.status == 200) {
                        Swal.fire({
                            position: 'middle',
                            icon: 'success',
                            title: 'OK: Usuario Eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }
        });
    }
    //------pagination-----///
    $scope.currentPage = 4;
    $scope.itemsPerPage = $scope.length;
    $scope.maxSize = 5; //Number of pager buttons to show

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.setItemsPerPage = function (num) {
        $scope.itemsPerPage = num;
        $scope.currentPage = 1; //reset to first page
    }
    //------pagination-----///

    /* =====EMIT - ON====== */
    $scope.$on("table-updated", function () {
        $scope.search = '';
        selectUsuariosList();
    });
    //reset form
    $scope.resetForm = function () {
        $scope.$broadcast("resetFormModal");
    }
});
///////////////////////// CONTROLLER 2 /////////////////////////////

app.controller('postUsuarios', function ($scope, $timeout, httpCtrl) {

    $scope.Usuario = { names: null, fecha_registro: null, last_name: null, phone: null, rep_password: null, password: null, user_name: null, email: null };
    $scope.button_edit = false;
    $scope.button_post = true;
    $scope.formLoad = false;

    $scope.postUsuarios = function () {
        var form = $scope.usuario, p = new Date();
        form['fecha_registro'] = p.toDateString();

        var formt = new FormData();
        formt.append('usuarios', JSON.stringify(form));
        formt.append('formulario', 'USERS');
        httpCtrl.postData(formt).then(function (data) {
            if (data.data == 'OK' || data.status == 200) {
                $scope.$emit("table-updated");//actuliza la tabla despues de guardar
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    title: 'OK: Usuario guardado',
                    showConfirmButton: false,
                    timer: 1500
                })
                $scope.reset();
            }
        })
    };
    //edit by id
    $scope.saveEditUsuarios = function () {
        var formPut = $scope.usuario;
        httpCtrl.putUsuario(formPut).then(function (data) {
            if (data.data == 'OK' || data.status == 200) {
                $scope.$emit("table-updated");//actuliza la tabla despues de guardar
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    title: 'OK: Usuario Editado',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    }
    //=====get by id emit - on
    $scope.$on("formLoadModal", function (event, data) {// recibe y activa 'spinner-border'
        $scope.formLoad = data;
    });
    $scope.$on("getbyidUsuario", function (event, data) {
        $scope.button_edit = true;
        $scope.button_post = false;
        $scope.usuario = angular.copy(data);
        $scope.formLoad = false;
    });

    $scope.reset = function () {
        $scope.button_edit = false;
        $scope.button_post = true;
        $scope.usuario = angular.copy($scope.Usuario);
    };
    ///reset modal
    $scope.$on("resetFormModal", function () {
        $scope.reset();
    });
});
//=====RESET PASSWORD CONTROLLER
app.controller('resetController', function ($scope, $timeout, httpCtrl) {
    var res = { "id": 0, "password": "", "rep_password": "" };
    $scope.$on("openreset", function (event, id) {
        $scope.userid = id;
    });

    $scope.saveResetP = function () {
        var rs = $scope.reset;
        rs['id'] = $scope.userid;
        httpCtrl.sendPassword(rs).then(function (data) {
            if (data.data == 'OK' || data.status == 200) {
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    title: 'OK: Password Editado',
                    showConfirmButton: false,
                    timer: 1500
                })

                $scope.reset = res;
            }
        })
    }
});


////==============export Files========

var exp = angular.module('export-Files-users', []);

exp.controller('exporttoFiles', function ($scope, $http) {
    $scope.exportLists = [];
    $scope.print = {
        "desde": new Date(),
        "hasta": new Date(),
    };
    $scope.searchPrint = function () {
        var d = new Date($scope.print['desde']);//extraer solo el año + mes y dia
        var h = new Date($scope.print['hasta']);//extraer solo el año + mes y dia
        $http({
            method: 'GET',
            url: window.location.origin + '/v1/usuarios/0?desde=' + d.toDateString() + '&&hasta=' + h.toDateString(),
        }).then(function success(response) {
            var data = response.data;
            for (let index = 0; index < data.length; index++) {
                data[index][0] = index + 1;
            }
            $("#example1").DataTable({
                "destroy": true,
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "searching": true,
                "responsive": true,
                "data": data,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        },
            function error(response) { alertify.error(response.data); }
        );
    }
    angular.element(window.document.body).ready(function () {
        $scope.searchPrint();
    });
});

/////////////////LOGINN USUARIOS////////////////

