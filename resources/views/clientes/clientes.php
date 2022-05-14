<div ng-app="clientes-app" ng-controller="listCtrClientes">
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Clientes</h5>
                    <button type="button" class="btn bg-primary text-white" ng-click="resetForm()" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Usuario</button>
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
                                <input ng-model="search" ng-change="searchClientes()" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>
                            <div id="smsearch" class="text-danger mb-0 pb-0"></div>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white">#</th>
                                    <th class="bg-primary text-white w-25">Nombres y App</th>
                                    <th class="bg-primary text-white">Email</th>
                                    <th class="text-white bg-primary">Telefono</th>
                                    <th class="text-white bg-primary">Doc. Tipo</th>
                                    <th class="text-white bg-primary">Doc. Numero</th>
                                    <th style="width: 15%;" class="text-white bg-primary">Fecha R</th>
                                    <th class="text-white bg-primary">Departamento</th>
                                    <th class="text-white bg-primary">Provinvia</th>
                                    <th class="text-white bg-primary">Distrito</th>
                                    <th class="text-white bg-primary">Direccion</th>
                                    <th class="text-white bg-primary">Referencia</th>
                                    <th class="bg-primary text-white" style="max-width: 70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="mostrarTrabajador">
                                <tr ng-repeat="cliente in clientesLists.slice(((currentPage-1)*itemsPerPage), ((currentPage)*itemsPerPage))">
                                    <td>{{cliente.index}}</td>
                                    <td>{{cliente.names}} {{cliente.last_name}}</td>
                                    <td>{{cliente.email}}</td>
                                    <td>{{cliente.phone}}</td>
                                    <td>{{cliente.description}}</td>
                                    <td>{{cliente.document_number}}</td>
                                    <td>{{cliente.date_create}}</td>
                                    <td>{{cliente.Departamento}}</td>
                                    <td>{{cliente.Provincia}}</td>
                                    <td>{{cliente.Distrito}}</td>
                                    <td>{{cliente.direccion}}</td>
                                    <td>{{cliente.referencia}}</td>
                                    <td>
                                        <div class="dropdown dropdown-action">
                                            <a class="action-icon " data-toggle="dropdown" aria-expanded="false">
                                                <img src="dist/svg/arrow-down.svg" width="30">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right border border-primary">
                                                <a class="dropdown-item" ng-click="openModalCliente($index,cliente.id)" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                                    <i class="bi bi-pen-fill text-success"></i> Edit</a>
                                                <a class="dropdown-item" ng-click="deleteUsuario(cliente.id)">
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
    <div class="modal fade text-left" ng-controller="postClientes" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <form class="" name="clientesForm" novalidate netlify>
                    <div class="modal-header">
                        <h4 class="modal-title ">Formulario Usuario</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="m-0" for="full-name">Nombre <i class="text-danger">*<i ng-show="clientesForm.names.$touched && clientesForm.names.$error.required">Este campo es requerido.</i></i></label>
                                        <input ng-model="cliente.names" name="names" type="text" placeholder="José" ng-required="true" class="form-control border border-primary" />
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="full-name">Apellido <i class="text-danger">*<i ng-show="clientesForm.last_name.$touched && clientesForm.last_name.$error.required">Este campo es requerido.</i></i></label>
                                        <input ng-model="cliente.last_name" name="last_name" type="text" placeholder="Luna" ng-required="true" class="form-control border border-primary" />
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="phone">Teléfono <i class="text-danger">*<i ng-show="clientesForm.phone.$touched && clientesForm.phone.$error.required">Este campo es requerido.</i></i></label>
                                        <input ng-model="cliente.phone" name="phone" type="text" placeholder="999999990" ng-required="true" class="form-control border border-primary" />
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="document-type">Tipo de documento <i class="text-danger">*<i ng-show="clientesForm.document_tipe.$touched && clientesForm.document_tipe.$error.required">Este campo es requerido.</i></i></label>
                                        <select ng-model="cliente.document_tipe" name="document_tipe" ng-required="true" class="form-control border border-primary">
                                            <option ng-value="" ng-selected="cliente.document_tipe===null">Elegir su tipo de documento:</option>
                                            <option ng-value="1" ng-selected="'1' == cliente.document_tipe">DNI</option>
                                            <option ng-value="2" ng-selected="'2' == cliente.document_tipe">Carnet extranjería</option>
                                            <option ng-value="3" ng-selected="'3' == cliente.document_tipe">RUC</option>
                                            <option ng-value="4" ng-selected="'4' == cliente.document_tipe">Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="document-number">N° documento <i class="text-danger">*<i ng-show="clientesForm.document_number.$touched && clientesForm.document_number.$error.required">Este campo es requerido.</i></i></label>
                                        <input ng-model="cliente.document_number" name="document_number" type="text" placeholder="71590144" ng-required="true" class="form-control border border-primary" />
                                    </div>

                                    <div class="form-group mt-4">
                                        <label class="m-0" for="email">Email <i class="text-danger">*<i ng-show="clientesForm.email.$touched && clientesForm.email.$error.required">Este campo es requerido.</i></i></label>
                                        <input ng-model="cliente.email" name="email" type="email" placeholder="me@example.com" ng-required="true" class="form-control border border-primary" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="m-0" for="departamento">Departamento <i class="text-danger">*<i ng-show="clientesForm.idDepartamento.$touched && clientesForm.idDepartamento.$error.required">Este campo es requerido.</i></i></label>
                                        <select ng-change="getProvincia()" name="idDepartamento" ng-model="cliente.idDepartamento" ng-required="true" class="form-control border border-primary">
                                            <option value="">Elegir Departamento:</option>
                                            <option ng-repeat="Depart in Departamento" value="{{Depart.id_ubigeo}}">{{Depart.Departamento}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label class="m-0" for="provincia">Provincia <i class="text-danger">*<i ng-show="clientesForm.idProvincia.$touched && clientesForm.idProvincia.$error.required">Este campo es requerido.</i></i></label>
                                        <select ng-change="getDistrito()" name="idProvincia" ng-model="cliente.idProvincia" ng-required="true" class="form-control border border-primary">
                                            <option value="">Elegir Provincia:</option>
                                            <option ng-repeat="Prov in Provincia" value="{{Prov.id_ubigeo}}">{{Prov.Provincia}}
                                            <option ng-if="onEdit" ng-selected="onEdit===true" ng-value="cliente.idProvincia">{{cliente.Provincia}}</option>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="ubigeo">Distrito <i class="text-danger">*<i ng-show="clientesForm.id_ubigeo.$touched && clientesForm.id_ubigeo.$error.required">Este campo es requerido.</i></i></label>
                                        <select ng-model="cliente.id_ubigeo" name="id_ubigeo" ng-required="true" class="form-control border border-primary">
                                            <option value="">Elegir Distrito:</option>
                                            <option ng-repeat="Dis in Distrito" value="{{Dis.id_ubigeo}}">{{Dis.Distrito}}
                                            <option ng-if="onEdit" ng-selected="onEdit===true" ng-value="cliente.id_ubigeo">{{cliente.Distrito}}</option>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="address">Dirección <i class="text-danger">*<i ng-show="clientesForm.direccion.$touched && clientesForm.direccion.$error.required">Este campo es requerido.</i></i></label>
                                        <input ng-model="cliente.direccion" name="direccion" type="text" placeholder="Dirección " ng-required="true" class="form-control border border-primary" />
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="m-0" for="reference-address">Referencia</label>
                                        <input ng-model="cliente.referencia" type="text" placeholder="Referencia del lugar" class="form-control border border-primary" />
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <label ng-show="!clientesForm.$valid">
                                    <h6 class="text-danger mt-4">Campos obligatorios (*)</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-danger mr-4" data-bs-dismiss="modal">Salir</button>
                        <div ng-if="button_edit">
                            <button type="button" class="btn btn-success" ng-click="saveEditUsuarios()" ng-disabled="!clientesForm.$valid">Editar</button>
                        </div>
                        <div ng-if="button_post">
                            <button type="button" class="btn btn-primary" ng-click="postClientes()" ng-disabled="!clientesForm.$valid">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>