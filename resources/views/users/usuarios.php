<div class="container border" ng-app="usuarios-app" ng-controller="listUsuariosC">
    <div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-1">
                        <?php include_once('./resources/views/helpdesk/menu.php') ?>
                    </div>
                    <div class="col-lg-11">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5>Usuarios</h5>
                                <button type="button" class="btn bg-primary text-white" ng-click="resetForm()" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Usuario</button>
                            </div>
                            <div class="card-body ">
                                <div class="row colum-flex-rev">
                                    <div class="col-lg-2 mb-0 pb-0">
                                        <div class="mb-0  p-0 d-flex align-items-center">
                                            <h6 class="mr-3">Ver </h6>
                                            <select ng-change="setItemsPerPage(length)" class="form-control w-50" ng-model="length">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <h6 class="ml-3">Filas</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-0 pb-0">
                                        <div class="input-group mb-0 border border-primary rounded p-0">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input ng-model="search" ng-change="searchUsuarios()" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                                <th class="text-white bg-primary">Usuario</th>
                                                <th class="text-white bg-primary">Telefono</th>
                                                <th class="text-white bg-primary w-25">Fecha R</th>
                                                <th class="text-white bg-primary">Estado</th>
                                                <th class="text-white bg-primary">Passowrd</th>
                                                <th class="text-white bg-primary">Permisos</th>
                                                <th class="bg-primary text-white" style="max-width: 70px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="mostrarTrabajador">
                                            <tr ng-repeat="usuario in usuariosLists.slice(((currentPage-1)*itemsPerPage), ((currentPage)*itemsPerPage))">
                                                <td>{{usuario.index}}</td>
                                                <td>{{usuario.names }} {{usuario.last_name}}</td>
                                                <td>{{usuario.email}}</td>
                                                <td>{{usuario.user_name}}</td>
                                                <td>{{usuario.phone}}</td>
                                                <td>{{usuario.fecha_registro | date:'dd/MM/yyyy h:mm:ss'}}</td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" ng-click="activarUsuario(usuario.id,0,{$index})" ng-if="usuario.estado">Activado</button>
                                                    <button class="btn btn-danger btn-sm" ng-click="activarUsuario(usuario.id,1,{$index})" ng-if="!usuario.estado">Desactivado</button>
                                                </td>
                                                <td>
                                                    <button ng-click="openreset(usuario.id)" class="btn bg-warning text-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Reset Password</button>
                                                </td>
                                                <td>
                                                    <button ng-click="usuarioPermisos(usuario.id)" class="btn bg-info text-white btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalPerms">Roles</button>
                                                </td>
                                                <td class="d-flex justify-content-between">
                                                    <div class="dropdown dropdown-action">
                                                        <a class="action-icon " data-toggle="dropdown" aria-expanded="false">
                                                            Edit
                                                            <img src="dist/svg/arrow-down.svg" width="30">
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right border border-primary">
                                                            <a class="dropdown-item" ng-click="editUsuario(usuario.id)" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                                                <i class="bi bi-pen-fill text-success"></i> Edit</a>
                                                            <a class="dropdown-item" ng-click="deleteUsuario(usuario.id)">
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
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div id="contextMenu" idchat="0" class="context-menu" style="display:none">
            <ul>
                <li onclick="enviando(1)"><a>Hacer Critico</a></li>
                <li onclick="enviando(0)"><a>Quitar de Critico</a></li>
                <li><a>Archivar</a></li>
                <li>
                    <div class="dropdown">
                        <button class="btn btn-ligth dropdown-toggle w-100 p-0 m-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            Derivar a:
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><button class="dropdown-item" type="button">Helpdesk</button></li>
                            <li><button class="dropdown-item" type="button">Soporte</button></li>
                            <li><button class="dropdown-item" type="button">Area contable</button></li>
                            <li><button class="dropdown-item" type="button">Area Ventas</button></li>
                            <li><button class="dropdown-item" type="button">Area Redes</button></li>
                        </ul>
                    </div>
                </li>
                <li><a>Bloquear</a></li>
                <li><a>Eliminar</a></li>
            </ul>
        </div>
    </div>
    <!--Add MODAL -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div ng-controller="postUsuarios">
                    <div class="modal-header">
                        <h4 class="modal-title ">Formulario Usuario</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="pl-4 pr-4 pt-3">
                        <div ng-if="!formLoad" class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nombre <i class="text-danger">*</i> </label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.names" type="text" class="form-control border border-primary">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Apellidos <i class="text-danger">*</i> </label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.last_name" type="text" class="form-control border border-primary">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.email" type="email" class="form-control border border-primary">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.phone" type="text" class="form-control border border-primary">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Usuario <i class="text-danger">*</i> </label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.user_name" type="text" class="form-control border border-primary">
                                    </div>
                                </div>
                                <div class="form-group" ng-if="button_post">
                                    <label>Password <i class="text-danger">*</i> </label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.password" type="password" class="form-control border border-primary">
                                    </div>
                                </div>
                                <div class="form-group" ng-if="button_post">
                                    <label>Repit Password <i class="text-danger">*</i> </label>
                                    <div class="cal-icon">
                                        <input ng-model="usuario.rep_password" type="password" class="form-control border border-primary">
                                    </div>
                                </div>
                            </div>
                            <label class="text-danger mt-3">Campos obligatorios (*)</label>
                        </div>
                        <div ng-if="formLoad" class="w-100 d-flex justify-content-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <span class=' ml-2'>Cargando...</span>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer mt-3">
                        <div ng-if="button_edit">
                            <button type="button" class="btn btn-success" ng-click="saveEditUsuarios()">Editar</button>
                        </div>
                        <div ng-if="button_post">
                            <button type="button" class="btn btn-primary" ng-click="postUsuarios()">Guardar</button>
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- password -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" ng-controller="resetController">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nueva Passowrd:</label>
                            <input type="password" class="form-control border border-primary" ng-model="reset.password">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Repite Passowrd:</label>
                            <input type="password" class="form-control border border-primary" ng-model="reset.rep_password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" ng-click="saveResetP()" iduser="0">CAMBIAR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- permisos -->
    <div class="modal fade" id="exampleModalPerms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lista de Roles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <label><input type="checkbox" name="permisos[]" id="cbox1" value="1" ng-checked="1==permisos[0].id_permiso"> Helpdesk</label>
                    </div>
                    <div class="col-lg-12">
                        <label><input type="checkbox" name="permisos[]" id="cbox2" value="2" ng-checked="2==permisos[1].id_permiso"> Administracion</label>
                    </div>
                    <div class="col-lg-12">
                        <label><input type="checkbox" name="permisos[]" id="cbox3" value="3" ng-checked="3==permisos[2].id_permiso"> Ventas</label>
                    </div>
                    <div class="col-lg-12">
                        <label><input type="checkbox" name="permisos[]" id="cbox4" value="4" ng-checked="4==permisos[3].id_permiso"> Usuarios</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" ng-click="savePermisos(iduser)">GUARDAR</button>
                </div>
            </div>
        </div>
    </div>
</div>