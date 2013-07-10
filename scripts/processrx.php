<?php
    session_start();
    include_once('dbconn.php');
    
    $start = $_POST['start'];
    $stop = $_POST['stop'];
    $cutoff = $_POST['cutoff'];
    
    //$patid = $dbh->prepare("SELECT Patient_ID FROM Patient WHERE Patient_Name = :ptname AND Patient_Group = :ptgroup AND Deletion_Code_PD <> '#' AND Deletion_Code_PT <> '#';");
    //$rxbypatient=$dbh->prepare("SELECT A.Rx_Number, A.HOA_ID, A.Rx_Stop_Date, A.Rx_Start_Date, A.RPH, A.Doctor, A.Drug_Code, A.Sig_QuantityPerDose, B.Line1, B.Line2, B.Line3, B.Line4, B.Line5, B.Line6, B.Line7, B.Line8 FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS B ON A.Sig_Code=B.Sig_Code WHERE A.Patient_Name = :ptname2 AND A.Patient_Group = :ptgroup2 AND Pack = true;");
    $rxpatient = $db->query("SELECT DISTINCT Patient_Name, Patient_Group FROM ".$_SESSION['prefix']."_Rx WHERE Pack = true;");
    while($rxres=$rxpatient->fetch_object()){
        
       // $patid->execute(array(':ptname'=>$rxres->Patient_Name,':ptgroup'=>$rxres->Patient_Group));
       // $rez=$patid->fetch(PDO::FETCH_OBJ);
      //  $patientID=$rez->Patient_ID;
        echo "bob";
    /**    $rxbypatient->execute(array(':ptname2'=>$rxres->Patient_Name,':ptgroup2'=>$rxres->Patient_Group));
        while($rxres=$rxbypatient->fetch("PDO::FETCH_OBJ")){
            $curDate = strtotime($start);
            $i=0;
            do{
                echo $rxres->Rx_Number." ".$rxres->HOA_ID." ".$rxres->Rx_Stop_Date." ".$rxres->Rx_Start_Date." ".$rxres->RPH." ".$rxres->Doctor." ".$rxres->Drug_Code." ".$rxres->Sig_QuantityPerDose;
                echo "<br>".$curDate."<br>";
                $i=$i+1;
                $curDate=strtotime($curDate." + 1 day");
            }while($i<5);
        }**/
    }
    
?>
