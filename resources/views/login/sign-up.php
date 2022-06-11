<div id="auth" ng-app="app-SignUp" ng-controller="ctrSign">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="index.html"><img src="<?= APP_LOGO ?>" style="height:80px" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Registro</h1>
                <p class="auth-subtitle mb-5">Ingrese sus datos para crear una cuenta.</p>
                <form name="signForm" novalidate netlify autocomplete="off">
                    <label for="phone" class="text-danger m-0"><i ng-show="signForm.phone.$touched && signForm.phone.$error.required">Ingresa un Telefono.</i></label>
                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="text" ng-model="crear.phone" name="phone" class="form-control form-control-xl" placeholder="Telefono" ng-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                    </div>
                    <label for="user_name" class="text-danger m-0"><i ng-show="signForm.user_name.$touched && signForm.user_name.$error.required">Ingresa tu Usuario.</i></label>
                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="text" ng-model="crear.user_name" name="user_name" class="form-control form-control-xl" placeholder="Usuario" ng-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-2">
                        <label for="email" class="text-danger m-0"><i ng-show="signForm.email.$touched && signForm.email.$error.required">Ingresa un Email.</i></label>
                        <input type="email" ng-model="crear.email" name="email" class="form-control form-control-xl" placeholder="Email" ng-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-2">
                        <label for="password" class="text-danger m-0"><i ng-show="signForm.password.$touched && signForm.password.$error.required">Ingresa una Contraseña.</i></label>
                        <input type="password" ng-model="crear.password" name="password" class="form-control form-control-xl" placeholder="Password" ng-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-2">
                        <label for="rep_password" class="text-danger m-0"><i ng-show="signForm.rep_password.$touched && signForm.rep_password.$error.required">Confirma Contraseña.</i></label>
                        <input type="password" ng-model="crear.rep_password" name="rep_password" class="form-control form-control-xl" placeholder="Confirmar Password" ng-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <p id="contextMenu" class="text-danger"></p>
                    <p id="resRegistro" class="text-success">{{confirm}}</p>
                    <button type="button" ng-click="guardarUser()" class="btnRegistro btn btn-primary btn-block btn-lg shadow-lg mt-3" ng-disabled="!signForm.$valid">
                        <span>Registrar</span>
                    </button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Ya tienes una cuenta? <a href="login" class="font-bold">Login</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
            </div>
        </div>
    </div>
</div>