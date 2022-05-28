<div ng-app="app-Index" ng-controller="ctrIndex">
    <div class="page-heading">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="container border rounded-3 border-primary">
                    <form name="indexForm" novalidate netlify>
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-6 pt-4">
                                <h2 class="text-title">Formulario de Consultas</h2>
                                <div class="form-group">
                                    <label>Nombre/ Razon Social</label>
                                    <input ng-model="index.razon_social" name="razon_social" class="form-control border border-primary" ng-class="{'border-danger':indexForm.razon_social.$touched && indexForm.razon_social.$error.required}" type="text" ng-required="true" placeholder="nombre..." autocomplete="TRUE">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input ng-model="index.email" name="email" class="form-control border border-primary" ng-class="{'border-danger':indexForm.email.$touched && indexForm.email.$error.required}" type="email" ng-required="true" placeholder="Ejemplo@email.com">
                                </div>
                                <div class="form-group">
                                    <label>Numero</label>
                                    <input ng-model="index.numero" name="numero" class="form-control border border-primary" ng-class="{'border-danger':indexForm.numero.$touched && indexForm.numero.$error.required}" type="text" ng-required="true" placeholder="987456321">
                                </div>
                                <div class="form-group">
                                    <label>Mensaje</label>
                                    <textarea ng-change="vertextarea()" ng-model="index.mensaje" name="mensaje" class="form-control border border-primary" ng-class="{'border-danger':indexForm.mensaje.$touched && indexForm.mensaje.$error.required}" ng-required="true" cols="30" rows="3"></textarea>
                                    <span>Caracteres {{textarea}} de 250</span>
                                </div>
                                <div class="form-group--file">
                                    <label for="upload" class="form-group__label">
                                        <span class="form-group__text">Arrastra o pega</span>
                                        o busca una imagen
                                        <input type="file" onchange="angular.element(this).scope().uploadIndexImg(event)" id="upload" class="form-group__control" multiple accept="image/png,image/jpg,image/*">
                                    </label>
                                </div>
                                <div class="form-group" id="img_preview"></div>
                                <samp class="fs-4 text-info">{{respuesta}}</samp>
                                <div class="form-group mt-4 mb-4">
                                    <button ng-click="enviar()" type="button" class="btn btn-primary w-25" ng-disabled="!indexForm.$valid">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</div>