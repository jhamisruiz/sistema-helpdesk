
var app = angular.module('clientes-app', ['angularMoment', 'ngAnimate', 'ngSanitize', 'ui.bootstrap']);
app.service('httpCtrl', function ($http) {
    /// select ubigeo
    this.selectubigeo = function (name, ubigeo) {
        return $http({
            method: 'GET',
            url: window.location.origin + '/v1/config/?' + name + '=' + ubigeo,
        }).then(function success(response) {
            var res = response.data;
            return res;
        },
            function error(response) { alertify.error('ERROR: seleciona ubigeo'); }
        );
    };
});
///////////////////////// CONTROLLER 1 /////////////////////////////
app.controller('listCtrClientes', function ($scope, $timeout, $http) {
    $scope.clientesLists = [];
    $scope.search = '';
    $scope.length = 10;
    // funtion list
    var selectClientesList = function (length, search) {
        $http({
            method: 'GET',
            url: window.location.origin + '/v1/clientes/0?length=' + length + '&search=' + search,
        }).then(function success(response) {
            var data = response.data;
            for (let index = 0; index < data.length; index++) {
                data[index].index = (index + 1);
            }
            $scope.totalItems = data.length;
            $scope.clientesLists = data;
        },
            function error(response) { alertify.error(response.data); }
        );
    }

    angular.element(window.document.body).ready(function () {
        $scope.length = 1000;
        let length = $scope.length, search = $scope.search;
        selectClientesList(length, search);
    });
    // search
    $scope.searchClientes = function () {
        selectClientesList($scope.length, $scope.search);
    };
    //modal edit by id
    $scope.openModalCliente = function (index, id) {
        selectClientesList($scope.length, '');
        var data = $scope.clientesLists[index];
        $scope.$broadcast("preEditCliente", data);// envia y activa 'spinner-border'
    }


    $scope.openreset = function (id) {
        $scope.$broadcast("openreset", id); ///jala de controller child
    };

    //DELETE CLIENTE by id
    $scope.deleteUsuario = function (id) {
        Swal.fire({
            title: 'Está seguro?',
            text: "El Cliente se eliminara !",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#dd6b55',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formt = new FormData();
                formt.append('cliente', id);
                formt.append('formulario', 'DELETE');
                $http({
                    method: 'POST',
                    url: window.location.origin + '/v1/clientes',
                    data: formt,
                    headers: { 'Content-Type': undefined }
                }).then(function success(response) {
                    selectClientesList(1000, '');
                    Swal.fire({
                        position: 'middle',
                        icon: 'success',
                        text: response.data + ': Cliente eliminado',
                        showConfirmButton: true,
                    })
                },
                    function error(response) { Swal.close(); alertify.error('Error: Datos no eliminados'); }
                );
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
        selectClientesList(1000, '');
    });
    //reset form
    $scope.resetForm = function () {
        $scope.$broadcast("resetFormModal");
    }
});

///////////////////////// CONTROLLER 2 /////////////////////////////

app.controller('postClientes', function ($scope, $timeout, $http, httpCtrl) {

    $scope.Cliente = {
        "names": null, "last_name": null, "phone": null,
        "document_tipe": null, "document_number": null, "email": null,
        "referencia": null, "direccion": null, "id_ubigeo": null, "idProvincia": null, "idDepartamento": null
    };
    $scope.button_edit = false;
    $scope.button_post = true;
    $scope.formLoad = false;
    $scope.onEdit = false;

    //init ubigeo Departamento
    httpCtrl.selectubigeo('departamento', '0000').then(function (data) {
        $scope.Departamento = data;
    })
    //Provincia
    $scope.getProvincia = function () {
        let ubg = $scope.cliente.idDepartamento;
        $scope.Provincia = '';
        $scope.Distrito = '';
        httpCtrl.selectubigeo('provincia', ubg).then(function (data) {
            $scope.Provincia = data;
        })
    }
    //Distrito
    $scope.getDistrito = function () {
        let ubg = $scope.cliente['idProvincia']
        httpCtrl.selectubigeo('distrito', ubg).then(function (data) {
            $scope.Distrito = data;
        })
    }

    $scope.postClientes = function () {
        var data = $scope.cliente;
        var formt = new FormData();
        formt.append('cliente', JSON.stringify(data));
        formt.append('formulario', 'POST');
        $scope.alertifyLoad()
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/clientes',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            $scope.$emit("table-updated");//actuliza la tabla despues de guardar
            Swal.close();
            Swal.fire({
                position: 'middle',
                icon: 'success',
                text: response.data + ': Cliente guardado',
                showConfirmButton: true,
            })
        },
            function error(response) { Swal.close(); alertify.error('Error: Datos no guardados'); }
        );
    };
    //edit by id
    $scope.$on('preEditCliente', function (event, data) {
        $scope.reset();
        $scope.onEdit = true;
        $scope.button_edit = true;
        $scope.button_post = false;
        let ubg = data['id_ubigeo']
        data['idDepartamento'] = ubg.substr(0, 2) + '0000';
        data['idProvincia'] = ubg.substr(0, 4) + '00';
        $scope.cliente = data;
    })

    $scope.saveEditUsuarios = function () {
        var data = $scope.cliente;
        var formt = new FormData();
        formt.append('cliente', JSON.stringify(data));
        formt.append('formulario', 'PUT');
        $scope.alertifyLoad()
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/clientes',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            $scope.$emit("table-updated");//actuliza la tabla despues de guardar
            Swal.close();
            Swal.fire({
                position: 'middle',
                icon: 'success',
                text: response.data + ': Cliente actualizado',
                showConfirmButton: true,
            })
        },
            function error(response) { Swal.close(); alertify.error('Error: Datos no guardados'); }
        );
    }
    //DELETE CLIENTE

    $scope.reset = function () {
        $scope.button_edit = false;
        $scope.button_post = true;
        $scope.onEdit = false;
        $scope.cliente = angular.copy($scope.Cliente);
    };
    ///reset modal
    $scope.$on("resetFormModal", function () {
        $scope.reset();
    });
    $scope.alertifyLoad = function () {
        let timerInterval
        Swal.fire({
            title: 'Espera!',
            html: 'Guardadndo Datos <b></b>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        })
    }
});

////==============export Files========

var exp = angular.module('export-Files-clientes', []);

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
            url: window.location.origin + '/v1/clientes/0?desde=' + d.toDateString() + '&&hasta=' + h.toDateString(),
        }).then(function success(response) {
            var data = response.data;
            for (let index = 0; index < data.length; index++) {
                data[index]['num'] = index + 1;
            }
            $scope.exportLists = data;
            $("#tableClientes").DataTable({
                "destroy": true,
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "searching": true,
                "responsive": true,
                "columns": [{
                    "data": "num" //
                }, {
                    "data": "names"
                }, {
                    "data": "last_name"
                }, {
                    "data": "email"
                }, {
                    "data": "phone"
                }, {
                    "data": "description"
                }, {
                    "data": "document_number"
                }, {
                    "data": "date_create"
                }, {
                    "data": "Departamento" //
                }, {
                    "data": "Provincia"
                }, {
                    "data": "Distrito"
                }, {
                    "data": "direccion" //
                }, {
                    "data": "referencia" //
                }],
                "data": data,
            }).buttons().container().appendTo('#tableClientes_wrapper .col-md-6:eq(0)');

        },
            function error(response) { alertify.error(response.data); }
        );
    }
    angular.element(window.document.body).ready(function () {
        $scope.searchPrint();
    });
});