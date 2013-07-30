<?php
    
    session_start();
    include_once('dbconn.php');
    
    $rxpatient = $db->query("SELECT DISTINCT Patient_Name, Patient_Group FROM ".$_SESSION['prefix']."_Rx WHERE Pack = true AND HOA_ID='PRN'");
    //fix this whole thing.
    $patid = $dbh->prepare("SELECT Patient_ID FROM Patient WHERE Patient_Name = :ptname AND Patient_Group = :ptgroup AND Deletion_Code_PD <> '#' AND Deletion_Code_PT <> '#';");
    $rxbypatient=$dbh->prepare("SELECT A.Rx_ID, A.Rx_Number, A.HOA_ID, A.Rx_Stop_Date, A.Rx_Start_Date, A.Sig_QuantityPerDose, C.Drug_Name FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Drug AS C ON A.Drug_Code=C.Drug_Code WHERE A.Patient_Name = :ptname2 AND A.Patient_Group = :ptgroup2 AND Pack = true AND HOA_ID='PRN'");

    
    while($prnres=$rxpatient->fetch_object()){
        
        $patid->execute(array(':ptname'=>$prnres->Patient_Name,':ptgroup'=>$prnres->Patient_Group));
        $rez=$patid->fetch(PDO::FETCH_OBJ);
        $patientID=$rez->Patient_ID;
        
        $rxbypatient->execute(array(':ptname2'=>$prnres->Patient_Name,':ptgroup2'=>$prnres->Patient_Group));
        
        while($bpres=$rxbypatient->fetch(PDO::FETCH_OBJ)){
            echo "<div id=\"div".$bpres->Rx_ID."\"><h3><code>".$prnres->Patient_Group."</code> ".$prnres->Patient_Name." ".$bpres->Rx_Number."</h3><h5>".$bpres->Drug_Name."</h5><form id=\"f".$bpres->Rx_ID."\" autocomplete=\"off\" ><h6> Tablets per dose: ".$bpres->Sig_QuantityPerDose."</h6>";
            echo "<label>Number of Doses:</label><div class=\"pad4\"><input type=\"text\" id=\"".$bpres->Rx_ID."prnqty\" placeholder=\"Quantity\" autcomplete=\"off\" name=\"prnqty\"><br>";
            echo "<button class=\"btn btn-success\" type=\"button\" onclick=\"packPRN('".$bpres->Rx_ID."','".$patientID."');\">Pack</button></div></div>";
            
        }
    }
    
?>
