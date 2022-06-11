<?php


class indexController
{
    static public function ENVIAREAYUDA($res)
    {
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        $data = json_decode($res['index'], true);
        $length = json_decode($res['img_length'], true); // array.length
        $email = ModelQueryes::SELECT(["id" => "", "email" => ""], ["clientes" => "",], ["email='" => $data['email'] . "'"]);
        $id = 0;
        if (isset($email[0]) && $email[0]['email'] == $data['email']) {
            $id = $email[0]['id'];
            $update = [
                "table" => "clientes",
                "razon_social" => $data['razon_social'],
                "phone" => $data['numero'],
            ];
            $where = array("id" => $id);
            $ok = ModelQueryes::UPDATE($update, $where);
        } else {
            $insert = [
                "table" => "clientes", #TABLA
                "razon_social" => $data['razon_social'],
                "email" => $data['email'],
                "phone" => $data['numero'],
                "date_create" => $fecha,
                "LASTID" => "YES"
            ];
            $insert = ModelQueryes::INSERT($insert);
            $id = $insert;
        }
        ///crea chat
        $idchat = 0;
        $insert = [
            "table" => "chat", #TABLA
            "id_cliente" => $id,
            "mensaje" => $data['mensaje'],
            "fecha_registro" => $fecha,
            "LASTID" => "YES"
        ];
        $lsidchat = ControllerQueryes::INSERT($insert);
        $idchat = $lsidchat;

        if ($idchat) {
            // crea las carpetas id cliente
            $path = dirname(__FILE__) . "/../../../upload/" . $id;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            // crea una segunda carpetas con email del cliente
            $path_cod = dirname(__FILE__) . "/../../../upload/" . $id . "/" . $data['email'];
            if (!file_exists($path_cod)) {
                mkdir($path_cod, 0777, true);
            }
            // **********************array data imagenes**********************
            $Folder_Name = 'upload/' . $id . "/" . $data['email'] . '/';

            for ($i = 0; $i < $length; $i++) {
                $TmpName = $_FILES[$i]['tmp_name'];
                $Img_Name = $idchat . "-" . ($i + 1) . ".png";
                $Image = $Folder_Name . $Img_Name;
                if (move_uploaded_file($TmpName, "../../../../" . $Image)) {
                    $insert = [
                        "table" => "imagenes", "	id_chat" => $idchat,
                        "nombre" => $Img_Name, "url_img" => $Image,
                    ];
                    $respuesta = ControllerQueryes::INSERT($insert);
                    $respuesta = ($respuesta == "OK") ? "OK" : "error";
                }
            }
        }
        return $data['email'];
    }
}
