<div ng-app="app-Index" ng-controller="ctrIndex">
    <div class="page-heading">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="{{ chatValid ? 'container rounded-3 border border-primary':''}}">
                    <div class="row d-flex justify-content-center {{!chatValid?'d-block':'d-none'}}">
                        <div class="col-lg-6 p-0 border border-primary">
                            <section class="chat ">
                                <div class="header-chat">
                                    <i class="icon fa fa-user-o" aria-hidden="true"></i>
                                    <p class="name">{{userNames}}</p>
                                    <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                                </div>
                                <div id="messageschat" class="messages-chat mb-5" style="height: 400px;overflow-y: scroll;">
                                    <div ng-repeat="lf in listf2fChats">
                                        <div ng-if="!lf.id_helpdesk">
                                            <div class="message text-only">
                                                <div class="response d-flex">
                                                    <div class="photo border border-info" style="background-image: url(https://e7.pngegg.com/pngimages/146/551/png-clipart-user-login-mobile-phones-password-user-miscellaneous-blue-thumbnail.png);">
                                                        <div class="online"></div>
                                                    </div>
                                                    <p class="text text-light bg-success">{{lf.mensaje}} </p>
                                                </div>
                                            </div>
                                            <div class="message text-only" ng-if="lf.imagenes.length">
                                                <div class="response">
                                                    <p class=""></p>
                                                    <div class="w-100 d-flex justify-content-end flex-wrap" ng-if="lf.img_length">

                                                        <div ng-repeat="img in lf.imagenes">
                                                            <img ng-src="<?= URL_HOST_WEB ?>/{{img.url_img}}" width="500">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="time d-flex justify-content-end text-info"> {{lf.fecha_registro}}</p>
                                        </div>
                                        <div ng-if="lf.id_helpdesk !==null">
                                            <div class="message text-only">
                                                <div>
                                                    <p class="text text-light bg-secondary"> {{lf.mensaje}}</p>
                                                </div>
                                            </div>
                                            <p class="time d-flex justify-content-start text-info"> {{lf.fecha_registro}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-chat border border-primary" onclick="scrollChatBottom()">
                                    <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
                                    <textarea ng-model="form.message" type="text" class="write-message w-100" placeholder="Type your message here" onclick="scrollChatBottom()" onkeyup="scrollChatBottom()"></textarea>
                                    <label class="material-icons" style="font-size:36px" for="fileFromChat">attach_file</label>
                                    <input type="file" class="d-none" id="fileFromChat" style="width: 10px">
                                    <i ng-click="sendmsm()" class="icon send fa fa-paper-plane-o clickable" aria-hidden="true" onclick="scrollChatBottom()"></i>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- ------------------------ -->
                    <form name="indexForm" novalidate netlify class="{{chatValid?'d-block':'d-none'}}">
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
                                    <button ng-click="enviar();scrollChatBottom(0);" onclick="scrollChatBottom()" type="button" class="btn btn-primary w-25" ng-disabled="!indexForm.$valid">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <p id="contextMenu"></p>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</div>