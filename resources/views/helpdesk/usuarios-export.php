<div class="container border">
    <div ng-app="export-Files-users" ng-controller="exporttoFiles">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-1">
                        <?php include_once('menu.php') ?>
                    </div>
                    <div class="col-lg-11">
                        <div class="card-body border w-100">
                            <div class="row">
                                <div class="col-lg-3 mb-2 pb-0">
                                    <div class="mb-0  p-0 d-flex align-items-center">
                                        <h6 class="mr-3">Desde </h6>
                                        <input type="date" ng-change="searchPrint()" id="exampleInput" ng-model="print.desde" placeholder="DD/MM/YY" min="2013-01-01" max="2050-12-31" class="form-control border border-primary w-100">
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-2 pb-0">
                                    <div class="mb-0  p-0 d-flex align-items-center">
                                        <h6 class="mr-3">Hasta </h6>
                                        <input type="date" ng-change="searchPrint()" id="exampleInput" ng-model="print.hasta" placeholder="DD/MM/YY" min="2013-01-01" max="2050-12-31" class="form-control border border-primary w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="example1" class="table table-hover ">
                                    <thead>
                                        <tr>
                                            <th class="bg-primary text-white">#</th>
                                            <th class="bg-primary text-white ">Nombres</th>
                                            <th class="bg-primary text-white ">Apellidos</th>
                                            <th class="bg-primary text-white">Email</th>
                                            <th class="text-white bg-primary">Usuario</th>
                                            <th class="text-white bg-primary">Telefono</th>
                                            <th class="text-white bg-primary">Fecha R</th>
                                            <th class="text-white bg-primary">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Page specific script -->
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
                <li><a>Bloquear</a></li>
                <li><a>Eliminar</a></li>
            </ul>
        </div>
    </div>
</div>