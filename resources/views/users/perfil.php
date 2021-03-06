<div class="container border">
    <div class="">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="rounded-3 ">
                    <div class="row">
                        <div class="col-md-3 border border-primary border-top-0 border-bottom-0 border-start-0">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="public/assets/images/faces/1.jpg" alt="User profile picture">
                                    </div>
                                    <h3 class="profile-username text-center idnames_last" style="text-transform: uppercase;"></h3>

                                    <p class="text-muted text-center">Software Engineer</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Followers</b> <a class="float-right">1,322</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Following</b> <a class="float-right">543</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Friends</b> <a class="float-right">13,287</a>
                                        </li>
                                    </ul>

                                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">About Me</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">

                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                                    <p class="text-muted">Malibu, California</p>

                                    <hr>
                                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item w-25"><a class="nav-link rounded-0 border border-primary active" href="#chat" data-toggle="tab">Chat</a></li>
                                        <li class="nav-item w-25"><a class="nav-link rounded-0 border border-primary" href="#settings" data-toggle="tab">Settings</a></li>
                                        <li class="nav-item w-25"><a class="nav-link rounded-0 border border-primary" href="#activity" data-toggle="tab">Activity</a></li>
                                    </ul>
                                </div>
                                <!-- The chat -->
                                <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
                                <df-messenger intent="WELCOME" chat-title="helpdesk-contasoft" agent-id="f0ea39c1-475c-4dc2-9016-b0a4c830cae6" language-code="es"></df-messenger><!-- /.card-header -->
                                <div class="card-body pt-3 pl-2">
                                    <div class="tab-content">
                                        <!-- /.tab-pane -->
                                        <div class="active tab-pane" id="chat">
                                            <style>
                                                df-messenger {
                                                    --df-messenger-bot-message: #878fac;
                                                    --df-messenger-button-titlebar-color: #df9b56;
                                                    --df-messenger-chat-background-color: #fafafa;
                                                    --df-messenger-font-color: white;
                                                    --df-messenger-send-icon: #878fac;
                                                    --df-messenger-user-message: #479b3d;
                                                }
                                            </style>
                                            <iframe allow="microphone;" class="w-100" height="530" src="https://console.dialogflow.com/api-client/demo/embedded/f0ea39c1-475c-4dc2-9016-b0a4c830cae6">
                                            </iframe>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class=" tab-pane" id="settings">
                                            <form class="form-horizontal">
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Nambres</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Tipo Doc.</label>
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <select id="my-select" class="form-control" name="">
                                                                <option>DNI</option>
                                                                <option>RUC</option>
                                                                <option>PASAPORTE</option>
                                                                <option>C. EXTRANJERIA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">N. Documento</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputExperience" class="col-sm-2 col-form-label">Descripcion</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="inputExperience" placeholder="Descripcion"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputSkills" class="col-sm-2 col-form-label">Rubro</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="inputSkills" placeholder="Rubro">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="button" class="btn btn-danger">Guardar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class=" tab-pane" id="activity">
                                            <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg" alt="user image">
                                                    <span class="username">
                                                        <a href="#">Jonathan Burke Jr.</a>
                                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                    </span>
                                                    <span class="description">Shared publicly - 7:30 PM today</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    Lorem ipsum represents a long-held tradition for designers,
                                                    typographers and the like. Some people hate it and argue for
                                                    its demise, but others ignore the hate as they create awesome
                                                    tools to help create filler text for everyone from bacon lovers
                                                    to Charlie Sheen fans.
                                                </p>

                                                <p>
                                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                                    <span class="float-right">
                                                        <a href="#" class="link-black text-sm">
                                                            <i class="far fa-comments mr-1"></i> Comments (5)
                                                        </a>
                                                    </span>
                                                </p>

                                                <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                            </div>
                                            <!-- /.post -->

                                            <!-- Post -->
                                            <div class="post clearfix">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="https://adminlte.io/themes/v3/dist/img/user7-128x128.jpg" alt="User Image">
                                                    <span class="username">
                                                        <a href="#">Sarah Ross</a>
                                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                    </span>
                                                    <span class="description">Sent you a message - 3 days ago</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <p>
                                                    Lorem ipsum represents a long-held tradition for designers,
                                                    typographers and the like. Some people hate it and argue for
                                                    its demise, but others ignore the hate as they create awesome
                                                    tools to help create filler text for everyone from bacon lovers
                                                    to Charlie Sheen fans.
                                                </p>

                                                <form class="form-horizontal">
                                                    <div class="input-group input-group-sm mb-0">
                                                        <input class="form-control form-control-sm" placeholder="Response">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-danger">Send</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.post -->

                                            <!-- Post -->
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm" src="https://adminlte.io/themes/v3/dist/img/user6-128x128.jpg" alt="User Image">
                                                    <span class="username">
                                                        <a href="#">Adam Jones</a>
                                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                    </span>
                                                    <span class="description">Posted 5 photos - 5 days ago</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <div class="row mb-3">
                                                    <div class="col-sm-6">
                                                        <img class="img-fluid" src="https://www.nitro-pc.es/blog/wp-content/uploads/2017/08/edit-pc-school.jpg" alt="Photo">
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <img class="img-fluid mb-3" src="https://tenaxsoft.kayako.com/media/url/yQmGiEB82zAiQwyu7EW1N7AjBDFI4kt7" alt="Photo">
                                                                <img class="img-fluid" src="https://i.stack.imgur.com/ftxKd.png" alt="Photo">
                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-6">
                                                                <img class="img-fluid mb-3" src="https://i.stack.imgur.com/RL34F.png" alt="Photo">
                                                                <img class="img-fluid" src="https://i.stack.imgur.com/ftxKd.png" alt="Photo">
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->

                                                <p>
                                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                                    <span class="float-right">
                                                        <a href="#" class="link-black text-sm">
                                                            <i class="far fa-comments mr-1"></i> Comments (5)
                                                        </a>
                                                    </span>
                                                </p>

                                                <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                            </div>
                                            <!-- /.post -->
                                        </div>
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <p id="contextMenu"></p>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</div>