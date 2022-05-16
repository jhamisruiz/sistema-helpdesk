<div ng-app="usuarios-app" ng-controller="listUsuariosC">
    <div class="page-heading">
        <section class="section">
            <div class="container">
                <div class="card table-responsive">
                    <div class="row">
                        <div class="col-lg-6">
                            <style>
                                @import 'https://fonts.googleapis.com/css?family=Open+Sans';

                                #myChartPedidos {
                                    width: 100%;
                                    height: 100%;
                                    min-height: 450px;
                                }
                            </style>

                            <div id='myChartPedidos'></div>
                            <script>
                                ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "b55b025e438fa8a98e32482b5f768ff5"];
                                var myConfig = {
                                    type: "pie",
                                    plot: {
                                        borderColor: "#2B313B",
                                        borderWidth: 5,
                                        // slice: 90,
                                        valueBox: {
                                            placement: 'out',
                                            text: '%t\n%npv%',
                                            fontFamily: "Open Sans"
                                        },
                                        tooltip: {
                                            fontSize: '18',
                                            fontFamily: "Open Sans",
                                            padding: "5 10",
                                            text: "%npv%"
                                        },
                                        animation: {
                                            effect: 2,
                                            method: 5,
                                            speed: 900,
                                            sequence: 1,
                                            delay: 3000
                                        }
                                    },
                                    source: {
                                        text: 'inntec.pe',
                                        fontColor: "#8e99a9",
                                        fontFamily: "Open Sans"
                                    },
                                    title: {
                                        fontColor: "#8e99a9",
                                        text: 'Resumen de Pedidos',
                                        align: "left",
                                        offsetX: 10,
                                        fontFamily: "Open Sans",
                                        fontSize: 25
                                    },
                                    subtitle: {
                                        offsetX: 10,
                                        offsetY: 10,
                                        fontColor: "#8e99a9",
                                        fontFamily: "Open Sans",
                                        fontSize: "16",
                                        text: '',
                                        align: "left"
                                    },
                                    plotarea: {
                                        margin: "20 0 0 0"
                                    },
                                    series: [{
                                            values: [11.38],
                                            text: "Aceptados",
                                            backgroundColor: '#435ebe',
                                        },
                                        {
                                            values: [40.94],
                                            text: "Pendientes",
                                            backgroundColor: '#0dcaf0',
                                            detached: true
                                        },
                                        {
                                            values: [14.52],
                                            text: 'En proceso',
                                            backgroundColor: '#FFCB45',
                                            detached: true
                                        },
                                        {
                                            text: 'Cancelado',
                                            values: [9.69],
                                            backgroundColor: '#dc3545'
                                        },
                                        {
                                            text: 'Entregados',
                                            values: [23.48],
                                            backgroundColor: '#6FB07F'
                                        }
                                    ]
                                };

                                zingchart.render({
                                    id: 'myChartPedidos',
                                    data: myConfig,
                                    height: '100%',
                                    width: '100%'
                                });
                            </script>
                        </div>
                        <div class="col-lg-6">
                            <?php #echo json_encode($_SESSION["permisos"]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>