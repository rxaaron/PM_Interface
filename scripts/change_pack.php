<?php

    session_start();
    include('dbconn.php');
    
    $changepack = $db->query("UPDATE ".$_SESSION['prefix']."_Rx SET Pack = ".$_POST['status']." WHERE Rx_ID = ".$_POST['rxid'].";");

?>
