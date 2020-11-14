<?php
    session_start();
    $_SESSION["currentAttID"] = isset($_POST["currentAttID"]) ? $_POST["currentAttID"] : "0";
    // print_r($_SESSION);
?>