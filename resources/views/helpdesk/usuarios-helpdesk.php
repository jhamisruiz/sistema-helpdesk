<div class="container border">
    <div ng-app="app-helpdesk" ng-controller="ctrHelpdesk">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-1">
                        <?php include_once('menu.php') ?>
                    </div>
                    <div class="col-lg-5">
                        <section class="discussions">
                            <div class="discussion search ">
                                <div class="searchbar border border-primary">
                                    <i class="fa fa-search text-dark" aria-hidden="true"></i>
                                    <input type="text" placeholder="Search..." class="input-chat">
                                </div>
                            </div>
                            <div class="card m-0 rounded-0 border border-2">
                                <div class="pl-4 pr-4 pt-4  d-flex justify-content-between">
                                    <h4 class="w-50">Criticos</h4>
                                    <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="discussion " ng-repeat="lc in listPrioridad" ng-click="f2fChat(lc.id_cliente)" id="{{lc.id_cliente}}" ng-contextmenu visible="isVisible" ng-if="lc.prioridad">
                                <div class="photo border border-info" id="{{lc.id_cliente}}" style="background-image: url(https://e7.pngegg.com/pngimages/146/551/png-clipart-user-login-mobile-phones-password-user-miscellaneous-blue-thumbnail.png);">
                                    <div class="online" id="{{lc.id_cliente}}"></div>
                                </div>
                                <div class="desc-contact" id="{{lc.id_cliente}}">
                                    <p class="name" id="{{lc.id_cliente}}">{{lc.razon_social }} - {{lc.names }} {{lc.last_name}}</p>
                                    <p class="message" id="{{lc.id_cliente}}">{{lc.mensaje }}</p>
                                </div>
                                <div class="timer" id="{{lc.id_cliente}}">{{lc.fecha_registro }}</div>
                            </div>
                        </section>
                        <section class="discussions">
                            <div class="card m-0 rounded-0 border border-2">
                                <div class="pl-4 pr-4 pt-4  d-flex justify-content-between">
                                    <h4 class="w-50">Pendientes</h4>
                                    <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="discussion " ng-repeat="lc in listChats" ng-click="f2fChat(lc.id_cliente)" id="{{lc.id_cliente}}" ng-contextmenu visible="isVisible" ng-if="!lc.prioridad">
                                <div class="photo border border-info" id="{{lc.id_cliente}}" style="background-image: url(https://e7.pngegg.com/pngimages/146/551/png-clipart-user-login-mobile-phones-password-user-miscellaneous-blue-thumbnail.png);">
                                    <div class="online" id="{{lc.id_cliente}}"></div>
                                </div>
                                <div class="desc-contact" id="{{lc.id_cliente}}">
                                    <p class="name" id="{{lc.id_cliente}}">{{lc.razon_social }} - {{lc.names }} {{lc.last_name}}</p>
                                    <p class="message" id="{{lc.id_cliente}}">{{lc.mensaje }}</p>
                                </div>
                                <div class="timer" id="{{lc.id_cliente}}">{{lc.fecha_registro }}</div>
                            </div>

                        </section>
                    </div>
                    <!-- SECCION DE CHAT F2F -->
                    <div class="col-lg-6 border border-primary p-0">
                        <section class="chat ">
                            <div class="header-chat">
                                <i class="icon fa fa-user-o" aria-hidden="true"></i>
                                <p class="name">{{userNames}}</p>
                                <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                            </div>
                            <div class="messages-chat" style="height: 425px;overflow-y: scroll;">
                                <div ng-repeat="lf in listf2fChat">
                                    <div class="message">
                                        <div class="photo border border-info" style="background-image: url(https://e7.pngegg.com/pngimages/146/551/png-clipart-user-login-mobile-phones-password-user-miscellaneous-blue-thumbnail.png);">
                                            <div class="online"></div>
                                        </div>
                                        <p class="text">{{lf.mensaje}} </p>

                                    </div>
                                    <div class="message text-only">
                                        <p class=""></p>
                                        <div class="w-100 d-flex flex-wrap" ng-if="lf.img_length">

                                            <div ng-repeat="img in lf.imagenes">
                                                <img ng-src="<?= URL_HOST_WEB ?>/{{img.url_img}}" width="500">
                                            </div>
                                        </div>

                                    </div>
                                    <p class="time"> {{lf.fecha_registro}}</p>
                                </div>
                                <div class="message text-only" ng-if="form.send">
                                    <div class="response">
                                        <p class="text"> {{form.send}}</p>
                                    </div>
                                </div>
                                <p class="response-time time" ng-if="form.send"> 15h04</p>
                            </div>
                            <div class="footer-chat border border-primary">
                                <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
                                <textarea ng-model="form.message" type="text" class="write-message w-100" placeholder="Type your message here"></textarea>
                                <i class="material-icons" style="font-size:36px">attach_file</i>
                                <i ng-click="sendmsm()" class="icon send fa fa-paper-plane-o clickable" aria-hidden="true"></i>
                            </div>
                        </section>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
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
                        <li><button class="dropdown-item" type="button">Action</button></li>
                        <li><button class="dropdown-item" type="button">Another action</button></li>
                        <li><button class="dropdown-item" type="button">Something else here</button></li>
                    </ul>
                </div>
            </li>
            <li><a>Bloquear</a></li>
            <li><a>Eliminar</a></li>
        </ul>
    </div>
</div>