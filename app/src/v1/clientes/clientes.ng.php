<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/clientes/clientes.C.php');
include('./../../../models/clientes/clientes.M.php');
class ajaxClientes{
    /*=============================================
        LIST CLIENTES
=============================================*/
    public $lsClientes;
    public function ajaxListClientes()
    {
        $data = $this->lsClientes;
        $response = ControllerClientesList::SELECTALL($data);
        if (isset($response[0]) && $response[0] == 'S') {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
/*=============================================
        POST CLIENTES
=============================================*/
    public $postCliente;
    public function ajaxPostClientes()
    {
        $data = $this->postCliente;
        $response = ControllerClientesList::GUARDAR($data);
        if($response=='OK'){
            echo json_encode($response);
        }else{
            header("HTTP/1.1 500 ERROR");
        }
    }
/*=============================================
        POST CLIENTES
=============================================*/
    public $putCliente;
    public function ajaxPutClientes()
    {
        $data = $this->putCliente;
        $response = ControllerClientesList::UPDATE($data);
        if ($response == "OK") {
            echo json_encode($response);
        } else {
            header("HTTP/1.1 500 ERROR");
        }
    }
/*=============================================
        EKIMINAR CLIENTES
=============================================*/
    public $delCliente;
    public function ajaxDeleteClientes()
    {
        $data = $this->delCliente;
        $response = ControllerClientesList::tempDELETE($data);
        if ($response == "OK") {
            echo json_encode($response);
        } else {
            header("HTTP/1.1 500 ERROR");
        }
    }
    /*=============================================
        EXPORTAR CLIENTES
=============================================*/
    public $exportFiles;
    public function ajaxExportFiles()
    {
        $data = $this->exportFiles;
        $response = ControllerClientesList::EXPORTFILE($data);
        echo json_encode($response);
    }
}
/* ///////////////////////////////////
        ==== API REQUEST===
///////////////////////////////////   */
$request = json_decode(file_get_contents('php://input'), true);

//GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // list
    if (isset($_GET["length"]) && isset($_GET["search"])) {
        $list = new ajaxClientes();
        $list->lsClientes = array(
            "start" => $_GET["start"],
            "length" => $_GET["length"],
            "search" => $_GET["search"],
        );
        $list->ajaxListClientes();
    }
    // list
    if (isset($_GET["desde"]) && isset($_GET["hasta"])) {
        $list = new ajaxClientes();
        $list->exportFiles = array(
            "desde" => $_GET["desde"],
            "hasta" => $_GET["hasta"],
        );
        $list->ajaxExportFiles();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // GUARDA
    if ($_REQUEST['formulario'] == 'POST') {
        $post = new ajaxClientes();
        $post->postCliente = $_REQUEST;
        $post->ajaxPostClientes();
    }

    /// ACTUALZIAR
    if ($_REQUEST['formulario'] == 'PUT') {
        $put = new ajaxClientes();
        $put->putCliente = $_REQUEST;
        $put->ajaxPutClientes();
    }

    /// ACTUALZIAR
    if ($_REQUEST['formulario'] == 'DELETE') {
        $del = new ajaxClientes();
        $del->delCliente = $_REQUEST['cliente'];
        $del->ajaxDeleteClientes();
    }
}