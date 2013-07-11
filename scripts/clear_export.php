<?php

    session_start();
    include_once('dbconn.php');
    
    $dltexport = $db->query("TRUNCATE ".$_SESSION["prefix"]."_Export;")

?>
