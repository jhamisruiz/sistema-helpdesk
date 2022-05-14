<div ng-app="export-Files-clientes" ng-controller="exporttoFiles" class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Exportar Clientes</h5>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-lg-3 mb-2 pb-0">
                        <div class="mb-0  p-0 d-flex align-items-center">
                            <h6 class="mr-3">Desde </h6>
                            <input type="date" ng-change="searchPrint()" id="exampleInput" ng-model="print.desde" placeholder="DD/MM/YY" class="form-control border border-primary w-100">
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2 pb-0">
                        <div class="mb-0  p-0 d-flex align-items-center">
                            <h6 class="mr-3">Hasta </h6>
                            <input type="date" ng-change="searchPrint()" id="exampleInput" ng-model="print.hasta" placeholder="DD/MM/YY" class="form-control border border-primary w-100">
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="tableClientes" class="table table-hover ">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white ">Nombres</th>
                                <th class="bg-primary text-white ">Apellidos</th>
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
    </section>
</div>