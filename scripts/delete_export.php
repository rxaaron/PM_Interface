<?php

    session_start();
    include_once('dbconn.php');
    
    $dltexport = $db->query("DELETE FROM ".$_SESSION["prefix"]."_Export WHERE Rx_Number = '".$_POST['rxnumber']."' AND Admin_Time = '".$_POST['admintime']."'");

?>
