<?php
    
    session_start();
    include_once('dbconn.php');
    
    $rxpatient = $db->query("SELECT DISTINCT Patient_Name, Patient_Group FROM ".$_SESSION['prefix']."_Rx WHERE Pack = true AND HOA_ID='PRN'");
    //fix this whole thing.
    $patid = $dbh->prepare("SELECT Patient_ID FROM Patient WHERE Patient_Name = :ptname AND Patient_Group = :ptgroup AND Deletion_Code_PD <> '#' AND Deletion_Code_PT <> '#';");
    $rxbypatient=$dbh->prepare("SELECT A.Rx_Number, A.HOA_ID, A.Rx_Stop_Date, A.Rx_Start_Date, A.RPH, A.Doctor, A.Drug_Code, A.Sig_QuantityPerDose, C.Drug_Name, B.Line1, B.Line2, B.Line3, B.Line4, B.Line5, B.Line6, B.Line7, B.Line8 FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS B ON A.Sig_Code=B.Sig_Code INNER JOIN Drug AS C ON A.Drug_Code=C.Drug_Code WHERE A.Patient_Name = :ptname2 AND A.Patient_Group = :ptgroup2 AND Pack = true AND HOA_ID='PRN'");

    
    while($prnres=$rxpatient->fetch_object()){
        
        $patid->execute(array(':ptname'=>$prnres->Patient_Name,':ptgroup'=>$prnres->Patient_Group));
        $rez=$patid->fetch(PDO::FETCH_OBJ);
        $patientID=$rez->Patient_ID;
        
        $rxbypatient->execute(array(':ptname2'=>$prnres->Patient_Name,':ptgroup2'=>$prnres->Patient_Group));
        
        while($bpres=$rxbypatient->fetch(PDO::FETCH_OBJ)){
            echo "<div id=\"div".$bpres->Rx_Number."\"><h3><code>".$prnres->Patient_Group."</code> ".$prnres->Patient_Name." ".$bpres->Rx_Number."</h3><h5>".$bpres->Drug_Name."</h5><form id=\"f".$bpres->Rx_Number."\" autocomplete=\"off\" >";
            echo "<label>Number of Doses:</label><div class=\"pad4\"><input type=\"text\" id=\"prnqty\" placeholder=\"Quantity\" autcomplete=\"off\" name=\"prnqty\">";
            echo "<button class=\"btn btn-success\" type=\"button\" onclick=\"packPRN('".$bpres->Patient_ID."','".$bpres->Drug_Code."','".$bpres->Doctor."','".$bpres->Rx_Number."','".$bpres->RPh."');\">Pack</button></div>";
            
        }
    }
    
?>
