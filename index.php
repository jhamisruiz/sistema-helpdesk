<?php
if (file_exists('.env')) {
        require "app/php/Core.php";

        APP_DIRS::GET_ALL_APP_DIRS('app/config', 'require', 'php');

        APP_DIRS::GET_ALL_APP_DIRS('app/controllers', 'require_once', 'php');
        APP_DIRS::GET_ALL_APP_DIRS('app/models', 'require_once', 'php');
} else {
        echo 'archivo de configiguracion .evn no EXISTE!';
        exit;
}

$main = new ControllerMain();
$main->ctrMain();

//or 1=1;--';