<div ng-app="app-Index" ng-controller="ctrIndex">
    <div class="page-heading">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="container border rounded-3 border-primary">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 pt-4">
                            <h2 class="text-title">Formulario de Consultas</h2>
                            <div class="form-group">
                                <label for="my-input">Nombre/ Razon Social</label>
                                <input id="my-input" class="form-control border border-primary" type="text" placeholder="nombre...">
                            </div>
                            <div class="form-group">
                                <label for="my-input">Email</label>
                                <input id="my-input" class="form-control border border-primary" type="email" placeholder="Ejemplo@email.com">
                            </div>
                            <div class="form-group">
                                <label for="my-input">Numero</label>
                                <input id="my-input" class="form-control border border-primary" type="text" placeholder="987456321">
                            </div>
                            <div class="form-group">
                                <label for="my-input">Detalle</label>
                                <textarea name="" class="form-control border border-primary" cols="30" rows="3"></textarea>
                            </div>
                            <div class="form-group--file">
                                <label for="upload" class="form-group__label">
                                    <span class="form-group__text">Arrastra o pega</span>
                                    o busca una imagen
                                    <input type="file" onchange="angular.element(this).scope().uploadIndexImg(event)" id="upload" class="form-group__control" multiple accept="image/png,image/jpg,image/*">
                                </label>
                            </div>
                            <div class="form-group" id="img_preview"></div>
                            <div class="form-group mt-4 mb-4">
                                <button onclick="asdasd()" type="button" class="btn btn-primary w-25">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</div>