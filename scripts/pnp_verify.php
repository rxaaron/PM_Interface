<?php
   
    session_start();
    include_once('dbconn.php');
    
    $slctpt = $db->query("SELECT Patient_Name, Patient_Group FROM Patient WHERE Patient_ID = ".$_POST['pid'].";");
    
    while($pres=$slctpt->fetch_object()){

        echo "<h2>".$pres->Patient_Name."</h2><h3>Group: ".$pres->Patient_Group."</h3><p>will be marked as Never Pack.</p>";
        echo "<button class=\"btn btn-success\" data-dismiss=\"modal\" aria-hidden=\"true\" id=\"gopnpbtn\" onclick=\"markpt(".$_POST['pid'].",'".$pres->Patient_Name."');\" >Never Pack this Patient!</button>";
    }
    
?>
