<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/pedidos/pedidos.C.php');
include('./../../../models/pedidos/pedidos.M.php');
class ajaxPedidos
{
    /*=============================================
        LIST PEDIDOS
=============================================*/
    public $lsPedido;
    public function ajaxListPedidos()
    {
        $data = $this->lsPedido;
        $response = ControllerPedidoList::SELECTALL($data);
        if (isset($response[0]) && $response[0] == 'S') {
            header("HTTP/1.1 500 ERROR");
        }
        for ($i = 0; $i < count($response); $i++) {
            $response[$i]['i'] = ($i + 1);
            $response[$i]['metodo_pago'] = json_decode($response[$i]['metodo_pago']);
            $response[$i]['photos'] = explode(',', $response[$i]['photos']);
        }
        echo json_encode($response);
    }
    /*=============================================
        GET BY ID PEDIDOS
=============================================*/
    public $getPedido;
    public function ajaxGetPedidos()
    {
        $data = $this->getPedido;
        $response = ControllerPedidoList::GETPEDIDO($data);
        if (
            isset($response[0]) && $response[0] == 'S'
        ) {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
    /*=============================================
        GET BY ID ESTADOS UPODATE
=============================================*/
    public $estado;
    public function ajaxPedidoEstado()
    {
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        $data = $this->estado;
        
        if($data["estado"]==5){
            $update = array(
                "table" => "pedidos", #nombre de tabla
                "id_estado" => $data["estado"], #nombre de columna y valor
                "fecha_entrega"=> $fecha,#nombre de columna y valor
            );
        }else{
            $update = array(
                "table" => "pedidos", #nombre de tabla
                "id_estado" => $data["estado"], #nombre de columna y valor
                #"columna"=>"valor",#nombre de columna y valor
            );
        }

        $where = array(
            "id" => $data["id"], #condifion columna y valor
        );
        $response = ControllerQueryes::UPDATE($update, $where);


        if (
            isset($response[0]) && $response[0] == 'S'
        ) {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
    /*=============================================
        GET BY ID DELETE
=============================================*/
    public $imagenDel;
    public function ajaxDeletePedidoImagen()
    {
        $data = $this->imagenDel;

        $response = ControllerPedidoList::DELETEIMAGES($data);
        if (
            isset($response[0]) && $response[0] == 'S'
        ) {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
/*=============================================
        POST PEDIDOS
=============================================*/
    public $postPedido;
    public function ajaxPostPedidos()
    {
        $data = $this->postPedido;
        $response = ControllerPedidoList::GUARDAR($data);
        echo json_encode($response);
    }
/*=============================================
        PUT PEDIDOS
=============================================*/
    public $putPedido;
    public function ajaxUpdatePedidos()
    {
        $data = $this->putPedido;
        $response = ControllerPedidoList::UPDATE($data);
        if ($response['sms'] == 'OK') {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 ERROR-MSQL");
        }
        echo json_encode($response);
    }
    /*=============================================
        DELETE PEDIDOS
=============================================*/
    public $delPedido;
    public function ajaxDeletePedidos()
    {
        $data = $this->delPedido;
        $response = ControllerPedidoList::DELETE($data);
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
        $response = ControllerPedidoList::FILES($data);
        if (isset($response[0]) && $response[0] == 'S') {
            header("HTTP/1.1 500 ERROR");
        }
        echo json_encode($response);
    }
}


/* ==== API REQUEST===   */
$request = json_decode(file_get_contents('php://input'), true);

/*=============================================
---LIST PEDIDOS
=============================================*/
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // list
    if (isset($_GET["length"]) && isset($_GET["search"])) {
        $listPedido = new ajaxPedidos();
        $listPedido->lsPedido = array(
            "start" => $_GET["start"],
            "length" => $_GET["length"],
            "search" => $_GET["search"],
        );
        $listPedido->ajaxListPedidos();
    }
    //get by id
    if (isset($_GET["start"]) && $_GET["start"]) {
        $getbyid = new ajaxPedidos();
        $getbyid->getPedido = $_GET["start"];
        $getbyid->ajaxGetPedidos();
    }
    // ACUTALIZAR ESTADO
    if (isset($_GET["estado"])) {
        $up = new ajaxPedidos();
        $up->estado = array(
            'id' => $_GET["idpedido"],
            'estado' => $_GET["estado"],
        );
        $up->ajaxPedidoEstado();
    }
    //eliminar imagenes
    if (isset($_GET["idimagen"])) {
        $up = new ajaxPedidos();
        $up->imagenDel = array(
            'id' => $_GET["idimagen"],
            'url' => $_GET["urlimagen"],
        );
        $up->ajaxDeletePedidoImagen();
    }
    //print files
    if (isset($_GET["desde"]) && $_GET["hasta"]) {
        $print = new ajaxPedidos();
        $print->printFile = array(
            "desde" => $_GET["desde"],
            "hasta" => $_GET["hasta"]
        );
        $print->ajaxFilesPedidos();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // GUARDA
    if ($_REQUEST['formulario']=='POST') {
        $post = new ajaxPedidos();
        $post->postPedido = $_REQUEST;
        $post->ajaxPostPedidos();
    }

    /// ACTUALZIAR
    if ($_REQUEST['formulario'] == 'PUT') {
        $put = new ajaxPedidos();
        $put->putPedido = $_REQUEST;
        $put->ajaxUpdatePedidos();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // $put = new ajaxPedidos();
    // $put->putPedido = $request;
    // $put->ajaxUpdatePedidos();
}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if ($request) {
        $del = new ajaxPedidos();
        $del->delPedido = $request;
        $del->ajaxDeletePedidos();
    }
}
