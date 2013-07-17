<?php
    session_start();
    include_once('dbconn.php');
    
    $ssselect=$db->query("SELECT A.Rx_Number, A.Patient_Name, A.Patient_Group, B.Drug_Name, A.Rx_Stop_Date, A.Rx_Start_Date FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Drug AS B ON A.Drug_Code = B.Drug_Code WHERE (A.Rx_Stop_Date BETWEEN ".date("Ymd",strtotime($_POST['start']))." AND ".date("Ymd",strtotime($_POST['stop'])).") OR (A.Rx_Start_Date BETWEEN ".date("Ymd",strtotime($_POST['start']))." AND ".date("Ymd",strtotime($_POST['stop'])).");");
    
    while($ssrez=$ssselect->fetch_object()){
        echo "123";
    }
?>
