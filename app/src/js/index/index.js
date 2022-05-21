var index = angular.module('app-Index', ['ngAnimate', 'ngSanitize', 'ui.bootstrap',]);
index.controller('ctrIndex', function ($scope, $http, $window) {

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

    angular.element($window).bind("paste", function (e) {
        var item = Array.from(e.clipboardData.items).find(x => /^image\//.test(x.type));
        var blob = item.getAsFile();
        $scope.images.push(blob);
        $scope.generaImages();

    });
});

// window.addEventListener("paste", function (e) {
//     var item = Array.from(e.clipboardData.items).find(x => /^image\//.test(x.type));
//     var blob = item.getAsFile();
//     console.log(blob)

// });


function asdasd() {
    alertify.error('Error: al enviar formulario');
    console.log('asd')
}