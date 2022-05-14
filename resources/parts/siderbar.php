<?php
$perms = $_SESSION["permisos"];
$active = '';
if (isset($_GET["ruta"])) {
    $ruta = explode('-', $_GET["ruta"]);
    $ruta[0] = ($_GET["ruta"] == '') ? "dashboard" : $ruta[0];
    $active = ' active';
} else {
    $ruta[0] = 'dashboard';
    $active = ' active';
}

?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="dashboard"><img src="https://studio.tailorbrands.com/images/logo_small_red.svg" style="height:80px"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu </li>
                <?php
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
                if ($dashboard == 1) {
                ?>

                    <li class="sidebar-item  <?php if (isset($ruta) && $ruta[0] == 'dashboard') echo $active ?>">
                        <a href="dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                <?php
                }
                if ($pedidos == 2) {
                ?>
                    <li class="sidebar-title">Ventas</li>

                    <li class="sidebar-item  has-sub <?php if (isset($ruta) && $ruta[0] == 'pedidos') echo $active ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-file-earmark-medical-fill"></i>
                            <span>Pedidos</span>
                        </a>
                        <ul class="submenu  <?php if (isset($ruta) && $ruta[0] == 'pedidos') echo $active ?>">
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'pedidos') echo $active ?>">
                                <a href="pedidos-pedidos">Pedidos</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[0] == 'pedidos' && $ruta[1] == 'export') echo $active ?>">
                                <a href="pedidos-export">Exportar</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                if ($clientes == 3) {
                ?>
                    <li class="sidebar-item has-sub <?php if (isset($ruta) && $ruta[0] == 'clientes') echo $active ?>">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-file-earmark-medical-fill"></i>
                            <span>Clientes</span>
                        </a>
                        <ul class="submenu  <?php if (isset($ruta) && $ruta[0] == 'clientes') echo $active ?>">
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'clientes') echo $active ?>">
                                <a href="clientes-clientes">Cliente</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[0] == 'clientes' && $ruta[1] == 'export') echo $active ?>">
                                <a href="clientes-export">Exportar</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                if ($usarios == 4) {
                ?>
                    <li class="sidebar-title">MANTENIMIENTO</li>

                    <li class="sidebar-item has-sub  <?php if (isset($ruta) && $ruta[0] == 'usuarios') echo $active ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-person-badge" style='font-size:18px'></i>
                            <span>Usuarios</span>
                        </a>
                        <ul class="submenu <?php if (isset($ruta) && $ruta[0] == 'usuarios') echo $active ?>">
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'usuarios') echo $active ?>">
                                <a href="usuarios-usuarios">Usuarios</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[0] == 'usuarios' && $ruta[1] == 'export') echo $active ?>">
                                <a href="usuarios-export">Exportar</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>