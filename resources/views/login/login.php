<div id="sidebar" class="d-none"></div>
<?php
//session_destroy(); 
?>
<div id="auth" ng-app="export-Login-users" ng-controller="ctrLogin">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a><img src="https://notion-emojis.s3-us-west-2.amazonaws.com/prod/svg-twitter/1f916.svg" style="height:80px" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Login</h1>
                <h5 ng-if="loginOK" class="text-success">Bienvenido {{loginOK}}
                    <?php ?>
                </h5>
                <?php ?>
                <p class="auth-subtitle mb-2">Inicie sesión.</p>
                <form name="loginForm" novalidate netlify autocomplete="off">
                    <label for="usuario" class="text-danger"><i ng-show="loginForm.usuario.$touched && loginForm.usuario.$error.required">Ingresa tu usuario.</i></label>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input ng-model="login.usuario" name="usuario" type="text" class="form-control form-control-xl" ng-required="true" placeholder="Usuario" autocomplete="off">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <label for="password" class="text-danger"><i ng-show="loginForm.password.$touched && loginForm.password.$error.required">Ingresa tu password.</i></label>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input ng-model="login.password" type="password" class="form-control form-control-xl" ng-required="true" name="password" placeholder="Password" autocomplete="off">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <h5 ng-if="error" class="text-danger">{{error}}</h5>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" autocomplete="off">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">Mantenme conectado</label>
                    </div>
                    <button ng-click="LoginFunc()" onke type="button" class="btn btn-primary btn-block btn-lg shadow-lg mt-5 btnLogin" ng-disabled="!loginForm.$valid">Login</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 ">
            <div id="auth-right">
            </div>
        </div>
    </div>
</div>