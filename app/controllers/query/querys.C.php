<?php
class ControllerQueryes{
    /* ================================================================
    QUERY   ROWCOUNT
    ================================================================= */
    static public function ROWCOUNT($table)
    {
        $row='';
        $respuesta = ModelQueryes::ROWCOUNT($table);
        if (isset($respuesta['row'])){
            $row = $respuesta['row'];
        }
        if ($row>0){
            return $row;
        }
        return $respuesta;
    }
/* ================================================================
    QUERY SELECT
================================================================= */
    static public function SELECT($select, $tables, $where){

        $respuesta= ModelQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }
/* ================================================================
    QUERY INSERT
================================================================= */
    static public function INSERT($insert){

        $respuesta = ModelQueryes::INSERT($insert);
        return $respuesta;
    }
    /* ================================================================
    QUERY UPDATE
================================================================= */
    /**
     * @param $update = array(
     *    "table" => "usuarios", #nombre de tabla
     *    "valor" => $data["valor"], #nombre de columna y valor
     *    #"columna"=>"valor",#nombre de columna y valor
     *);
     *@param $where = array(
     *    "id" => $data["id"], #condifion columna y valor
     *);
     */
    static public function UPDATE($update,$where)
    {
        
                 
        $respuesta = ModelQueryes::UPDATE($update,$where);
        return $respuesta;
    }
    /* ================================================================
    QUERY DELETE
================================================================= */
    /**
     * @param $delete=array(
     *               "table"=>"personas",
     *               "id" => $val
     *); */
    static public function DELETE($delete)
    {

        $respuesta = ModelQueryes::DELETE($delete);
        return $respuesta;
    }
}