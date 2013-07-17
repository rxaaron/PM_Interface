<?php

    session_start();
    include_once('dbconn.php');
    
    $rmv = $db->query("DELETE FROM ".$_SESSION['prefix']."_Export WHERE Admin_Time ='".$_POST['time']."' AND Tracker='".$_POST['tracker']."';");
    
?>
