<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/helpdesk/helpdesk.C.php');
class helpdeskChat
{
    public $prioridad;
    public function ngPrioridad()
    {
        $prioridad = $this->prioridad;
        $response = helpdeskController::LISTCHAT($prioridad);
        echo json_encode($response);
    }

    public $chat;
    public function nghelpdeskChat()
    {
        $data = $this->chat;
        $response = helpdeskController::LISTCHAT($data);
        echo json_encode($response);
    }

    public $f2fchat;
    public function ngf2fChat()
    {
        $data = $this->f2fchat;
        $response = helpdeskController::LISTF2FCHAT($data);
        echo json_encode($response);
    }

    public $critico;
    public function ngcriticos()
    {
        $data = $this->critico;
        $res=json_decode($data['data'], true);

        $update = array(
            "table" => "chat", #nombre de tabla
            "prioridad" => $res["prioridad"], 
        );
        $where = array(
            "id_cliente" => $res["id"], #condifion columna y valor
        );

        $response = ControllerQueryes::UPDATE($update, $where);
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
    if ($_REQUEST['formulario'] == "POSTC") {
        $um = new helpdeskChat();
        $um->critico = $_REQUEST;
        $um->ngcriticos();
    }
}
/*=============================================
---LISTAR DATOS DE LA chats
=============================================*/
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // UNIDADES DE MEDIDA
    if (isset($_GET["length"]) && $_GET["length"] == "prioridad") {
        $pchat = new helpdeskChat();
        $pchat->prioridad = 1;
        $pchat->ngPrioridad();
    }
    // UNIDADES DE MEDIDA
    if (isset($_GET["length"]) && $_GET["length"] == "lsChat") {
        $gchat = new helpdeskChat();
        $gchat->chat = 0;
        $gchat->nghelpdeskChat();
    }
    // UNIDADES DE MEDIDA
    if (isset($_GET["length"]) && $_GET["length"] == "lsf2dChat") {
        $gchat = new helpdeskChat();
        $gchat->f2fchat = $_GET["start"];
        $gchat->ngf2fChat();
    }
}
