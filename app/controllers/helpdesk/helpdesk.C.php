<?php
class helpdeskController
{
    static public function LISTCHAT($data)
    {
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());

        $sql = "SELECT 
            H.id,H.id_cliente,  (select S.mensaje FROM chat S WHERE S.id=(select max(id) as id from chat where id_cliente= H.id_cliente) ) as mensaje,
            (select S.fecha_registro FROM chat S WHERE S.id=(select max(id) as id from chat where id_cliente= H.id_cliente) ) as fecha_registro,
            C.names,C.last_name, C.razon_social,C.phone,C.email,H.prioridad
            FROM chat H INNER JOIN clientes C ON H.id_cliente=C.id
            GROUP BY H.id_cliente
        ";
        $chat = ModelQueryes::SQL($sql);

        for ($i = 0; $i < count($chat); $i++) {
            $date1 = new DateTime($chat[$i]['fecha_registro']);
            $date2 = new DateTime("now");
            $diff = $date1->diff($date2);

            $chat[$i]['fecha_registro'] = get_format($diff);
            # code...
        }
        return $chat;
    }
    static public function LISTF2FCHAT($id)
    {
        ini_set('date.timezone', 'America/Lima');
        $fecha = date('Y-m-d H:i:s', time());
        $sql = "SELECT 
            H.id,H.id_cliente,  H.mensaje, H.fecha_registro, 
            C.names,C.last_name, C.razon_social,C.phone,C.email
            FROM chat H INNER JOIN clientes C ON H.id_cliente=C.id 
            WHERE H.id_cliente=$id
        ";
        $chat = ModelQueryes::SQL($sql);

        for ($i = 0; $i < count($chat); $i++) {
            $date1 = new DateTime($chat[$i]['fecha_registro']);
            $date2 = new DateTime("now");
            $diff = $date1->diff($date2);
            //$id= $chat[$i]['id'];
            $images = ControllerQueryes::SELECT(["*" => "*"], ["imagenes"=>""], ["id_chat=" => $chat[$i]['id']]);
            $chat[$i]['imagenes']= $images;
            $chat[$i]['img_length'] = count($images);

            $chat[$i]['fecha_registro'] = get_format($diff);
            # code...
        }
        return $chat;
    }
}

function get_format($df)
{

    $str = '';
    $str .= ($df->invert == 1) ? ' - ' : '';
    if ($df->y > 0) {
        // years
        $str .= ($df->y > 1) ? $df->y . ' Y ' : $df->y . ' Y ';
    }
    if ($df->m > 0) {
        // month
        $str .= ($df->m > 1) ? $df->m . ' M ' : $df->m . ' M ';
    }
    if ($df->d > 0) {
        // days
        $str .= ($df->d > 1) ? $df->d . ' D ' : $df->d . ' D ';
    }
    if ($df->h > 0) {
        // hours
        $str .= ($df->h > 1) ? $df->h . ' H ' : $df->h . ' H ';
    }
    if ($df->i > 0) {
        // minutes
        $str .= ($df->i > 1) ? $df->i . ' Min ' : $df->i . ' Min ';
    }
    if ($df->s > 0) {
        // seconds
        $str .= ($df->s > 1) ? $df->s . ' Sec ' : $df->s . ' Sec ';
    }

    return $str;
}
