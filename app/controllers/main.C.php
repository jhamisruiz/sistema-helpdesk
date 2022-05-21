<?php
session_start();
class ControllerMain
{

    static public function ctrMain()
    { ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php
            include "resources/components/links-css.php";
            ?>
        </head>

        <body>
            <?php
            $sgbd = Conexion::tryConex();

            if ($sgbd["error"] == "error") {

                include "resources/error/sgbd.php";
            } else {
                if (isset($_SESSION["loginSession"]) && $_SESSION["loginSession"] == "OK") {

            ?>
                    <div id="app">
                        <?php include "resources/components/siderbar.php"; ?>
                        <div id="main" class="d-none"></div>
                        <div class='layout-navbar '>
                            <?php
                            include "resources/components/header.php";
                            ?>
                            <div id="main-content">
                                <?php
                                include "resources/main.php";
                                ?>
                            </div>
                        </div>
                    </div>

                    <div id="smsconfirmations"></div>
                    <script src="public/assets/js/main.js"></script>
            <?php

                } else {
                    if (isset($_GET["ruta"])) {
                        if ($_GET["ruta"] == "login" || $_GET["ruta"] == "sign-up") {
                            include "resources/views/login/" . $_GET["ruta"] . ".php";
                        } else {
                            include "resources/views/login/login.php";
                        }
                    } else {
                        include "resources/views/index/head.php";
                        include "resources/views/index/index.php";
                    }
                }
            }
            include "resources/components/script.php";

            ?>

        </body>

        </html>

<?php
    }
}
?>