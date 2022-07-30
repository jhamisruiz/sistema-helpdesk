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

    public $respuesta;
    public function ngRespuesta()
    {
        $data = $this->respuesta;
        $res = json_decode($data['data'], true);

        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        $insert = array(
            "table" => "chat", #nombre de tabla
            "id_cliente" => $res["id_cliente"],
            "mensaje" => $res["message"],
            "visto" => 0,
            "estado" => 1,
            "id_helpdesk" => $res["id_helpdesk"],
            "fecha_registro" => $fecha,
            "prioridad" => $res["prioridad"],
        );

        $response = ControllerQueryes::INSERT($insert);
        echo json_encode($res);
    }
    public $cliente;
    public function ngRespuestaCliente()
    {
        $data = $this->cliente;
        $res = json_decode($data['data'], true);

        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        $insert = array(
            "table" => "chat", #nombre de tabla
            "id_cliente" => $res["id_cliente"],
            "mensaje" => $res["message"],
            "visto" => 0,
            "estado" => 1,
            "fecha_registro" => $fecha,
            "prioridad" => $res["prioridad"],
        );

        $response = ControllerQueryes::INSERT($insert);
        echo json_encode($res);
    }
    public $critico;
    public function ngcriticos()
    {
        $data = $this->critico;
        $res = json_decode($data['data'], true);

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

    public $otras;
    public function OtraAea()
    {
        $data = $this->otras;
        $res = json_decode($data['data'], true);

        $update = array(
            "table" => "chat", #nombre de tabla
            "id_area" => $res["id_area"],
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
    //G 
    if ($_REQUEST['formulario'] == "POSTRESPUESTA") {
        $rr = new helpdeskChat();
        $rr->respuesta = $_REQUEST;
        $rr->ngRespuesta();
    }

    if ($_REQUEST['formulario'] == "POSTCLIENTE") {
        $rc = new helpdeskChat();
        $rc->cliente = $_REQUEST;
        $rc->ngRespuestaCliente();
    }

    if ($_REQUEST['formulario'] == "POSTC") {
        $um = new helpdeskChat();
        $um->critico = $_REQUEST;
        $um->ngcriticos();
    }

    if ($_REQUEST['formulario'] == "OTROS") {
        $otr = new helpdeskChat();
        $otr->otras = $_REQUEST;
        $otr->OtraAea();
    }
}
/*=============================================
---LISTAR DATOS DE LA chats
=============================================*/
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // UNIDADES DE MEDIDA
    if (isset($_GET["length"]) && $_GET["length"] == "prioridad") {
        $pchat = new helpdeskChat();
        $pchat->prioridad = $_GET["search"];
        $pchat->ngPrioridad();
    }
    // UNIDADES DE MEDIDA
    if (isset($_GET["length"]) && $_GET["length"] == "lsChat") {
        $gchat = new helpdeskChat();
        $gchat->chat = $_GET["search"];
        $gchat->nghelpdeskChat();
    }
    // UNIDADES DE MEDIDA
    if (isset($_GET["length"]) && $_GET["length"] == "lsf2dChat") {
        $gchat = new helpdeskChat();
        $gchat->f2fchat = $_GET["start"];
        $gchat->ngf2fChat();
    }
}
