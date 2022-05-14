<div ng-app="peidos-app" ng-controller="listController">
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Pedidos</h5>
                    <button type="button" class="btn bg-primary text-white" ng-click="resetForm()" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Pedido</button>
                </div>
                <div class="card-body ">
                    <div class="row colum-flex-rev">
                        <div class="col-lg-2 mb-0 pb-0">
                            <div class="mb-0  p-0 d-flex align-items-center">
                                <h6 class="mr-3">Ver </h6>
                                <select ng-change="setItemsPerPage(length)" class="form-control w-50" ng-model="length">
                                    <option ng-value="5">5</option>
                                    <option ng-value="10" ng-selected="'1000' == length">10</option>
                                    <option ng-value="25">25</option>
                                    <option ng-value="50">50</option>
                                    <option ng-value="100">100</option>
                                </select>
                                <h6 class="ml-3">Filas</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-0 pb-0">
                            <div class="input-group mb-0 border border-primary rounded p-0">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input ng-model="search" ng-change="searchPedidos()" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>
                            <div id="smsearch" class="text-danger mb-0 pb-0"></div>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white">#</th>
                                    <th class="bg-primary text-white ">Cliente</th>
                                    <th class="bg-primary text-white">Telefono</th>
                                    <th class="bg-primary text-white">N. Documento</th>
                                    <th class="bg-primary text-white">Direccion</th>
                                    <th class="bg-primary text-white">Tipo Envio</th>
                                    <th class="bg-primary text-white">Precio</th>
                                    <th class="bg-primary text-white">Tipo Pago</th>
                                    <th class="text-white bg-primary">Cod. Pedido</th>
                                    <th class="text-white bg-primary" style="min-width: 98px;">Fecha Reg</th>
                                    <th class="text-white bg-primary" style="min-width: 98px;">Fecha Ent</th>
                                    <th class="text-white bg-primary">Imagenes</th>
                                    <th class="text-white bg-primary">Estado</th>
                                    <th class="bg-primary text-white" style="max-width: 70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="mostrarTrabajador">
                                <tr ng-repeat="pedido in pedidoLists.slice(((currentPage-1)*itemsPerPage), ((currentPage)*itemsPerPage))">
                                    <td>{{$index+1}}</td>
                                    <td>{{pedido.names }} {{pedido.last_name}}</td>
                                    <td> {{pedido.phone}}</td>
                                    <td> {{pedido.document_number}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light border border-primary btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Direccion
                                            </button>
                                            <div class="card-body dropdown-menu border border-primary" aria-labelledby="dropdownMenuButton1">
                                                Dep: {{pedido.Departamento}}<br>
                                                Prov: {{pedido.Provincia}} <br>
                                                Dist: {{pedido.Distrito}}<br>
                                                Dir: {{pedido.direccion}}<br>
                                                Ref: {{pedido.referencia}}
                                            </div>
                                        </div>
                                    </td>
                                    <td> {{pedido.tipo_envio === 1 ? 'Gratis':'Expres' }}</td>
                                    <td><button ng-click="detallePago(pedido.id)" class="btn btn-light border border-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalPago">
                                            {{pedido.precio}}
                                        </button>
                                    </td>
                                    <td> {{pedido.metodo_pago.tipo}}</td>
                                    <td>{{pedido.codigo}}</td>
                                    <td class="p-0" style="min-width: 98px;">{{pedido.fecha_registro | date:'dd/MM/yyyy h:mm:ss'}}</td>
                                    <td class="p-0" style="min-width: 98px;">{{pedido.fecha_entrega | date:'dd/MM/yyyy'}}</td>
                                    <td><button ng-click="detallePago(pedido.id)" class="btn btn-light border border-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalPhotos">
                                            Ver <strong>{{pedido.photos.length}}</strong>
                                        </button>
                                    </td>
                                    <td>
                                        <select onchange="angular.element(this).scope().selectEstado(event)" class="input-group input-group-sm border border-primary">
                                            <option value="{{pedido.id}}-1" ng-selected="'1' == pedido.id_estado">PENDIENTE</option>
                                            <option value="{{pedido.id}}-2" ng-selected="'2' == pedido.id_estado">CANCELADO</option>
                                            <option value="{{pedido.id}}-3" ng-selected="'3' == pedido.id_estado">ACEPTADO</option>
                                            <option value="{{pedido.id}}-4" ng-selected="'4' == pedido.id_estado">EN PROCESO</option>
                                            <option value="{{pedido.id}}-5" ng-selected="'5' == pedido.id_estado">ENTREGADO</option>
                                        </select>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a class="action-icon " data-toggle="dropdown" aria-expanded="false">
                                                <img src="dist/svg/arrow-down.svg" width="30">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" ng-click="editPedido(pedido.id)" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                                    <i class="bi bi-pen-fill text-success"></i> Edit</a>
                                                <a class="dropdown-item" ng-click="deletePedido(pedido.id)">
                                                    <i class="bi bi-trash m-r-5 text-danger"></i>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h6>Page <strong>{{currentPage}} / {{numPages}}</strong> de filas <strong>{{totalItems}}</strong></h6>
                        <div class="card-body">
                            <nav aria-label="...">
                                <pagination total-items="totalItems" ng-model="currentPage" class="pagination-sm" items-per-page="itemsPerPage" num-pages="numPages"></pagination>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--Add MODAL -->
    <div ng-controller="postPedidos" class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <form class="" name="pedidosForm" novalidate netlify>
                    <div>
                        <div class="modal-header">
                            <h4 class="modal-title ">Formulario Pedidos</h4>
                        </div>
                        <!-- Modal body -->
                        <div class="pl-4 pr-4 pt-3" ng-if="!LoadPedido">
                            <div class="row" ng-if="!formLoadP">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="m-0" for="full-name">Nombre <i class="text-danger">*<i ng-show="pedidosForm.names.$touched && pedidosForm.names.$error.required">Este campo es requerido.</i></i></label>
                                            <input ng-model="pedido.names" name="names" type="text" placeholder="José" ng-required="true" class="form-control border border-primary" />
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="full-name">Apellido <i class="text-danger">*<i ng-show="pedidosForm.last_name.$touched && pedidosForm.last_name.$error.required">Este campo es requerido.</i></i></label>
                                            <input ng-model="pedido.last_name" name="last_name" type="text" placeholder="Luna" ng-required="true" class="form-control border border-primary" />
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="phone">Teléfono <i class="text-danger">*<i ng-show="pedidosForm.phone.$touched && pedidosForm.phone.$error.required">Este campo es requerido.</i></i></label>
                                            <input ng-model="pedido.phone" name="phone" type="text" placeholder="999999990" ng-required="true" class="form-control border border-primary" />
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="document-type">Tipo de documento <i class="text-danger">*<i ng-show="pedidosForm.document_tipe.$touched && pedidosForm.document_tipe.$error.required">Este campo es requerido.</i></i></label>
                                            <select ng-model="pedido.document_tipe" name="document_tipe" ng-required="true" class="form-control border border-primary">
                                                <option ng-value="" ng-selected="pedido.document_tipe===null">Elegir su tipo de documento:</option>
                                                <option ng-value="1" ng-selected="'1' == pedido.document_tipe">DNI</option>
                                                <option ng-value="2" ng-selected="'2' == pedido.document_tipe">Carnet extranjería</option>
                                                <option ng-value="3" ng-selected="'3' == pedido.document_tipe">RUC</option>
                                                <option ng-value="4" ng-selected="'4' == pedido.document_tipe">Pasaporte</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="document-number">N° documento <i class="text-danger">*<i ng-show="pedidosForm.document_number.$touched && pedidosForm.document_number.$error.required">Este campo es requerido.</i></i></label>
                                            <input ng-model="pedido.document_number" name="document_number" type="text" placeholder="71590144" ng-required="true" class="form-control border border-primary" />
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="m-0" for="email">Email <i class="text-danger">*<i ng-show="pedidosForm.email.$touched && pedidosForm.email.$error.required">Este campo es requerido.</i></i></label>
                                            <input ng-model="pedido.email" name="email" type="email" placeholder="me@example.com" ng-required="true" class="form-control border border-primary" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="m-0" for="departamento">Departamento <i class="text-danger">*<i ng-show="pedidosForm.idDepartamento.$touched && pedidosForm.idDepartamento.$error.required">Este campo es requerido.</i></i></label>
                                            <select ng-change="getProvincia()" name="idDepartamento" ng-model="pedido.idDepartamento" ng-required="true" class="form-control border border-primary">
                                                <option value="">Elegir Departamento:</option>
                                                <option ng-repeat="Depart in Departamento" value="{{Depart.id_ubigeo}}">{{Depart.Departamento}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="provincia">Provincia <i class="text-danger">*<i ng-show="pedidosForm.idProvincia.$touched && pedidosForm.idProvincia.$error.required">Este campo es requerido.</i></i></label>
                                            <select ng-change="getDistrito()" name="idProvincia" ng-model="pedido.idProvincia" ng-required="true" class="form-control border border-primary">
                                                <option value="">Elegir Provincia:</option>
                                                <option ng-repeat="Prov in Provincia" value="{{Prov.id_ubigeo}}">{{Prov.Provincia}}
                                                <option ng-if="onEdit" ng-selected="onEdit===true" ng-value="pedido.idProvincia">{{pedido.Provincia}}</option>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="ubigeo">Distrito <i class="text-danger">*<i ng-show="pedidosForm.id_ubigeo.$touched && pedidosForm.id_ubigeo.$error.required">Este campo es requerido.</i></i></label>
                                            <select ng-model="pedido.id_ubigeo" name="id_ubigeo" ng-required="true" class="form-control border border-primary">
                                                <option value="">Elegir Distrito:</option>
                                                <option ng-repeat="Dis in Distrito" value="{{Dis.id_ubigeo}}">{{Dis.Distrito}}
                                                <option ng-if="onEdit" ng-selected="onEdit===true" ng-value="pedido.id_ubigeo">{{pedido.Distrito}}</option>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="address">Dirección <i class="text-danger">*<i ng-show="pedidosForm.direccion.$touched && pedidosForm.direccion.$error.required">Este campo es requerido.</i></i></label>
                                            <input ng-model="pedido.direccion" name="direccion" type="text" placeholder="Dirección " ng-required="true" class="form-control border border-primary" />
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="m-0" for="reference-address">Referencia</label>
                                            <input ng-model="pedido.referencia" type="text" placeholder="Referencia del lugar" class="form-control border border-primary" />
                                        </div>
                                        <div class="form-group mt-4">
                                            <div class="d-flex w-100 justify-content-around ">
                                                <div class="form-check">
                                                    <input ng-click="obtenerEnvio(1)" class="form-check-input btn-xl" type="radio" name="flexRadioDefault" id="flexRadioDefault1" ng-checked="1 == tipo_envio">
                                                    <label class="ml-2 form-check-label" for="flexRadioDefault1">
                                                        <h6> Gratis</h6>
                                                        <p >5 a 7 dias</p>
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input ng-click="obtenerEnvio(2)" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"ng-checked="2 == tipo_envio">
                                                    <label class="ml-2 form-check-label" for="flexRadioDefault2">
                                                        <h6>Expres s/ 12</h6>
                                                        <p >24 a 48 horas</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-end">
                                    <label ng-show="!pedidosForm.$valid">
                                        <h6 class="text-danger mt-4">Campos obligatorios (*)</h6>
                                    </label>
                                </div>

                            </div>
                            <!-- ///carga imagenes -->
                            <div class="row" ng-if="formLoadP">
                                <div class="card-body table-responsiv">

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Imagenes
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <p>
                                                            <label for="upload_imgs" class="button-files hollow">Seleccionar imagenes +</label>
                                                            <input onchange="angular.element(this).scope().uploadImages(event)" class="show-for-sr" type="file" id="upload_imgs" name="upload_imgs[]" multiple />
                                                        </p>
                                                        <div ng-init="addingByBack(0);" class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>
                                                    </form>
                                                    <div class="row mt-2 pt-2 border-top border-3 border-success" ng-if="onEdit">
                                                        <p>Imagenes guardadas</p>
                                                        <div ng-init="imagenesWeb()" id="preview_img_ped" class=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Metodo Pago
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="full-name">Metodo Pago <i class="text-danger">*<i ng-show="pedidosForm.tipo_pago.$touched && pedidosForm.tipo_pago.$error.required">Este campo es requerido.</i></i></label>
                                                                <input ng-model="pedido.tipo_pago" name="tipo_pago" type="text" ng-required="true" class="form-control border border-primary" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-0" for="full-name">Monto <i class="text-danger">*<i ng-show="pedidosForm.monto.$touched && pedidosForm.monto.$error.required">Este campo es requerido.</i></i></label>
                                                                <div class="d-flex">
                                                                    <div class="input-group mb-0 border border-primary rounded p-0">
                                                                        <span class="input-group-text" id="basic-addon1"><i class=>S/</i></span>
                                                                        <input ng-model="pedido.monto " id="idtotalsum" name="monto" class="form-control" ng-required="true" type="number" min="0.00" step="0.050">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Descripcion<i class="text-danger"></i></label>
                                                                <textarea ng-model="pedido.descripcion " class="form-control border border-primary" id="addProdDescrip" rows="4" placeholder="Descripción..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <center>
                                                                <div class="row" id="sincomprobante" class="bg-success">
                                                                    <p>
                                                                        <label for="pago_img" class="button-files  hollow">Subir comprobante +</label>
                                                                        <input onchange="angular.element(this).scope().uploadImgPago(event)" type="file" name="" id="pago_img" class="show-for-sr">
                                                                    </p>
                                                                    <div id="imagenPago">
                                                                    </div>
                                                                </div>
                                                                <div class="rew" ng-if="onEdit">
                                                                    <div ng-init="imagMPagoWeb()" id="imagenPago_edit">
                                                                    </div>
                                                                </div>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div ng-if="LoadPedido" class="w-100 d-flex justify-content-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <span class='ml-2'>Cargando...</span>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-danger mr-4" data-bs-dismiss="modal">Salir</button>

                        <div ng-if="btnatras">
                            <button type="button" class="btn btn-warning" ng-click="btnSiguiente(1)">Regresar</button>
                        </div>
                        <div ng-if="!button_sig">
                            <button type="button" class="btn btn-primary" ng-click="btnSiguiente(0)" ng-disabled="!pedidosForm.$valid">Siguiente</button>
                        </div>
                        <div ng-if="button_edit">
                            <button ng-if="!editNone" type="button" class="btn btn-success" ng-click="saveEditPedido()" ng-disabled="!pedidosForm.$valid">Editar</button>
                        </div>
                        <div ng-if="!onEdit">
                            <button type="button" ng-if="!button_post" class="btn btn-primary" ng-click="postPedidos()" ng-disabled="!pedidosForm.$valid">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- levanta detalle pago -->
    <div class="modal fade" id="ModalPago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Pago</h5>
                    <button type="button" class="btn-close btn bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Tipo Pago: {{metodo_pago.tipo}}</h5>
                            <h5 class="card-title">Monto: {{metodo_pago.monto | number : '2'}}</h5>
                        </div>
                        <center>
                            <img ng-show="metodo_pago!=null" ng-src="<?= URL_HOST_WEB ?>/{{metodo_pago.url_img}}" width="300">
                        </center>
                        <p class="card-title">
                            <strong>Descripcion:</strong> {{metodo_pago.descripcion}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- levanta detalle photos -->
    <div class="modal fade" id="ModalPhotos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Imagenes</h5>
                    <a href="<?= URL_HOST_WEB ?>/{{url_zip}}" target="_blank">
                        <button class="ml-4 btn btn-sm border border-primary btn-success">Descargar .zip</button>
                    </a>
                    <button type="button" class="btn-close btn bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- ng-if="photosValid" -->
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button ng-repeat="pho in photos" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$index}}" class="bg-success {{!$index ? 'active' : ''}}" aria-label="Slide {{$index+1}}"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item {{!$index ? 'active' : ''}}" ng-repeat="photo in photos">
                                <a href="<?= URL_HOST_WEB ?>/{{photo.url}}" download>
                                    <img ng-src="<?= URL_HOST_WEB ?>/{{photo.url}}" class="d-block w-100" alt="...">
                                    <center>
                                        <rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em"><strong>Descargar Imagen</strong></text>
                                    </center>
                                </a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>