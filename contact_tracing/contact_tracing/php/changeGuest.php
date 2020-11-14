<?php
    session_start();
    $_SESSION["currentID"] = isset($_POST["currentID"]) ? $_POST["currentID"] : "0";
    // print_r($_SESSION);
?>