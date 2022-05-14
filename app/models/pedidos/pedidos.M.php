<?php

include_once(dirname(__FILE__) . './../conexPDO.php');
class ModelPedidoList
{
    static public function SELECTALL($start, $length, $search)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("SELECT p.id,p.tipo_envio,u.names,u.last_name,u.phone,u.document_number,u.direccion,u.referencia,
                        (SELECT JSON_OBJECT('tipo',mt.tipo,'monto',mt.monto, 'descripcion',mt.descripcion,'url_img', im.url_img) as pago 
                        from metodo_pago mt
                        INNER JOIN imagenes im on im.id_pedido=mt.id_pedido
                        where mt.id_pedido=p.id AND im.opcion=1
                        order by im.id desc limit 1
                        ) metodo_pago,
                        (SELECT group_concat('" . '{"url":"' . "',url_img,'" . '"' . "}') as photos from imagenes where id_pedido =p.id and opcion=0) as photos,
                        p.precio,p.codigo,p.fecha_registro,p.fecha_entrega,
                        p.id_estado, e.nombre as estado,
                        b.Departamento,b.Provincia,b.Distrito
                    FROM pedidos p 
                    INNER JOIN clientes u on u.id=p.id_cliente
                    INNER JOIN ubigeo b on b.id_ubigeo=u.id_ubigeo
                    INNER JOIN estados e on e.id=p.id_estado
                    WHERE eliminar=0 AND u.names LIKE '%$search%' OR
                        p.precio LIKE '%$search%' OR
                        p.codigo LIKE '%$search%' OR
                        u.last_name LIKE '%$search%' OR
                        p.fecha_registro LIKE '%$search%'
                    ORDER BY p.id DESC
                    LIMIT :num
                ");
            $stmt->bindParam("num", $length, PDO::PARAM_INT);
            if ($stmt->execute()) {

                return $stmt->fetchAll();
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    static public function GETPEDIDO($data)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("SELECT p.id,p.id_estado,p.id_cliente,c.names,p.tipo_envio,c.last_name,c.phone,d.id as document_tipe, c.document_number,c.email,
                            u.id_ubigeo,u.Departamento,u.Provincia,u.Distrito,u.id_ubigeo as idDepartamento,u.id_ubigeo as idProvincia,
                            c.direccion,c.referencia,
                            (SELECT group_concat('" . '{"id":' . "',id,'" . ',"url":"' . "',url_img,'" . '"' . "}') as photos from imagenes where id_pedido =p.id and opcion=0 ) as photos,
                            p.precio,p.codigo,p.fecha_registro,p.fecha_entrega,
                            m.id as id_metodo_pago,m.id_imagen as id_imegen_mp,
                            (SELECT im.url_img  from metodo_pago mt INNER JOIN imagenes im on im.id_pedido=mt.id_pedido where mt.id_pedido=p.id AND im.opcion=1 order by im.id desc limit 1) as url_img_mp,
                            m.tipo as tipo_pago,m.monto,m.descripcion
                        FROM pedidos p 
                        INNER JOIN clientes c on c.id=p.id_cliente
                        INNER JOIN documents_type d on d.id=c.id_documento_type
                        INNER JOIN ubigeo u on u.id_ubigeo=c.id_ubigeo
                        INNER JOIN metodo_pago m on m.id_pedido=p.id
                        INNER JOIN imagenes as i on i.id_pedido=p.id
                    WHERE p.id=:id 
                ");
            $stmt->bindParam(":id", $data, PDO::PARAM_INT);
            if ($stmt->execute()) {

                return $stmt->fetch();
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    static public function UPDATE($data)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("UPDATE pedidos 
                SET id_usuario=:id_usuario,tipo_envio=:tipo_envio,precio=:precio,codigo=:codigo,fecha_entrega=:fecha_entrega,id_estado=:id_estado
                WHERE id =:id
            ");
            $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
            $stmt->bindParam(":id_usuario", $data["id_usuario"], PDO::PARAM_INT);
            $stmt->bindParam(":tipo_envio", $data["tipo_envio"], PDO::PARAM_INT);
            $stmt->bindParam(":precio", $data["precio"], PDO::PARAM_STR);
            $stmt->bindParam(":codigo", $data["codigo"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_entrega", $data["fecha_entrega"], PDO::PARAM_STR);
            $stmt->bindParam(":id_estado", $data["id_estado"], PDO::PARAM_INT);
            if ($stmt->execute()) {

                return "OK";
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    //************************GUARDADO PEDIDOS
    static public function GUARDAR($data)
    {
        $codigo = codigoPedido();
        $Conexion = Conexion::conectar();
        $lastid = null;
        try {
            //VALIDA Y REGISTRA CLIENTE
            $clie = Conexion::conectar()->prepare("SELECT id FROM clientes WHERE document_number=" . $data["document_number"]);
            $clie->execute();
            $res = $clie->fetch();
            $id_cliente = (isset($res[0])) ? $res[0] : 0;
            $count = $clie->rowCount();
            if ($id_cliente == 0) {
                //insert
                $client = $Conexion->prepare("INSERT INTO clientes (id_documento_type,names,last_name,document_number,email,phone,date_create,id_ubigeo,direccion,referencia)
                    VALUES(:id_documento_type,:names,:last_name,:document_number,:email,:phone,:date_create,:id_ubigeo,:direccion,:referencia)
                ");
                $client->bindParam(":id_documento_type", $data["document_tipe"], PDO::PARAM_INT);
                $client->bindParam(":names", $data["names"], PDO::PARAM_STR);
                $client->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
                $client->bindParam(":document_number", $data["document_number"], PDO::PARAM_STR);
                $client->bindParam(":email", $data["email"], PDO::PARAM_STR);
                $client->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
                $client->bindParam(":date_create", $data["fecha_registro"], PDO::PARAM_STR);
                $client->bindParam(":id_ubigeo", $data["id_ubigeo"], PDO::PARAM_STR);
                $client->bindParam(":direccion", $data["direccion"], PDO::PARAM_STR);
                $client->bindParam(":referencia", $data["referencia"], PDO::PARAM_STR);
                $client->execute();
                $lastid = $Conexion->lastInsertId();
                $id_cliente = $lastid;
                $client = null;
            } else {
                $client = Conexion::conectar()->prepare("UPDATE clientes SET names=:names,last_name=:last_name,email=:email,phone=:phone,
                    id_ubigeo=:id_ubigeo,direccion=:direccion,referencia=:referencia,eliminar=0
                    WHERE id=$id_cliente
                ");
                $client->bindParam(":names", $data["names"], PDO::PARAM_STR);
                $client->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
                $client->bindParam(":email", $data["email"], PDO::PARAM_STR);
                $client->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
                $client->bindParam(":id_ubigeo", $data["id_ubigeo"], PDO::PARAM_STR);
                $client->bindParam(":direccion", $data["direccion"], PDO::PARAM_STR);
                $client->bindParam(":referencia", $data["referencia"], PDO::PARAM_STR);
                $client->execute();
                $client = null;
            }
            //return $id_cliente;
            //REGISTRA PEDIDO
            $stmt = $Conexion->prepare("INSERT INTO pedidos(id_cliente,tipo_envio,precio,codigo,fecha_registro,fecha_entrega)
                    values(:id_cliente,:tipo_envio,:precio,:codigo,:fecha_registro,:fecha_entrega)
                ");
            $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(":tipo_envio", $data["tipo_envio"], PDO::PARAM_INT);
            $stmt->bindParam(":precio", $data["precio"], PDO::PARAM_STR);
            $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_registro", $data["fecha_registro"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_entrega", $data["fecha_entrega"], PDO::PARAM_STR);
            if ($stmt->execute()) {
                $lastid = $Conexion->lastInsertId();
                return ['sms' => 'OK', 'codigo' => $codigo, 'id_pedido' => $lastid];
            } else {
                return ['sms' => 'ERROR'];
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }

        //return codigoPedido();
    }
    static public function DELETE($id)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("DELETE FROM pedidos WHERE id =:id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    static public function FILES($data)
    {
        $desde = $data['desde'];
        $hasta = $data['hasta'];
        try {
            $stmt = Conexion::conectar()
                ->prepare("SELECT p.id,u.names,u.last_name,u.phone,u.document_number,u.direccion,u.referencia,
                    mp.tipo,mp.descripcion,
                    p.precio,p.codigo,p.fecha_registro,p.fecha_entrega,p.tipo_envio,
                    e.nombre as estado,
                    b.Departamento,b.Provincia,b.Distrito
                FROM pedidos p 
                INNER JOIN clientes u on u.id=p.id_cliente
                INNER JOIN ubigeo b on b.id_ubigeo=u.id_ubigeo
                INNER JOIN estados e on e.id=p.id_estado
                INNER JOIN metodo_pago mp on mp.id_pedido=p.id
                WHERE p.fecha_registro BETWEEN '$desde' AND '$hasta' OR
               p.fecha_entrega BETWEEN ' $desde' AND '$hasta'
                ORDER BY p.id DESC
            ");
            if ($stmt->execute()) {

                return $stmt->fetchAll();
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
}
///////////SUGEST CODIGO

function codigoPedido()
{
    $codigo = '';
    $stmt = Conexion::conectar()->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = 'pedidos'");
    $stmt->execute();
    $res = $stmt->fetch();
    if ($res == '' || $res[0] == '') {

        return 'TLS-001';
    }
    $codigo = $res[0];
    $codigo = substr($codigo, -3);
    $codigo = $codigo + $res[0];
    $codigo = $res[0];
    $codigo = 'TLS-00' . $codigo;
    return $codigo;
}
