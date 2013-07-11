<?php
    
    session_start();
    include_once('dbconn.php');
    $slctexp=$db->query("SELECT * FROM a101050179_Export");
    while($expres=$slctexp->fetch_object()){
        echo "bob";
    }
?>
