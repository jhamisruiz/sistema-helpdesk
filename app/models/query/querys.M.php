<?php

include_once(dirname(__FILE__) . './../conexPDO.php');
class ModelQueryes
{
    /* ================================================================
    QUERY COUNT
================================================================= */
    static public function ROWCOUNT($table)
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as row FROM $table");

            if ($stmt->execute()) {

                return $stmt->fetch();
            } else {

                return  "SELECT COUNT(*) as row FROM $table";
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }
    /* ===============================================================================
    QUERY SELECT 
================================================================================ */
    /**
        *@param$select = array(
       *     "P.id"=>"",
       *     "P.nombres" => "nombre",
       *     "P.apellidos" => "apellido",
       *     "P.email" => "",
       *     "U.id" => "idUser",
       *     "U.userNombre"=>"",
       *     "U.estado" => "",
       *     "ORDERBY" => ["DESC"=> "P.id"],
       *     "*"=>"*"#select*from
       * );

       *@param $tables=array(
       *     #"productos"=>"",//solo si no hay inner joins..
       *     #"productos P" => "almacen A", #0-0
       *     #"P.idAlmacen" => "A.id", #1-1
       *     #"images F"=>"", #8-0
       *     #"F.idProducto" => "P.id",   # 9-1
       * );

       * @param$where=array(
       *     "U.estado"=>"> '0'",
       *     "P.nombres" => "= 'prueba3'",
       * ); */
    static public function SELECT($select, $tables, $where)
    {

        $colum = "";
        $orderby = "";
        $table = "";
        $wher = "";

        for ($i = 0; $i < count($select); $i++) {
            if (key($select) == "ORDER_BY") {
                $orderby = $select["ORDER_BY"];
            }
            if (key($select) == "ORDERBY") {

                if (key($select["ORDERBY"]) == "ASC" || key($select["ORDERBY"]) == "DESC" and key($select["ORDERBY"]) != $select["ORDERBY"][key($select["ORDERBY"])]) {

                    $orderby = " ORDER BY " . $select["ORDERBY"][key($select["ORDERBY"])] . " " . key($select["ORDERBY"]);
                }
                if ($select["ORDERBY"][key($select["ORDERBY"])] == "ASC" || $select["ORDERBY"][key($select["ORDERBY"])] == "DESC" and key($select["ORDERBY"]) != $select["ORDERBY"][key($select["ORDERBY"])]) {

                    $orderby = " ORDER BY " . key($select["ORDERBY"]) . " " . $select["ORDERBY"][key($select["ORDERBY"])];
                }
            } else {

                if (key($select) != "ORDER_BY") {
                    if (key($select) == "*" and $select[key($select)] == "*") {

                        $colum = key($select) . ",";
                    } else {

                        if ($select[key($select)] == "" and $select[key($select)] != "*") {

                            $colum .= key($select) . ",";
                        } else {

                            $colum .= key($select) . " AS " . $select[key($select)] . ",";
                        }
                    }
                }
            }
            next($select);
        }
        $colums = substr($colum, 0, -1);

        for ($j = 0; $j < count($tables); $j++) {

            if ($j % 2 == 0) {
                if ($tables[key($tables)] == "" and $j < 2) {
                    $table = key($tables);
                } else {
                    if ($tables[key($tables)] == "") {
                        $table .= " INNER JOIN " . key($tables);
                    } else {
                        $table .= key($tables) . " INNER JOIN " . $tables[key($tables)];
                    }
                }
            } elseif ($j % 2 == 1) {
                $table .= " ON " . key($tables) . "=" . $tables[key($tables)];
            }
            next($tables);
        }

        if ($where != "") {
            for ($w = 0; $w < count($where); $w++) {

                if ($w == 0) {

                    $wher .= "WHERE " . key($where) . $where[key($where)] . " AND ";
                } else {

                    $wher .= key($where) . $where[key($where)] . " AND ";
                }
                next($where);
            }
        }

        $wheres = substr($wher, 0, -4);
        try {

            $stmt = Conexion::conectar()->prepare("SELECT $colums FROM $table  $wheres $orderby");

            if ($stmt->execute()) {

                return $stmt->fetchAll();
            } else {

                return  "SELECT $colums FROM $table  $wheres $orderby";
            }
        } catch (\Throwable $th) {

            $throw = $th->getMessage();
            return "SELECT $colums FROM $table  $wheres $orderby" . '" - Error:"' . $throw;
        }


        $stmt = NULL;
    }
    /* ===============================================================================
    QUERY INSERT
================================================================================ */
    static public function INSERT($insert)
    {

        $conex = Conexion::conectar();
        $table = "";
        $colum = "";
        $value = "";
        $lastid = "";

        for ($i = 0; $i < count($insert); $i++) {
            if (key($insert) == "LASTID" || $insert[key($insert)] == "TRUE" || $insert[key($insert)] == "YES") {

                $lastid = "YES";
            }
            if (key($insert) != "LASTID" and key($insert) != "" and $insert[key($insert)] != "" and $insert[key($insert)] != "TRUE") {

                if (key($insert) == "table") {

                    $table = $insert[key($insert)];
                } else {

                    $colum .= key($insert) . ",";
                    $value .= "'" . $insert[key($insert)] . "',";
                }
            }
            next($insert);
        }

        $colums = "(" . substr($colum, 0, -1) . ")";
        $values = "(" . substr($value, 0, -1) . ")";

        try {
            if ($lastid == "YES") {

                $stmt = $conex->prepare("INSERT INTO $table $colums VALUES $values");

                if ($stmt->execute()) {

                    return $conex->lastInsertId();
                } else {

                    return "error";
                }
            } else {

                $stmt = Conexion::conectar()->prepare("INSERT INTO $table $colums VALUES $values");

                if ($stmt->execute()) {

                    return "OK";
                } else {
                    return "error";
                }
            }
        } catch (\Throwable $th) {

            $sms = $th->getMessage();
            $dups = explode(':', $sms);
            $dup = explode(' ', $dups[2]);
            if ($dup[7] == "'dni'") {
                return $sms;
            } else {
                return 'error';
            }
        }

        $stmt = NULL;
    }
    /* ================================================================
    QUERY UPDATE
================================================================= */
    /** 
     *@param  $update=array(
     *      "table"=>"usuarios",#nombre de tabla
     *      "valor" => $data["valor"],#nombre de columna y valor
     *      #"columna"=>"valor",#nombre de columna y valor
     *  );
     *@param  $where=array(
     *      "id"=>$data["id"],#condifion columna y valor
     *  ); 
     *@return "OK"
     */
    static public function UPDATE($update, $where)
    {

        $conex = Conexion::conectar();
        $table = "";
        $colums = "";
        $wh = "";

        for ($i = 0; $i < count($update); $i++) {

            if ($i == 0 and key($update) == "table") {

                $table = $update[key($update)];
            } else {

                $colums .= key($update) . "='" . $update[key($update)] . "',";
            }
            next($update);
        }
        $set = substr($colums, 0, -1);

        for ($w = 0; $w < count($where); $w++) {

            $wh .= key($where) . "=" . $where[key($where)] . " AND ";
            next($where);
        }
        $wheres = substr($wh, 0, -4);

        try {
            $stmt = $conex->prepare("UPDATE $table SET $set WHERE $wheres");

            if ($stmt->execute()) {

                $cuenta = $stmt->rowCount();

                if ($cuenta > 0) {

                    return "OK";
                } else {

                    return "UPDATE $table SET $set WHERE $wheres";
                }
            } else {

                return "UPDATE $table SET $set WHERE $wheres";
            }
        } catch (Throwable $th) {
            $throw = $th->getMessage();
            return "inyeccion";
        }
    }
    /* ================================================================
    QUERY DELETE
================================================================= */
    /**
     *@param $delete=array(
     *                "table"=>"personas",
     *                "id" => $val,
     *); 
     *@return => "OK";
     */
    static public function DELETE($delete)
    {

        $tabla = "";
        $wheres = "";

        for ($i = 0; $i < count($delete); $i++) {

            if (key($delete) == "table") {

                $tabla = $delete[key($delete)];
            } else {

                if (count($delete) > 2) {

                    $wheres = key($delete) . "=" . $delete[key($delete)] . " AND ";
                } else {

                    $wheres .= key($delete) . "=" . $delete[key($delete)] . " AND ";
                }
            }

            next($delete);
        }
        $where = substr($wheres, 0, -4);
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $where");
            if ($stmt->execute()) {

                return "OK";
            } else {

                return "DELETE FROM $tabla WHERE $where";
            }
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return $throw;
        }
    }

    /* ============search prod move========== */
    static public function SEARCH($idAlmac, $value)
    {
        try {
            $stmt = Conexion::conectar()->prepare("CALL sp_search_products(:value,:id)");

            $stmt->bindParam(":id", $idAlmac, PDO::PARAM_INT);
            $stmt->bindParam(":value", $value, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $stmt->fetchAll();
            } else {
                return 'error';
            }

            $stmt = null;
        } catch (\Throwable $th) {
            $throw = $th->getMessage();
            return "inyeccion";
        }
    }

    static public function SELECMOVIMIENTO($idm, $search)
    {

        $stmt = Conexion::conectar()->prepare("CALL `sp_select_movimiento`(:id,:search)");
        $stmt->bindParam(":id", $idm, PDO::PARAM_INT);
        $stmt->bindParam(":search", $search, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
        $stmt = null;
    }
}
