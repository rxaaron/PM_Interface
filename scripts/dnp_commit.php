<?php
   
    session_start();
    include_once('dbconn.php');
    
    $slctdrugtodc = $db->query("SELECT Drug_Code FROM Drug WHERE Drug_ID = ".$_POST['drugid'].";");
    
    while($dcres=$slctdrugtodc->fetch_object()){
        
        $dinsert=$db->query("INSERT INTO Drugs_Never_Packed (Drug_Code) VALUES ('".$dcres->Drug_Code."');");
        
    }
    
?>
