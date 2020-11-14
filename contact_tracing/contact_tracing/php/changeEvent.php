<?php
    session_start();
    $_SESSION["currentEventID"] = isset($_POST["currentEventID"]) ? $_POST["currentEventID"] : "0";
    // print_r($_SESSION);
?>