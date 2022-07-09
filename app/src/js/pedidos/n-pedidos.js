
///------------ SELECT-------------/
var app = angular.module('peidos-app', ['angularMoment', 'ngAnimate', 'ngSanitize', 'ui.bootstrap']);

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
            function error(response) { alertify.error(response.data); }
        );
    };

    this.selectPrdidos = function (length, search) {
        return $http({
            method: 'GET',
            url: window.location.origin + '/v1/pedidos/0?length=' + length + '&search=' + search,
        }).then(function success(response) {
            return response.data;
        },
            function error(response) { alertify.error(response.data); }
        );
    };
    // select by id
    this.getpedido = function (id) {
        return $http({
            method: 'GET',
            url: window.location.origin + '/v1/pedidos/' + id,
        }).then(function success(response) {
            return response.data;
        },
            function error(response) { alertify.error(response.data); }
        );
    }
    this.postData = function (pedido) {
        return $http({
            method: 'POST',
            url: window.location.origin + '/v1/pedidos',
            data: pedido,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) { return response; },
            function error(response) { alertify.error('Error: BackEnd'); }
        );
    };
    //EDITANDO PEDIDO
    this.putPedido = function (pedido) {
        return $http({
            method: 'POST',
            url: window.location.origin + '/v1/pedidos',
            data: pedido,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) { return response; },
            function error(response) { alertify.error('Error: PUT BackEnd'); }
        );
    }
    //sliminar
    this.deletepedido = function (id) {
        return $http({
            method: 'DELETE',
            url: window.location.origin + '/v1/pedidos',
            data: id,
        }).then(function success(response) { return response; },
            function error(response) { alertify.error(response.data); }
        );
    };

});
app.controller('listController', function ($scope, $http, httpCtrl) {
    $scope.pedidoLists = [];
    $scope.length = 10;
    $scope.search = '';
    $scope.selectPrdidosList = function () {
        httpCtrl.selectPrdidos($scope.length, $scope.search).then(function (data) {
            $scope.totalItems = data.length;
            $scope.pedidoLists = data;
            console.log('data:', $scope.pedidoLists)
        })
    }
    angular.element(window.document.body).ready(function () {
        $scope.length = 1000;
        $scope.selectPrdidosList();
    });
    $scope.searchPedidos = function () {
        //$timeout($scope.selectPrdidosList, 300);
        $scope.selectPrdidosList();
    };
    $scope.editPedido = function (id) {
        $scope.$broadcast("formLoadModal", 'true');// envia y activa 'spinner-border'
        httpCtrl.getpedido(id).then(function (data) {
            $scope.$broadcast("getbyidPedido", data); ///jala de controller child
        })
    }
    //delete by id
    $scope.deletePedido = function (id) {
        Swal.fire({
            title: 'Está seguro?',
            text: "El Pedido se eliminara definitivamente!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#dd6b55',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                httpCtrl.deletepedido(id).then(function (data) {
                    $scope.selectPrdidosList();
                    if (data.data == 'OK' || data.status == 200) {
                        Swal.fire({
                            position: 'middle',
                            icon: 'success',
                            title: 'OK: Pedido Eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }
        });
    }
    ///EDITAR ESTADOS
    $scope.selectEstado = function (e) {
        let value = e.target.value.split('-');//extraemos idpedido y idestado
        $http({
            method: 'GET',
            url: window.location.origin + '/v1/pedidos/?estado=' + value[1] + '&&idpedido=' + value[0],
            data: { estado: value[1] },
        }).then(function success(response) {
            if (response.data == 'OK') {
                alertify.success('Estado actualizado');
                $scope.selectPrdidosList();
            } else {
                alertify.error('No se actualizo');
            }
        }, function error(response) {
            alertify.error(response.data);
        }
        );
    }
    //reset form
    $scope.resetForm = function () {
        $scope.$broadcast("resetFormModal");
    }
    //LEVANTA MODAL DETALLE PAGO
    $scope.photosValid = false;

    $scope.detallePago = function (id) {
        $scope.url_zip = '';
        $scope.photos = [];
        httpCtrl.getpedido(id).then(function (response) {
            $scope.url_zip = 'upload/' + response.document_number + '/' + response.codigo + '.zip';
            let photo = '[' + response.photos + ']';
            $scope.photos = JSON.parse(photo);
        })
        var pedidos = $scope.pedidoLists;
        function extrac(data) { return data.id === id; }
        let pedido = pedidos.find(extrac)
        $scope.photosValid = (pedido.photos[0] == '') ? false : true;
        $scope.metodo_pago = {};
        $scope.metodo_pago = pedido.metodo_pago;
    }
    //------pagination-----
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
        $scope.selectPrdidosList();
    });

    //////////////descarga zip
    $scope.url_zip = '';
    // $scope.setPage = function (url) {
    //     $scope.download_zip = pageNo;
    // };
});
app.controller('postPedidos', function ($scope, $http, httpCtrl) {
    $scope.Pedido = {
        "names": null, "last_name": null, "phone": null,
        "document_tipe": null, "document_number": null, "email": null,
        "precio": null, "referencia": null, "direccion": null, "id_ubigeo": null, "idProvincia": null, "idDepartamento": null
    };
    $scope.button_edit = false;
    $scope.button_post = true;
    $scope.date = new Date();
    $scope.formLoadP = false;
    $scope.onEdit = false;
    $scope.pago_img = {};
    $scope.photoWeb = []

    $scope.tipo_envio = 1;
    $scope.obtenerEnvio = function (cod) {
        $scope.tipo_envio = cod;
    };

    //init ubigeo Departamento
    httpCtrl.selectubigeo('departamento', '0000').then(function (data) {
        $scope.Departamento = data;
    })
    //Provincia
    $scope.getProvincia = function () {
        let ubg = $scope.pedido['idDepartamento'];
        $scope.Provincia = '';
        $scope.Distrito = '';
        httpCtrl.selectubigeo('provincia', ubg).then(function (data) {
            $scope.Provincia = data;
        })
    }
    //Distrito
    $scope.getDistrito = function () {
        let ubg = $scope.pedido['idProvincia']
        httpCtrl.selectubigeo('distrito', ubg).then(function (data) {
            $scope.Distrito = data;
        })
    }

    $scope.reset = function () {
        $scope.button_edit = false;
        $scope.button_post = true;
        $scope.pedido = angular.copy($scope.Pedido);
        $scope.pago_img = {};
        $scope.files = [];
        $scope.btnSiguiente(1);
        $scope.onEdit = false;
        $('#sincomprobante').removeClass('d-none');
        $scope.editNone = false;
        $('#img_preview').html('');
        $('#preview_img_ped').html('');
        $('#imagenPago').html('');
        $('#imagenPago_edit').html('');
    };

    //GUARADA LA DATA EDITADA
    $scope.saveEditPedido = function () {
        var form = $scope.pedido;
        var images = $scope.files;
        form['fecha_registro'] = new Date();
        form['precio'] = form['monto'].toFixed(2);
        form['descripcion'] = form['descripcion'];

        form["tipo_envio"] = $scope.tipo_envio;

        form['detalle_pago'] = {
            tipo: form['tipo_pago'],
            monto: form['monto'].toFixed(2),
            descripcion: form['descripcion'],
        }

        var formt = new FormData();
        for (let i = 0; i < images.length; i++) {
            formt.append(i, images[i]);
        }
        formt.append('pedido', JSON.stringify(form));
        formt.append('cant_img', images.length);
        formt.append('pago_img', $scope.pago_img);
        formt.append('formulario', 'PUT');
        $scope.alertifyLoad();
        httpCtrl.putPedido(formt).then(function (data) {
            if (data.data.sms == 'OK') {
                $scope.editNone = true;
                $scope.files = [];
                Swal.close();
                $scope.$emit("table-updated");//actuliza la tabla despues de guardar
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    text: 'Pedido Actualizado',
                    showConfirmButton: true,
                })
            } else {
                alertify.alert(data.data.sms);
                alertify.alert().setting('modal', false);
                Swal.close()
            }
        })
    }
    //boton siguiente en form
    $scope.btnSiguiente = function (num) {
        $scope.formLoadP = (num == 0) ? true : false;
        $scope.btnatras = (num == 0) ? true : false;
        $scope.button_sig = (num == 0) ? true : false;
        $scope.button_post = (num == 0) ? false : true;
        if ($scope.onEdit) {
            $scope.button_edit = (num == 0) ? true : false;
            $scope.editNone = (num == 0) ? false : true;
        }
    }
    //GUARDA PEDIDO
    $scope.postPedidos = function () {
        var form = $scope.pedido;
        var images = $scope.files;
        form['fecha_registro'] = new Date();
        form['precio'] = form['monto'].toFixed(2);
        form['descripcion'] = form['descripcion'];

        form["tipo_envio"] = $scope.tipo_envio;

        form['detalle_pago'] = {
            tipo: form['tipo_pago'],
            monto: form['monto'].toFixed(2),
            descripcion: form['descripcion'],
        }

        var formt = new FormData();
        for (let i = 0; i < images.length; i++) {
            formt.append(i, images[i]);
            images[i]['i'] = i;
        }
        form['Croped'] = images;
        formt.append('pedido', JSON.stringify(form));
        formt.append('cant_img', images.length);
        formt.append('pago_img', $scope.pago_img);
        formt.append('formulario', 'POST');
        $scope.alertifyLoad()
        httpCtrl.postData(formt).then(function (data) {
            if (data.data.sms == 'OK') {

                Swal.close();
                $scope.$emit("table-updated");//actuliza la tabla despues de guardar
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    text: 'Pedido guardado, Codigo:' + data.data.codigo,
                    showConfirmButton: true,
                })
                $scope.btnSiguiente(1);
                $scope.reset();
                $scope.tipo_envio = 1;

            } else {
                alertify.alert(data.data.sms);
                alertify.alert().setting('modal', false);
                Swal.close()
            }
        })
    };

    //=====get by id emit - on
    $scope.$on("formLoadModal", function (event, data) {// recibe y activa 'spinner-border'
        $scope.btnSiguiente(1);
        $scope.LoadPedido = data;
        $scope.onEdit = data;
    });
    ///POBLANDO FORMULARIO
    $scope.$on("getbyidPedido", function (event, data) {
        $scope.button_post = true;
        $scope.photoWeb = [];
        data['precio'] = Number(data['precio']);
        let ubg = data['id_ubigeo']
        data['idDepartamento'] = ubg.substr(0, 2) + '0000';
        data['idProvincia'] = ubg.substr(0, 4) + '00';
        $scope.pedido = angular.copy(data);
        $scope.LoadPedido = false;// DETIENE SPINER
        let photo = '[' + $scope.pedido.photos + ']';
        $scope.photoWeb = JSON.parse(photo)
        $scope.tipo_envio=$scope.pedido['tipo_envio'];
    });
    /// imagenes desde la BD
    $scope.imagenesWeb = function () {
        var innImg = document.getElementById('preview_img_ped'), img, div, btn;
        innImg.innerHTML = '';
        if ($scope.photoWeb[0]) {
            for (let i = 0; i < $scope.photoWeb.length; i++) {
                div = document.createElement('div');
                btn = document.createElement('button');
                btn.setAttribute('type', 'button');
                let id = $scope.photoWeb[i].id;
                btn.setAttribute('onclick', 'angular.element(this).scope().removeIWEB(' + i + ',' + id + ' )');
                btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
                btn.innerHTML = 'X';
                img = document.createElement('img');
                //img.src = URL.createObjectURL($scope.files[i]);
                let url = window.location.origin + '/' + $scope.photoWeb[i].url;
                img.setAttribute('src', url)
                img.classList.add('img-preview-thumb');
                div.appendChild(btn);
                div.appendChild(img);

                innImg.classList.add('d-flex', 'flex-wrap');
                innImg.appendChild(div);
            }
        }
    }

    $scope.removeIWEB = function (i, id) {
        Swal.fire({
            title: 'Eliminar imagen!',
            text: 'Está seguro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Salir'
        }).then((result) => {
            if (result.isConfirmed) {
                if (id == 'MP') {
                    //elimina imgen de comprobante
                    $('#sincomprobante').removeClass('d-none');
                    alertify.success('Comprobante eliminado');
                    document.getElementById('imagenPago_edit').innerHTML = '';
                } else {
                    //eliminando imagenes de la web 
                    let url = $scope.photoWeb[i].url;
                    $http({
                        method: 'GET',
                        url: window.location.origin + '/v1/pedidos/?idimagen=' + id + '&&urlimagen=' + url,
                        data: { idimagen: id },
                    }).then(function success(response) {
                        if (response.data == 'OK') {
                            alertify.success('Imagen eliminada');
                            $scope.photoWeb.splice(i, 1);
                            $scope.imagenesWeb();
                            $scope.$emit("table-updated");//actuliza la tabla despues eliminar las imagenes
                        } else {
                            alertify.error('No se elimino');
                        }
                    }, function error(response) {
                        alertify.error(response.data);
                    }
                    );
                }

            }
        });
    }
    //crea imagen de metodo pago guardado
    $scope.imagMPagoWeb = function () {
        $('#sincomprobante').addClass('d-none');
        var innImg = document.getElementById('imagenPago_edit'), img, div, btn;
        innImg.innerHTML = '';
        div = document.createElement('div');
        btn = document.createElement('button');
        btn.setAttribute('type', 'button');
        btn.setAttribute('onclick', 'angular.element(this).scope().removeIWEB("00","MP" )');
        btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
        btn.innerHTML = 'X';
        img = document.createElement('img');
        //img.src = URL.createObjectURL($scope.files[i]);
        let url = window.location.origin + '/' + $scope.pedido.url_img_mp;
        img.setAttribute('src', url)
        img.classList.add('w-75');
        div.appendChild(btn);
        div.appendChild(img);
        innImg.classList.add('d-flex', 'flex-wrap');
        innImg.appendChild(div);
    }

    $scope.$on("resetFormModal", function () {
        $scope.reset();
    });

    //////////////////cargar imagenes
    $scope.files = [];
    $scope.uploadImages = function (e) {
        var imgPreview = document.getElementById('img_preview')
            , img, div, btn;
        for (let f = 0; f < e.target.files.length; f++) {
            $scope.files.push(e.target.files[f]);
        }

        for (var i = 0; i < $scope.files.length; i++) {

            div = document.createElement('div');
            btn = document.createElement('button');
            btn.setAttribute('type', 'button');
            btn.setAttribute('onclick', 'angular.element(this).scope().removeImg(' + i + ')');
            btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
            btn.innerHTML = 'X';
            img = document.createElement('img');
            img.src = URL.createObjectURL($scope.files[i]);
            img.classList.add('img-preview-thumb');
            div.appendChild(btn);
            div.appendChild(img);

            imgPreview.classList.add('d-flex', 'flex-wrap');
            imgPreview.appendChild(div);
        }
    }
    $scope.addingByBack = function (bol) {

        if (!bol && $scope.files.length > 0) {
            var imgPreview = document.getElementById('img_preview')
                , img, div, btn;
            imgPreview.innerHTML = '';

            for (var i = 0; i < $scope.files.length; i++) {

                div = document.createElement('div');
                btn = document.createElement('button');
                btn.setAttribute('type', 'button');
                btn.setAttribute('onclick', 'angular.element(this).scope().removeImg(' + i + ')');
                btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
                btn.innerHTML = 'X';
                img = document.createElement('img');
                img.src = URL.createObjectURL($scope.files[i]);
                img.classList.add('img-preview-thumb');
                div.appendChild(btn);
                div.appendChild(img);

                imgPreview.classList.add('d-flex', 'flex-wrap');
                imgPreview.appendChild(div);
            }
        }
        $scope.pago_img = null;
    }
    $scope.removeImg = function (i) {
        $scope.files.splice(i, 1);
        var imgPreview = document.getElementById('img_preview')
            , img, div, btn;
        imgPreview.innerHTML = '';
        for (var i = 0; i < $scope.files.length; i++) {

            div = document.createElement('div');
            btn = document.createElement('button');
            btn.setAttribute('type', 'button');
            btn.setAttribute('onclick', 'angular.element(this).scope().removeImg(' + i + ')');
            btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
            btn.innerHTML = 'X';
            img = document.createElement('img');
            img.src = URL.createObjectURL($scope.files[i]);
            img.classList.add('img-preview-thumb');
            div.appendChild(btn);
            div.appendChild(img);

            imgPreview.classList.add('d-flex', 'flex-wrap');
            imgPreview.appendChild(div);
        }
    }
    $scope.uploadImgPago = function (e) {
        $scope.pago_img = {};
        var imagenPago = document.getElementById('imagenPago'), img, div, btn;
        imagenPago.innerHTML = '';
        div = document.createElement('div');
        btn = document.createElement('button');
        btn.setAttribute('type', 'button');
        btn.setAttribute('onclick', 'angular.element(this).scope().removeImgPago()');
        btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
        btn.innerHTML = 'X';
        img = document.createElement('img');
        img.src = URL.createObjectURL(e.target.files[0]);
        img.classList.add('img-preview-pago');
        div.appendChild(btn);
        div.appendChild(img);

        imagenPago.appendChild(div);
        $scope.pago_img = e.target.files[0];
    }
    $scope.removeImgPago = function () {
        var imagenPago = document.getElementById('imagenPago')
        $scope.pago_img = null;
        imagenPago.innerHTML = '';
    }
    $scope.alertifyLoad = function () {
        let timerInterval
        Swal.fire({
            title: 'Espera!',
            html: 'Guardadndo Pedido <b></b>',
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

////==============export exel========

var exp = angular.module('export-exel', []);

exp.controller('exporttoexel', function ($scope, $http) {
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
            url: window.location.origin + '/v1/pedidos/0?desde=' + d.toDateString() + '&&hasta=' + h.toDateString(),
        }).then(function success(response) {
            var data = response.data;
            for (let index = 0; index < data.length; index++) {
                data[index]['num'] = index + 1;
            }

            $("#example1").DataTable({
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
                    "data": "phone"
                }, {
                    "data": "ubigeo"
                }, {
                    "data": "direccion"
                }, {
                    "data": "referencia"
                }, {
                    "data": "envio"
                }, {
                    "data": "precio"
                }, {
                    "data": "tipo"
                }, {
                    "data": "descripcion"
                }, {
                    "data": "codigo" //
                }, {
                    "data": "fecha_registro" //
                }, {
                    "data": "fecha_entrega" //
                }, {
                    "data": "estado" //
                }],
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
