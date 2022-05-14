<div ng-app="export-exel" ng-controller="exporttoexel" class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Exportar Pedidos</h5>
            </div>
            <div class="card-body ">
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
                    <table id="example1" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white ">Nombres</th>
                                <th class="bg-primary text-white ">Apelldios</th>
                                <th class="bg-primary text-white">Telefono</th>
                                <th class="bg-primary text-white">Ubigeo</th>
                                <th class="bg-primary text-white">Direccion</th>
                                <th class="bg-primary text-white">Referencia</th>
                                <th class="bg-primary text-white">Tipo Envio</th>
                                <th class="bg-primary text-white">Precio</th>
                                <th class="bg-primary text-white">Tipo Pago</th>
                                <th style="width: 18%;" class="bg-primary text-white">Desc.P</th>
                                <th class="text-white bg-primary">Cod. Pedido</th>
                                <th class="text-white bg-primary">Fecha Reg</th>
                                <th class="text-white bg-primary">Fecha Ent</th>
                                <th class="text-white bg-primary">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Page specific script -->
            </div>
        </div>
    </section>
</div>