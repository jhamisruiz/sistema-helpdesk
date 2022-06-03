<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/helpdesk/helpdesk.C.php');
class helpdeskChat
{
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
}
/* ///////////////////////////////////
==== API REQUEST===
/////////////////////////////////// */
$request = json_decode(file_get_contents('php://input'), true);
/*=============================================
---LISTAR DATOS DE LA chats
=============================================*/
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //echo json_encode($_GET);
    // UNIDADES DE MEDIDA
    if (isset($_GET["lschat"]) && $_GET["lschat"] == true) {
        $gchat = new helpdeskChat();
        $gchat->chat = $_GET["lschat"];
        $gchat->nghelpdeskChat();
    }
    // UNIDADES DE MEDIDA
    if (isset($_GET["chat"]) && $_GET["chat"]  == "lsf2dChat") {
        $gchat = new helpdeskChat();
        $gchat->f2fchat = $_GET["start"];
        $gchat->ngf2fChat();
    }
}
