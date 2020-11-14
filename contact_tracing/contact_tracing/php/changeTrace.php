<?php
    session_start();
    $_SESSION["currentTraceID"] = isset($_POST["currentTraceID"]) ? $_POST["currentTraceID"] : "0";
    // print_r($_SESSION);
?>