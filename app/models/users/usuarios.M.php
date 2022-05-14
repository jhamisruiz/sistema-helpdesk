<?php

include_once(dirname(__FILE__) . './../conexPDO.php');
class ModelUsuariosList
{
    static public function SELECTALL($start, $length, $search)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("SELECT u.id,u.names,u.last_name,u.email,u.user_name,u.phone,u.fecha_registro,u.estado, 
                    (select group_concat( '{".'"id_usuario":'."',dp.id_usuario,'".',"id_permiso":'."',dp.id_permiso,'}') from detalle_permisos dp WHERE dp.id_usuario=u.id) as permisos
                    FROM usuarios u
                    WHERE u.names LIKE '%$search%' OR
                        u.last_name LIKE '%$search%' OR
                        u.email  LIKE '%$search%' OR
                        user_name LIKE '%$search%' 
                    ORDER BY u.id asc
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

    static public function GUARDAR($data)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("INSERT INTO usuarios(names,last_name,email,user_name,password,phone,fecha_registro)
                    values(:names,:last_name,:email,:user_name,:password,:phone,:fecha_registro)
                ");
            $stmt->bindParam(":names", $data["names"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
            $stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":user_name", $data["user_name"], PDO::PARAM_STR);
            $stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
            $stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_registro", $data["fecha_registro"], PDO::PARAM_STR);
            if ($stmt->execute()) {
                return 'OK';
            } else {
                return 'ERROR';
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    static public function GETUSUARIO($data)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("SELECT id,names,last_name,email,user_name,phone,estado 
                    FROM usuarios
                    WHERE id=:id
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
                ->prepare("UPDATE usuarios 
                SET names=:names,last_name=:last_name,email=:email,user_name=:user_name,phone=:phone
                WHERE id =:id
            ");
            $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
            $stmt->bindParam(":names", $data["names"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
            $stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":user_name", $data["user_name"], PDO::PARAM_STR);
            $stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
            if ($stmt->execute()) {

                return "OK";
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    static public function PERMISOS($values,$id)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("DELETE FROM detalle_permisos WHERE id_usuario = $id");
            $stmt->execute();
            
            if($values!=''){
                $stmt = null;
                $stmt = Conexion::conectar()
                    ->prepare("INSERT INTO detalle_permisos (`id_usuario`, `id_permiso`) VALUES $values
                ");
                $stmt->execute();
            }
            return "Permisos Modificados";
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    static public function DELETE($id)
    {
        try {
            $stmt = Conexion::conectar()
                ->prepare("DELETE FROM usuarios WHERE id =:id");
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
                ->prepare(
                "SELECT id,names,last_name,email,user_name,phone,fecha_registro,
                        REPLACE(REPLACE(estado,0,\"DESHABILITADO\"),1,\"HABILITADO\") as estado\n"
                    ."FROM usuarios
                    WHERE fecha_registro BETWEEN '$desde' AND '$hasta'
                    ORDER BY id ASC
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
