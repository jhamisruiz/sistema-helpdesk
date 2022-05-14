<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/config/config.C.php');
class ajaxConfiguraciones
{
/*=============================================
        UBIGEO
=============================================*/
    public $ubigeo;
    public function ajaxUbigeo()
    {
        $data = $this->ubigeo;
 
        $response = ControllerUbigeo::UBIGEO($data);
        
        header("HTTP/1.1 200 OK");
        if (isset($response[0]) && $response[0] == 'S') {
            header("HTTP/1.1 500 ERROR");
        }else{
            header("HTTP/1.1 202 !");
        }
        echo json_encode($response);
    }

}

/* ==== API REQUEST===   */
$request = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // list departamento
    if (isset($_GET["departamento"])) {
        $list = new ajaxConfiguraciones();
        $list->ubigeo = ["Departamento"=>$_GET["departamento"]];
        $list->ajaxUbigeo();
    }
    // list provincia
    if (isset($_GET["provincia"])) {
        $list = new ajaxConfiguraciones();
        $list->ubigeo = ["Provincia"=> $_GET["provincia"]];
        $list->ajaxUbigeo();
    }
    // list distrito
    if (isset($_GET["distrito"])) {
        $list = new ajaxConfiguraciones();
        $list->ubigeo = ["Distrito"=> $_GET["distrito"]];
        $list->ajaxUbigeo();
    }
}