var index = angular.module('app-Index', ['ngAnimate', 'ngSanitize', 'ui.bootstrap',]);
index.controller('ctrIndex', function ($scope, $http, $window) {
    $scope.Index = {razon_social:'',email:'',numero:'',mensaje:''};
    $scope.index = { razon_social: '', email: '', numero: '', mensaje: '' };
    $scope.textarea=0;
    //////////////////cargar imagenes
    $scope.images = [];
    $scope.uploadIndexImg = function (e) {

        for (let f = 0; f < e.target.files.length; f++) {
            $scope.images.push(e.target.files[f]);
        }
        $scope.generaImages();
        e.target.value = '';
    }
    $scope.generaImages = function () {

        var imgPreview = document.getElementById('img_preview')
            , img, div, btn;
        imgPreview.innerHTML = '';
        for (var i = 0; i < $scope.images.length; i++) {

            div = document.createElement('div');
            btn = document.createElement('button');
            btn.setAttribute('type', 'button');
            btn.setAttribute('onclick', 'angular.element(this).scope().removeImg(' + i + ')');
            btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
            btn.innerHTML = 'X';
            img = document.createElement('img');
            img.src = URL.createObjectURL($scope.images[i]);
            img.title = $scope.images[i].name;
            img.classList.add('img-preview-thumb');
            div.appendChild(btn);
            div.appendChild(img);

            imgPreview.classList.add('d-flex', 'flex-wrap');
            imgPreview.appendChild(div);
        }
    }
    $scope.removeImg = function (i) {
        $scope.images.splice(i, 1);
        var imgPreview = document.getElementById('img_preview')
            , img, div, btn;
        imgPreview.innerHTML = '';
        for (var i = 0; i < $scope.images.length; i++) {

            div = document.createElement('div');
            btn = document.createElement('button');
            btn.setAttribute('type', 'button');
            btn.setAttribute('onclick', 'angular.element(this).scope().removeImg(' + i + ')');
            btn.classList.add('btn', 'btn-sm', 'bg-danger', 'btn-dalete-img')
            btn.innerHTML = 'X';
            img = document.createElement('img');
            img.src = URL.createObjectURL($scope.images[i]);
            img.classList.add('img-preview-thumb');
            div.appendChild(btn);
            div.appendChild(img);

            imgPreview.classList.add('d-flex', 'flex-wrap');
            imgPreview.appendChild(div);
        }
    }
    $scope.vertextarea = function () {
        var index = $scope.index;
        var c = index.mensaje;
        $scope.textarea = c.length;
    }
    angular.element($window).bind("paste", function (e) {
        try {
            var item = Array.from(e.clipboardData.items).find(x => /^image\//.test(x.type));
            var blob = item.getAsFile();
            var images = $scope.images;
            images.push(blob);
            $scope.generaImages();
            console.log(images)
        } catch (error) {
            //error
        }

    });

    $scope.enviar = function (){
        console.log($scope.index)
        var form = $scope.index;
        var images = $scope.images;
        
        var formt = new FormData();
        ///guarda imagen una por una en el formdata
        for (let i = 0; i < images.length; i++) {
            formt.append(i, images[i]);
        }
        
        formt.append('index', JSON.stringify(form));
        formt.append('img_length', images.length);
        formt.append('img_index', $scope.images);
        formt.append('formulario', 'POST');
        $http({
            method: 'POST',
            url: window.location.origin + '/v1/index',
            data: formt,
            headers: { 'Content-Type': undefined }
        }).then(function success(response) {
            console.log(response)
            alertify.success("OK: solicitud enviada, revisa tu email:" + response.data+"");//alerta de guardado
            $scope.index = JSON.parse(JSON.stringify($scope.Index));
            $scope.respuesta = "Te enviaremos una respuesta a tu email: " + response.data + "."
            $scope.images.length = 0;
            $scope.images = [];
            $scope.generaImages();
        },
            function error(response) { alertify.error("ERROR: no se envio la solicitud."); }
        );
    }
});

// window.addEventListener("paste", function (e) {
//     var item = Array.from(e.clipboardData.items).find(x => /^image\//.test(x.type));
//     var blob = item.getAsFile();
//     console.log(blob)

// });
