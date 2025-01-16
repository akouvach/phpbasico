<?php 
include_once("common.php"); 
include_once("db.php"); 

        session_unset();
        session_destroy();

        // if(isset($_SESSION["id"])){
        //         unset($_SESSION["id"]);
        // }

        // if(isset($_SESSION["is_admin"])){
        //         unset($_SESSION["is_admin"]);
        // }

        // if(isset($_SESSION["nombre"])){
        //         unset($_SESSION["nombre"]);
        // }

        header("Location: index.php");
        die();
?>