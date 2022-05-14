<?php
class ControllerPedidoList
{

    static public function SELECTALL($data)
    {
        $start =  $data['start'];
        $length =  $data['length'];
        $search =  $data['search'];
        $response = ModelPedidoList::SELECTALL($start, $length, $search);
        for ($i=0; $i < count($response); $i++) { 
            $nd= $response[$i]['fecha_entrega'];
            $nd=substr($nd, 0, -8);
            $response[$i]['fecha_entrega'] = $nd;
        }
        return $response;
    }
    static public function GETPEDIDO($data)

    //GET PEDIDO BY ID
    {
        $response = ModelPedidoList::GETPEDIDO($data);
        return $response;
    }

    //******************UPDATE PEDIDOS***************
    static public function UPDATE($data)
    {
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        ///decodificar array
        $pedido = json_decode($data['pedido'], true);
        $length = json_decode($data['cant_img'], true); // array.length si VIENE VACIO ES 0
        $pago = $pedido['detalle_pago'];
        $pago['descripcion'] = (!isset($pago['descripcion'])) ? null : $pago['descripcion'];
        //return $pedido;
        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["names"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["last_name"]) &&
            isset($pedido["precio"])
        ) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["phone"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["document_number"])
            ) {
                // ********************1 ACTUALIZA EL PEDIDO

                $pedido['referencia'] = (!isset($pedido['referencia'])) ? null : $pedido['referencia'];
                //ACTUALIZA CIENTE
                $update = array(
                    "table" => "clientes", #nombre de tabla
                    "id_documento_type" => $pedido["document_tipe"], #nombre de columna y valor
                    "names" => $pedido["names"], #nombre de columna y valor
                    "last_name" => $pedido["last_name"], #nombre de columna y valor
                    "document_number" => $pedido["document_number"], #nombre de columna y valor
                    "email" => $pedido["email"], #nombre de columna y valor
                    "phone" => $pedido["phone"], #nombre de columna y valor
                    "id_ubigeo" => $pedido["id_ubigeo"], #nombre de columna y valor
                    "direccion" => $pedido["direccion"], #nombre de columna y valor
                    "referencia" => $pedido["referencia"], #nombre de columna y valor
                );
                $where = array("id" => $pedido["id_cliente"],);
                $response = ModelQueryes::UPDATE($update, $where);
                $response = ($response == 'OK') ? 'OK' : $response;
                //ACTUALIZA PEDIDO
                $update = array("table" => "pedidos", "precio" => $pedido["precio"], "tipo_envio" => $pedido["tipo_envio"]);
                $where = array("id" => $pedido["id"],);
                $response = ModelQueryes::UPDATE($update, $where);
                $response = ($response == 'OK') ? 'OK' : $response;

                // CREA IMAGENES NUEVAS IMAGENES
                # crea las carpetas
                $path = dirname(__FILE__) . "/../../../../upload/" . $pedido["document_number"];
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                // crea una segunda carpetas con nombre del pedido
                $path_cod = dirname(__FILE__) . "/../../../../upload/" . $pedido["document_number"] . "/" . $pedido['codigo'];
                if (!file_exists($path_cod)) {
                    mkdir($path_cod, 0777, true);
                }
                // **********************array data imagenes**********************
                $Folder_Name = 'upload/' . $pedido["document_number"] . "/" . $pedido['codigo']. '/';
                for ($i = 0; $i < $length; $i++) {
                    $TmpName = $_FILES[$i]['tmp_name'];
                    $Img_Name = "tls".($i+1).".png";
                    $Image = $Folder_Name . $Img_Name;
                    if (move_uploaded_file($TmpName, "../../../../../" . $Image)) {
                        $insert = array(
                            "table" => "imagenes", "id_pedido" => $pedido['id'],
                            "nombre" => $Img_Name, "url_img" => $Image,
                        );
                        $respuesta = ControllerQueryes::INSERT($insert);
                        $respuesta = ($respuesta == "OK") ? "OK" : "error";
                    }
                }
                // IMGEN DE COMPROBANTE PEDIDO
                if (isset($_FILES['pago_img']['tmp_name'])) {
                    $TmpName = $_FILES['pago_img']['tmp_name'];
                    $Img_Name = $_FILES['pago_img']['name'];
                    $newName = $pedido['codigo'] . '.png';
                    $Image = $Folder_Name . $newName;
                    /* eliminamos imagen */
                    $del = dirname(__FILE__) . "/../../../../" . $Image;
                    if (file_exists($del)) {
                        chmod($del, 0777);
                        unlink($del);
                    }
                    /* mueve nueva imagen */
                    if (move_uploaded_file($TmpName, "../../../../../" . $Image)) {
                        //si viene imegen de comproobante

                        $update = array("table" => "imagenes", "nombre" => $newName, "url_img" => $Image,);
                        $where = array("id" => $pedido["id_imegen_mp"],);
                        $response = ModelQueryes::UPDATE($update, $where);
                        $response = ($response == 'OK') ? 'OK' : $response;
                    }
                } else {
                    $update = array("table" => "imagenes", "nombre" => 'sin comprobante', "url_img" => 'img/no-pay.svg');
                    $where = array("id" => $pedido["id_imegen_mp"],);
                    $response = ModelQueryes::UPDATE($update, $where);
                    $response = ($response == 'OK') ? 'OK' : $response;
                }

                //ACTUALIZA METODO DE PAGO
                $update = array("table" => "metodo_pago", "monto" => $pedido["monto"], "descripcion" => $pedido['descripcion']);
                $where = array("id" => $pedido["id_metodo_pago"],);
                $response = ModelQueryes::UPDATE($update, $where);
                $response = ($response == 'OK') ? 'OK' : $response;

                //////////////zip//////////////
                $filezip = dirname(__FILE__) . '/../../../../upload/' . $pedido["document_number"] . "/" . $pedido['codigo'] . ".zip";
                if (file_exists($filezip)){
                    header('Content-Type: application/zip');
                    // delete file
                    unlink($filezip);
                }
                ////////////////// CREAR ZIP
                $pathdir = './../../../../../upload/' . $pedido["document_number"] . "/" . $pedido['codigo'] . "/";

                // Enter the name to creating zipped directory
                $zipcreated = './../../../../../upload/' . $pedido["document_number"] . "/" . $pedido['codigo'] . ".zip";

                // Create new zip class
                $zip = new ZipArchive;

                if ($zip->open($zipcreated, ZipArchive::CREATE ) === TRUE) {
                    // Store the path into the variable
                    $dir = opendir($pathdir);

                    while ($file = readdir($dir)) {
                        if (is_file($pathdir . $file)) {
                            $zip->addFile($pathdir . $file, $file);
                        }
                    }
                    $zip->close();
                }

                return ["sms" => "OK"];
            } else {
                return ["sms" => "#Error: El nro telefono  o nro Documento incorrectos. (*)"];
            }
        } else {
            return ["sms" => "#Error: Llena todos los campos obligatorios. (*)"];
        }
    }

    ////////////GUARDA PEDIDOS//////////////////////////////
    static public function GUARDAR($data)
    {
        header("Content-type: image/png");
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        ///decodificar array
        $imgCrop = [];
        $pedido = json_decode($data['pedido'], true);
        $imgCrop = $pedido['Croped'];
        //return  $imgCrop;
        $length = json_decode($data['cant_img'], true); // array.length
        $pago = $pedido['detalle_pago'];
        $pago['descripcion'] = (!isset($pago['descripcion'])) ? null : $pago['descripcion'];
        //return $length;
        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["names"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["last_name"]) &&
            isset($pedido["precio"])
        ) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["phone"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $pedido["document_number"])
            ) {


                // 1INSERTA EL PEDIDO
                //$pedido['referencia'] ='asd asd';
                $pedido['referencia'] = (!isset($pedido['referencia'])) ? null : $pedido['referencia'];
                $pedido['fecha_registro'] = $fecha;
                $pedido['fecha_entrega'] = $fecha;
                $response = ModelPedidoList::GUARDAR($pedido);

                ///procesa imageness SI SOLO SE GUARDA LOS DATOS DE PEDIDO
                //  2 GUARDA LAS IMAGENES

                if (isset($response['sms']) == 'OK') {
                    // crea las carpetas con numero de documento cliente
                    $path = dirname(__FILE__) . "/../../../../upload/" . $pedido["document_number"];
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    // crea una segunda carpetas con nombre del pedido
                    $path_cod = dirname(__FILE__) . "/../../../../upload/" . $pedido["document_number"]."/". $response['codigo'];
                    if (!file_exists($path_cod)) {
                        mkdir($path_cod, 0777, true);
                    }
                    // **********************array data imagenes**********************
                    $Folder_Name = 'upload/' . $pedido["document_number"] . "/" . $response['codigo'] . '/';
                    for ($i = 0; $i < $length; $i++) {
                        $TmpName = $_FILES[$i]['tmp_name'];
                        $Img_Name = "tls".($i+1).".png";
                        $Image = $Folder_Name . $Img_Name;

                        /* guarda imagen editada */
                        if (isset($imgCrop[$i]['Croped']) && $imgCrop[$i]['Croped'] == "YES") {
                            $cropedImage = $imgCrop[$i]['DataCroped'];
                            // Remover la parte de la cadena de texto que no necesitamos (data:image/png;base64,)
                            // y usar base64_decode para obtener la información binaria de la imagen
                            $base64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cropedImage));

                            // Finalmente guarda la imágen en el directorio especificado y con la informacion dada
                            file_put_contents("../../../../../" . $Image, $base64);

                            $insert = array(
                                "table" => "imagenes", "id_pedido" => $response['id_pedido'],
                                "nombre" => $Img_Name, "url_img" => $Image,
                            );
                            $respuesta = ControllerQueryes::INSERT($insert);
                            $respuesta = ($respuesta == "OK") ? "OK" : "error";
                        } else {
                            if (move_uploaded_file($TmpName, "../../../../../" . $Image)) {
                                $insert = array(
                                    "table" => "imagenes", "id_pedido" => $response['id_pedido'],
                                    "nombre" => $Img_Name, "url_img" => $Image,
                                );
                                $respuesta = ControllerQueryes::INSERT($insert);
                                $respuesta = ($respuesta == "OK") ? "OK" : "error";
                            }
                        }
                    }
                    /// ************insert pago imagen***************************
                    if (isset($_FILES['pago_img']['tmp_name'])) {
                        $TmpName = $_FILES['pago_img']['tmp_name'];
                        $Img_Name = $_FILES['pago_img']['name'];
                        $newName = $response['codigo'] . '.png';
                        $Image = $Folder_Name . $newName;
                        if (move_uploaded_file($TmpName, "../../../../../" . $Image)) {
                            //si viene imegen de comproobante
                            $insert = array(
                                "table" => "imagenes", "id_pedido" => $response['id_pedido'],
                                "nombre" => $newName, "url_img" => $Image, "opcion" => 1, "LASTID" => "YES",
                            );
                        }
                    } else {
                        //sin imgen de comprobante
                        $insert = array(
                            "table" => "imagenes", "id_pedido" => $response['id_pedido'],
                            "nombre" => 'sin comprobante', "url_img" => 'img/no-pay.svg',
                            "opcion" => 1, "LASTID" => "YES",
                        );
                    }
                    $respuesta = ControllerQueryes::INSERT($insert);
                    //*********************METODO DE PAGO*********************
                    if ($respuesta > 0) {
                        $insert = array(
                            "table" => "metodo_pago", "id_pedido" => $response['id_pedido'],
                            "id_imagen" => $respuesta, "tipo" => $pago['tipo'],
                            "monto" => $pago['monto'], "descripcion" => $pago['descripcion']
                        );
                        $respuesta = ControllerQueryes::INSERT($insert);
                        $respuesta = ($respuesta == "OK") ? "OK" : "error";
                    }
                } else {
                    $response = ["sms" => 'Error: Algun dato en el formulario es incorrecto'];
                }
                
                //////////////zip//////////////
                $filezip = dirname(__FILE__) . '/../../../../upload/' . $pedido["document_number"] . "/" . $response['codigo'] . ".zip";
                if (file_exists($filezip)) {
                    header('Content-Type: application/zip');
                    // delete file
                    unlink($filezip);
                }
                ////////////////// CREAR ZIP
                $pathdir = './../../../../../upload/' . $pedido["document_number"] . "/" . $response['codigo'] . "/";

                // Enter the name to creating zipped directory
                $zipcreated = './../../../../../upload/' . $pedido["document_number"] . "/" . $response['codigo'] . ".zip";

                // Create new zip class
                $zip = new ZipArchive;

                if ($zip->open($zipcreated, ZipArchive::CREATE) === TRUE) {
                    // Store the path into the variable
                    $dir = opendir($pathdir);

                    while ($file = readdir($dir)) {
                        if (is_file($pathdir . $file)) {
                            $zip->addFile($pathdir . $file, $file);
                        }
                    }
                    $zip->close();
                }
                return $response;
            } else {
                return ["sms" => "#Error: El nro telefono  o nro Documento incorrectos. (*)"];
            }
        } else {
            return ["sms" => "#Error: Llena todos los campos obligatorios. (*)"];
        }
    }


    static public function DELETE($data)
    {
        $select= array( 
            "C.document_number"=>"",
        );
        $tables=array( 
            "clientes C"=> "pedidos P",
            "C.id" => "P.id_cliente", #1-1
        );
        $where=array( 
            "P.id"=>"=". $data, 
        );
        $document = ModelQueryes::SELECT($select, $tables, $where);
        $document= isset($document[0][0]) ? $document[0][0]: '';
        $file = dirname(__FILE__) . '/../../../../upload/' . $document; 
        
        $delete = array("table" => "imagenes", "id_pedido" => $data,);
        $res = ModelQueryes::DELETE($delete);
        $res=($res=='OK')?'ok':'error';
        
        if (file_exists($file)){
            rmDir_rf($file);
        }
        
        $response = ModelPedidoList::DELETE($data);
        return $response;
    }
    static public function DELETEIMAGES($data)
    {
        //$path = dirname(__FILE__). "/../../../../". $data['url'];
        $delete = array("table" => "imagenes", "id" => $data['id'],);

        $response = ModelQueryes::DELETE($delete);
        if ($response == "OK") {
            $path = dirname(__FILE__) . "/../../../../" . $data['url'];
            chmod($path, 0777);
            if (unlink($path)) {
                return "OK";
            };
            
        }

        return $response;
    }
    static public function FILES($data)
    {
        $data['desde'] = date('Y-m-d', strtotime($data['desde'])) . ' 01:00:00';
        $data['hasta'] = date('Y-m-d', strtotime($data['hasta'])) . ' 23:00:00';
        $response = ModelPedidoList::FILES($data);
        for ($i = 0; $i < count($response); $i++) {
            $nd = $response[$i]['fecha_entrega'];
            $nd = substr($nd, 0, -8);
            $response[$i]['fecha_entrega'] = $nd;
            $response[$i]['ubigeo']= $response[$i]['Departamento'].'-'. $response[$i]['Provincia'].'-'. $response[$i]['Distrito'];
            $response[$i]['envio']= ($response[$i]['tipo_envio']==1)? 'Gratis': 'Expres';
        }
        return $response;
    }
}

function rmDir_rf($carpeta)
{
    foreach (glob($carpeta . "/*") as $archivos_carpeta) {
        if (is_dir($archivos_carpeta)) {
            rmDir_rf($archivos_carpeta);
        } else {
            unlink($archivos_carpeta);
        }
    }
    rmdir($carpeta);
}