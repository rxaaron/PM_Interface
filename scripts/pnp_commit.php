<?php
   
    session_start();
    include_once('dbconn.php');

    $dinsert=$db->query("INSERT INTO Patient_Never_Packed (Patient_ID) VALUES (".$_POST['pid'].");");

    
?>