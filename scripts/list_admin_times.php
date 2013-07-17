<?php

    session_start();
    include_once('dbconn.php');
    
    $tracker = $db->query("SELECT Tracker FROM ".$_SESSION['prefix']."_Export ORDER BY Export_ID DESC LIMIT 1;");
    
    $track1 = $tracker->fetch_object();
    
    $trackid= $track1->Tracker;
    
    $timeselect=$db->query("SELECT DISTINCT Admin_Time FROM ".$_SESSION['prefix']."_Export WHERE Tracker ='".$trackid."';");
    
    while($res4=$timeselect->fetch_object()){
        echo "<button type=\"button\" id=\"".$res4->Admin_Time."\" class=\"btn btn-info btn-block\" onClick=\"rmvtime('".$res4->Admin_Time."','".$trackid."');\">".date("H:i",strtotime($res4->Admin_Time))."</button>"; 
    }
    

?>
