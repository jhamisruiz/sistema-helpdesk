<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/index/index.C.php');
class indexPage {
    public $index;
    public function ngindexPage(){
        $data = $this->index;
        $response = indexController::ENVIAREAYUDA($data);
        echo json_encode($response);
    }
}
/* ///////////////////////////////////
==== API REQUEST===
/////////////////////////////////// */
$request = json_decode(file_get_contents('php://input'), true);
//REGISTRAR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //GUARDAR-ACTUALIZA UNIDADES DE MEDIDA
    if ($_REQUEST['formulario'] == "POST") {
        $um = new indexPage();
        $um->index = $_REQUEST;
        $um->ngindexPage();
    }

}
