
    <?php
    $perms = $_SESSION["permisos"];
    $dashboard = 0; #1
    $pedidos = 0; #2
    $clientes = 0; #3
    $usarios = 0; #4
    for ($i = 0; $i < count($perms); $i++) {
        if ($perms[$i]['id_permiso'] == 1) {
            $dashboard = 1;
        }
        if ($perms[$i]['id_permiso'] == 2) {
            $pedidos = 2;
        }
        if ($perms[$i]['id_permiso'] == 3) {
            $clientes = 3;
        }
        if ($perms[$i]['id_permiso'] == 4) {
            $usarios = 4;
        }
    }
    if (isset($_GET["ruta"])) {

        if ($_GET["ruta"] == "dashboard") {
            if ($dashboard == 1) {
                include "resources/views/dashboard/" . $_GET["ruta"] . ".php";
            } else {
                include "resources/error/404.php";
            }
        } elseif (
            $_GET["ruta"] == "pedidos-pedidos" ||
            $_GET["ruta"] == "pedidos-export"
        ) {
            if ($pedidos == 2) {
                $ruta = explode('-', $_GET["ruta"]);
                include "resources/views/pedidos/" . $ruta[1] . ".php";
            } else {
                include "resources/error/404.php";
            }
        } elseif (
            $_GET["ruta"] == "clientes-clientes" ||
            $_GET["ruta"] == "clientes-export"
        ) {
            if ($clientes == 3) {
                $ruta = explode('-', $_GET["ruta"]);
                include "resources/views/clientes/" . $ruta[1] . ".php";
            } else {
                include "resources/error/404.php";
            }
        } elseif (
            $_GET["ruta"] == "usuarios-usuarios" ||
            $_GET["ruta"] == "usuarios-export"
        ) {
            if ($usarios == 4) {
                $ruta = explode('-', $_GET["ruta"]);
                include "resources/views/users/" . $ruta[1] . ".php";
            } else {
                include "resources/error/404.php";
            }
        } elseif ($_GET["ruta"] == "salir") {
            #salir login
            include "resources/views/login/salir.php";
        } else {
            #si no hay ruta :get error
            include "resources/error/404.php";
        }
    } else {
        include "resources/views/dashboard/dashboard.php";
    }


    ?>
