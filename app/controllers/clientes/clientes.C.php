<?php
class ControllerClientesList
{
    static public function SELECTALL($data)
    {
        $start =  $data['start'];
        $length =  $data['length'];
        $search =  $data['search'];
        $response = ModelClientesList::SELECTALL($start, $length, $search);
        return $response;
    }
    //CREAR CLIENTES
    static public function GUARDAR($data){
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        $cliente = json_decode($data['cliente'], true);
        $insert = array(
            "table" => "clientes",#TABLA
            "id_documento_type" => $cliente['document_tipe'],
            "names" => $cliente['names'],
            "last_name" => $cliente['last_name'],
            "document_number" => $cliente['document_number'],
            "email" => $cliente['email'],
            "phone" => $cliente['phone'],
            'date_create' => $fecha,
            'id_ubigeo' => $cliente['id_ubigeo'],
            'direccion' => $cliente['direccion'],
            'referencia' => $cliente['referencia'],
        );
        $response = ControllerQueryes::INSERT($insert);

        return $response;
    }
    //ACTUALIZAR CLIENTES
    static public function UPDATE($data)
    {
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());
        $cliente = json_decode($data['cliente'], true);
        $update = array(
            "table" => "clientes", #nombre de tabla
            "id_documento_type" => $cliente['document_tipe'],
            "names" => $cliente['names'],
            "last_name" => $cliente['last_name'],
            "document_number" => $cliente['document_number'],
            "email" => $cliente['email'],
            "phone" => $cliente['phone'],
            'id_ubigeo' => $cliente['id_ubigeo'],
            'direccion' => $cliente['direccion'],
            'referencia' => $cliente['referencia'],
        );
        $where=array ("id"=> $cliente["id"] );#condifion columna y valor
        $response=ModelQueryes::UPDATE($update,$where);
        return $response;
    }
    //ACTUALIZAR CLIENTES
    static public function tempDELETE($data)
    {
        
        $update = array(
            "table" => "clientes", #nombre de tabla
            'eliminar' => 1,
        );
        $where = array("id" => $data); #condifion columna y valor
        $response = ModelQueryes::UPDATE($update, $where);
        return $response;
    }
    //ACTUALIZAR CLIENTES
    static public function EXPORTFILE($data)
    {
        $data['desde'] = date('Y-m-d', strtotime($data['desde'])) . ' 01:00:00';
        $data['hasta'] = date('Y-m-d', strtotime($data['hasta'])) . ' 23:00:00';
        $desde = $data['desde'];
        $hasta = $data['hasta'];
        $response = ModelClientesList::EXPORTFILE($desde, $hasta);
        return $response;
    }
}