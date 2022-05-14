<?php
/* ***** ******* CONFIG ****************** */
require './app/config/config.php';
require "./app/models/conexPDO.php";

/* =====================================================================
        MODEL ...
========================================================================*/
require_once "app/models/query/querys.M.php";
// require_once "app/models/query/SPquerys.M.php";

/// PEDIDOS
require_once "app/models/pedidos/pedidos.M.php";
/* =====================================================================
        MODEL USUARIOS....
========================================================================*/
require_once "app/models/clientes/clientes.M.php";
require_once "app/models/users/usuarios.M.php";
/* =====================================================================
      
-----CONTROLLER-----
========================================================================*/
require_once "app/controllers/config/config.C.php";
require_once "app/controllers/query/querys.C.php";
/* =====================================================================
        PEDIDOS CONTROLLER 
========================================================================*/
require_once "app/controllers/pedidos/pedidos.C.php";
require_once "app/controllers/pedidos/categorias.C.php";
/* =====================================================================
        USUARIOS CONTROLLER 
========================================================================*/
require_once "app/controllers/clientes/clientes.C.php";
require_once "app/controllers/users/usuarios.C.php";


/* ----------------------------------------------------------
   ---------------------login---------------------------------- */
require_once "app/controllers/login/login.C.php";
/* ----------------------------------------------------------
   -----------------------FUNCTIONS----------------------------------- */
require_once "app/php/functions.php";


/* =====================================================================
        CONTROLLER main app
========================================================================*/
require_once "app/controllers/main.C.php";

$main = new ControllerMain();
$main->ctrMain();

//or 1=1;--';