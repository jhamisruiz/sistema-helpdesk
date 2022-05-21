<div class="container border">
    <div ng-app="app-helpdesk" ng-controller="ctrHelpdesk">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-1">
                        <nav class="menu p-2">
                            <img width="54px" height="54px" class="rounded-circle" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80">
                        </nav>
                        <nav class="menu  ">
                            <ul class="items">
                                <li class="item">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </nav>
                        <nav class="menu  ">
                            <ul class="items">
                                <li class="item">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </nav>
                        <nav class="menu  ">
                            <ul class="items">
                                <li class="item">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </nav>
                        <nav class="menu  ">
                            <ul class="items">
                                <li class="item item-active">
                                    <i class="fa fa-commenting" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </nav>
                        <nav class="menu  ">
                            <ul class="items">
                                <li class="item">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </nav>
                        <nav class="menu  ">
                            <ul class="items">
                                <li class="item">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </nav>
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

                            <div class="discussion">
                                <div class="photo" style="background-image: url(https://i.pinimg.com/originals/a9/26/52/a926525d966c9479c18d3b4f8e64b434.jpg);">
                                    <div class="online"></div>
                                </div>
                                <div class="desc-contact">
                                    <p class="name">Dave Corlew</p>
                                    <p class="message">Let's meet for a coffee or something today ?</p>
                                </div>
                                <div class="timer">3 min</div>
                            </div>

                            <div class="discussion">
                                <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1497551060073-4c5ab6435f12?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=667&q=80);">
                                </div>
                                <div class="desc-contact">
                                    <p class="name">Jerome Seiber</p>
                                    <p class="message">I've sent you the annual report 😳</p>
                                </div>
                                <div class="timer">42 min</div>
                            </div>
                        </section>
                        <section class="discussions">
                            <div class="card m-0 rounded-0 border border-2">
                                <div class="pl-4 pr-4 pt-4  d-flex justify-content-between">
                                    <h4 class="w-50">Pendientes</h4>
                                    <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class=" discussion ">
                                <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80);">
                                    <div class="online"></div>
                                </div>
                                <div class="desc-contact">
                                    <p class="name">Megan Leib</p>
                                    <p class="message">9 pm at the bar if possible 😳</p>
                                </div>
                                <div class="timer">12 sec</div>
                            </div>

                            <div class="discussion">
                                <div class="photo" style="background-image: url(https://i.pinimg.com/originals/a9/26/52/a926525d966c9479c18d3b4f8e64b434.jpg);">
                                    <div class="online"></div>
                                </div>
                                <div class="desc-contact">
                                    <p class="name">Dave Corlew</p>
                                    <p class="message">Let's meet for a coffee or something today ?</p>
                                </div>
                                <div class="timer">3 min</div>
                            </div>

                            <div class="discussion">
                                <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1497551060073-4c5ab6435f12?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=667&q=80);">
                                </div>
                                <div class="desc-contact">
                                    <p class="name">Jerome Seiber</p>
                                    <p class="message">I've sent you the annual report</p>
                                </div>
                                <div class="timer">42 min</div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-6 border border-primary p-0">
                        <section class="chat ">
                            <div class="header-chat">
                                <i class="icon fa fa-user-o" aria-hidden="true"></i>
                                <p class="name">Megan Leib</p>
                                <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                            </div>
                            <div class="messages-chat">
                                <div class="message">
                                    <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80);">
                                        <div class="online"></div>
                                    </div>
                                    <p class="text"> Hi, how are you ? </p>
                                </div>
                                <div class="message text-only">
                                    <p class="text"> What are you doing tonight ? Want to go take a drink ?</p>
                                </div>
                                <p class="time"> 14h58</p>
                                <div class="message text-only">
                                    <div class="response">
                                        <p class="text"> Hey Megan ! It's been a while 😃</p>
                                    </div>
                                </div>
                                <div class="message text-only">
                                    <div class="response">
                                        <p class="text"> When can we meet ?</p>
                                    </div>
                                </div>
                                <p class="response-time time"> 15h04</p>
                                <div class="message">
                                    <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80);">
                                        <div class="online"></div>
                                    </div>
                                    <p class="text"> 9 pm at the bar if possible 😳</p>
                                </div>

                                <p class="time"> 15h09</p>
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
</div>