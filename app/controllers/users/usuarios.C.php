<?php
class ControllerUsuariosList
{
    static public function SELECTALL($data)
    {
        $start =  $data['start'];
        $length =  $data['length'];
        $search =  $data['search'];
        $response = ModelUsuariosList::SELECTALL($start, $length, $search);
        return $response;
    }

    static public function GUARDAR($datos)
    {

        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());
        $data = json_decode($datos, true);
        if (
            $data["names"] &&
            $data["last_name"] &&
            $data["user_name"] &&
            $data["password"] &&
            $data["rep_password"]
        ) {
            if ($data['password'] != $data['rep_password']) {
                return "#Error: las contraseñas no son iguales.";
            }

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['fecha_registro'] = $fecha;

            $response = ModelUsuariosList::GUARDAR($data);
            return $response;
        } else {
            return "#Error: Llena todos los campos obligatorios. (*)";
        }
    }
    static public function GETUSUARIO($data)
    {
        $response = ModelUsuariosList::GETUSUARIO($data);
        return $response;
    }
    static public function UPDATE($data)
    {
        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $data["names"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $data["last_name"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $data["user_name"])
        ) {
            $response = ModelUsuariosList::UPDATE($data);
            return $response;
        } else {
            return "#Error: Llena todos los campos obligatorios. (*)";
        }
    }
    static public function RESETPASSW($data)
    {
        if (
            $data["password"] &&
            $data["rep_password"]
        ) {
            if ($data['password'] != $data['rep_password']) {
                return "#Error: las contraseñas no son iguales.";
            }

            $update = array(
                "table" => "usuarios", #nombre de tabla
                "password" => password_hash($data['password'], PASSWORD_DEFAULT), #nombre de columna y valor
                #"columna"=>"valor",#nombre de columna y valor
            );
            $where = array(
                "id" => $data["id"], #condifion columna y valor
            );
            $response =  ModelQueryes::UPDATE($update, $where);
            return $response;
        } else {
            return "#Error: Llena todos los campos";
        }
    }
    static public function PERMISOS($data)
    {
        $permisos = $data['permisos'];

        $values = '';
        for ($i = 0; $i < count($permisos); $i++) {
            $coma = ',';
            if ($i == (count($permisos) - 1)) {
                $coma = '';
            }
            $values .= '(' . $data['id'] . ',' . $permisos[$i] . ')' . $coma;
        }
        $response = ModelUsuariosList::PERMISOS($values, $data['id']);
        return $response;
    }

    static public function DELETE($data)
    {
        $response = ModelUsuariosList::DELETE($data);
        return $response;
    }
    static public function FILES($data)
    {
        $data['desde'] = date('Y-m-d', strtotime($data['desde']));
        $data['hasta'] = date('Y-m-d', strtotime($data['hasta']));
        $response = ModelUsuariosList::FILES($data);
        return $response;
    }
    static public function LOGIN($data)
    {
        $select = array(
            "*" => "*"
        );
        $tables = array(
            "usuarios" => ""
        );
        $where = array(
            "user_name" => "='" . $data['usuario'] . "' OR email ='" . $data['usuario'] . "'"
        );
        $res = ModelQueryes::SELECT($select, $tables, $where);
        if (count($res)) {
            if ($res[0]['estado'] == 1) {
                if (password_verify($data['password'], $res[0]['password'])) {
                    session_start();
                    $_SESSION["loginSession"] = "OK";
                    $_SESSION['usuario'] = $res[0];

                    $select = array("*" => "*");
                    $tables = array(
                        "detalle_permisos" => "",
                    );
                    $where = array(
                        'id_usuario' => "=" . $res[0]['id']
                    );
                    $respuesta = ModelQueryes::SELECT($select, $tables, $where);
                    $_SESSION["permisos"] = $respuesta;


                    return ["login" => "OK", "sms" => $res[0]['names'] . ' ' . $res[0]['last_name'], 'user' => $res[0]];
                } else {
                    return ["login" => "ERROR", "sms" => 'Las contraseñas no coinciden'];
                }
            } else {
                return ["login" => "ERROR", "sms" => 'Usuario o email esta deshabilitado.'];
            }
        } else {
            return ["login" => "ERROR", "sms" => "Usuario o Email incorrecto!"];
        }
    }
}
