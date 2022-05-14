<?php
//session_start();
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/users/usuarios.C.php');
include('./../../../models/users/usuarios.M.php');
class ajaxUsuarios
{
    /*=============================================
        LIST USUARIOS
=============================================*/
    public $lsUsuario;
    public function ajaxListUsarios()
    {
        $data = $this->lsUsuario;
        $response = ControllerUsuariosList::SELECTALL($data);
        if (isset($response[0]) && $response[0] == 'S') {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
    /*=============================================
        POST USUARIOS
=============================================*/
    public $postUsuario;
    public function ajaxPostUsuarios()
    {
        $data = $this->postUsuario;
        $response = ControllerUsuariosList::GUARDAR($data);
        if ($response == 'OK') {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 ERROR-MSQL");
        }
        echo json_encode($response);
    }
    /*=============================================
        POST PERMISOS
=============================================*/
    public $permisos;
    public function ajaxPostPermisos()
    {
        $data = $this->permisos;
        $response = ControllerUsuariosList::PERMISOS($data);
        // if ($response == 'OK') {
        //     header("HTTP/1.1 200 OK");
        // } else {
        //     header("HTTP/1.1 500 ERROR-MSQL");
        // }
        echo json_encode($response);
    }
    /*=============================================
        GET BY ID Usuario
=============================================*/
    public $getUsuario;
    public function ajaxGetUsuario()
    {
        $data = $this->getUsuario;
        $response = ControllerUsuariosList::GETUSUARIO($data);
        if (
            isset($response[0]) && $response[0] == 'S'
        ) {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
    /*=============================================
        PUT USUARIOSS
=============================================*/
    public $putUsuario;
    public function ajaxUpdateUsuarios()
    {
        $data = $this->putUsuario;
        $response = ControllerUsuariosList::UPDATE($data);
        if ($response == 'OK') {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 ERROR-MSQL");
        }
        echo json_encode($response);
    }
    /*=============================================
        ACTIVAR DESACTIVAR  USUARIOSS
=============================================*/
    public $activar;
    public function ajaxActivar()
    {
        $data = $this->activar;
        $update = array(
            "table" => "usuarios", #nombre de tabla
            "estado" => $data["estado"], #nombre de columna y valor
            #"columna"=>"valor",#nombre de columna y valor
        );
        $where = array(
            "id" => $data["id"], #condifion columna y valor
        );

        $response = ControllerQueryes::UPDATE($update, $where);
        if ($response == 'OK') {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 ERROR-MSQL");
        }
        echo json_encode($response);
    }
    /*=============================================
        RESSET PASSWORD USUARIOSS
=============================================*/
    public $reset;
    public function ajaxReset()
    {
        $data = $this->reset;

        $response = ControllerUsuariosList::RESETPASSW($data);
        if ($response == 'OK') {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 ERROR-MSQL");
        }
        echo json_encode($response);
    }
    /*=============================================
        DELETE USUARIOSS
=============================================*/
    public $delUsuario;
    public function ajaxDeleteUsuarios()
    {
        $data = $this->delUsuario;
        $response = ControllerUsuariosList::DELETE($data);
        if ($response == 'OK') {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 ERROR-MSQL");
        }
        echo json_encode($response);
    }
    /* ===============data print=================== */
    public $printFile;
    public function ajaxFilesPedidos()
    {
        $data = $this->printFile;
        $response = ControllerUsuariosList::FILES($data);
        if (isset($response[0]) && $response[0] == 'S') {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }


    ///////////////LOGIN/////////
    public $loginUser;
    public function ajaxLoginUsuarios()
    {
        $data = $this->loginUser;
        $response = ControllerUsuariosList::LOGIN($data);
        echo json_encode($response);
    }
}

/* ==== API REQUEST===   */
$request = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // list
    if (isset($_GET["length"]) && isset($_GET["search"])) {
        $list = new ajaxUsuarios();
        $list->lsUsuario = array(
            "start" => $_GET["start"],
            "length" => $_GET["length"],
            "search" => $_GET["search"],
        );
        $list->ajaxListUsarios();
    }
    //get by id
    if (isset($_GET["start"]) && $_GET["start"]) {
        $getbyid = new ajaxUsuarios();
        $getbyid->getUsuario = $_GET["start"];
        $getbyid->ajaxGetUsuario();
    }
    //print files
    if (isset($_GET["desde"]) && $_GET["hasta"]) {
        $print = new ajaxUsuarios();
        $print->printFile = array(
            "desde" => $_GET["desde"],
            "hasta" => $_GET["hasta"]
        );
        $print->ajaxFilesPedidos();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ////LOGIN
    if ($_REQUEST["formulario"] == 'LOGIN') {
        $log = new ajaxUsuarios();
        $log->loginUser = json_decode($_REQUEST['loginUsers'], true);
        $log->ajaxLoginUsuarios();
    }

    if ($_REQUEST["formulario"] == 'USERS') {
        $post = new ajaxUsuarios();
        $post->postUsuario = $_REQUEST["usuarios"];
        $post->ajaxPostUsuarios();
    }

    if ($_REQUEST["formulario"] == 'PERMISOS') {
        $post = new ajaxUsuarios();
        $post->permisos = array(
            "permisos" => json_decode($_REQUEST["permisos"], true),
            "id" => json_decode($_REQUEST["id"], true)
        );
        $post->ajaxPostPermisos();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    if (isset($_REQUEST['id']) && $_REQUEST['id']) {
        $put = new ajaxUsuarios();
        $put->putUsuario = $request;
        $put->ajaxUpdateUsuarios();
    }
    //activa 
    if (isset($_REQUEST['active']) && $_REQUEST['active']) {
        $put = new ajaxUsuarios();
        $put->activar = $request;
        $put->ajaxActivar();
    }
    //resset password 
    if (isset($_REQUEST['rs']) && $_REQUEST['rs']) {
        $put = new ajaxUsuarios();
        $put->reset = $request;
        $put->ajaxReset();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if ($request) {
        $del = new ajaxUsuarios();
        $del->delUsuario = $request;
        $del->ajaxDeleteUsuarios();
    }
}
