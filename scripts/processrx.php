<?php
    session_start();
    include_once('dbconn.php');
    
    $tracker=date("ymdhis");
    $requireswork = 0;
    $start = $_POST['start'];
    $stop = $_POST['stop'];
    $cutoff = $_POST['cutoff'];
    $cutType=$_POST['cuttype'];
    
    $patid = $dbh->prepare("SELECT Patient_ID FROM Patient WHERE Patient_Name = :ptname AND Patient_Group = :ptgroup AND Deletion_Code_PD <> '#' AND Deletion_Code_PT <> '#';");
    $rxbypatient=$dbh->prepare("SELECT A.Rx_Number, A.HOA_ID, A.Rx_Stop_Date, A.Rx_Start_Date, A.RPH, A.Doctor, A.Drug_Code, A.Sig_QuantityPerDose, B.Line1, B.Line2, B.Line3, B.Line4, B.Line5, B.Line6, B.Line7, B.Line8, C.Drug_Category, D.WarfDDI, F.Medical_Record_Number FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS B ON A.Sig_Code=B.Sig_Code INNER JOIN Drug AS C ON A.Drug_Code = C.Drug_Code INNER JOIN FGroup AS E ON A.Patient_Group = E.Group_Name INNER JOIN Facility AS D ON E.Facility_ID = D.Facility_ID INNER JOIN Patient AS F ON A.Patient_Name = F.Patient_Name WHERE A.Patient_Name = :ptname2 AND A.Patient_Group = :ptgroup2 AND Pack = true");
    $insrtexport=$dbh->prepare("INSERT INTO ".$_SESSION['prefix']."_Export (Patient_ID, Tracker, Drug_Code, Admin_Date, Admin_Time, Quantity, Doctor, Rx_Number, Instructions, Bag_Type, Pharmacist) VALUES (:pid,:tracker, :drugcode,:admindate,:admintime,:quantity,:doctor,:rxnumber,:instructions,:bagtype,:rph)");
    $gethoa=$dbh->prepare("SELECT Admin_Time FROM HOA_Time WHERE HOA_ID = :hoaid");
    $insrthelp=$dbh->prepare("INSERT INTO ".$_SESSION['prefix']."_HOA (Rx_Number,Drug_Name,Patient_Name,Instructions,Doctor, RPh) VALUES (:rxnumber2, :drugname2,:pname2, :instructions2, :doctor2, :rph2)");
    $rxpatient = $db->query("SELECT DISTINCT Patient_Name, Patient_Group FROM ".$_SESSION['prefix']."_Rx WHERE Pack = true");
    while($rxres=$rxpatient->fetch_object()){
        
       $patid->execute(array(':ptname'=>$rxres->Patient_Name,':ptgroup'=>$rxres->Patient_Group));
       $rez=$patid->fetch(PDO::FETCH_OBJ);
       $patientID=$rez->Patient_ID;
        
        $rxbypatient->execute(array(':ptname2'=>$rxres->Patient_Name,':ptgroup2'=>$rxres->Patient_Group));
            
        while($bypatres=$rxbypatient->fetch(PDO::FETCH_OBJ)){
            
            if($bypatres->HOA_ID != "PRN" AND $bypatres->HOA_ID != "RX" AND $bypatres->HOA_ID != "0"){
                $curDate = strtotime($start);
                if($bypatres->WarfDDI==true AND $bypatres->Medical_Record_Number==="W" AND $bypatres->Drug_Category==="WFDDI"){
                   $insrtexport->execute(array(':pid'=>$patientID,':tracker'=>$tracker,':drugcode'=>"WF_DDI",':admindate'=>date("Ymd",strtotime($curdate." + 2 days")),':admintime'=>"0800",':quantity'=>'1.00',':doctor'=>$bypatres->Doctor,':rxnumber'=>$bypatres->Rx_Number,':instructions'=>substr($bypatres->Line1." ".$bypatres->Line2." ".$bypatres->Line3." ".$bypatres->Line4." ".$bypatres->Line5." ".$bypatres->Line6." ".$bypatres->Line7." ".$bypatres->Line8,0,50),':bagtype'=>"M",':rph'=>$bypatres->RPH)); 
                }
                    
                do{
                
                    $gethoa->execute(array(':hoaid'=>$bypatres->HOA_ID));
                    while($hoarez=$gethoa->fetch(PDO::FETCH_OBJ)){
                        if(strtotime($bypatres->Rx_Start_Date)<=$curDate AND $curDate<=strtotime($bypatres->Rx_Stop_Date)){
                            if($curDate==strtotime($start)){
                           
                                //must be after cutoff time
                                if(strtotime($cutoff)<strtotime($hoarez->Admin_Time)){
                                    $insrtexport->execute(array(':pid'=>$patientID,':tracker'=>$tracker,':drugcode'=>$bypatres->Drug_Code,':admindate'=>date("Ymd",$curDate),':admintime'=>$hoarez->Admin_Time,':quantity'=>$bypatres->Sig_QuantityPerDose,':doctor'=>$bypatres->Doctor,':rxnumber'=>$bypatres->Rx_Number,':instructions'=>substr($bypatres->Line1." ".$bypatres->Line2." ".$bypatres->Line3." ".$bypatres->Line4." ".$bypatres->Line5." ".$bypatres->Line6." ".$bypatres->Line7." ".$bypatres->Line8,0,50),':bagtype'=>"M",':rph'=>$bypatres->RPH));
                                }
                            }elseif ($curDate==strtotime($stop) AND $cutType != 'daily'){
                                
                                //must be before cutoff time, cutoff ignored for daily batches.
                                if(strtotime($cutoff)>strtotime($hoarez->Admin_Time)){
                                    $insrtexport->execute(array(':pid'=>$patientID,':tracker'=>$tracker,':drugcode'=>$bypatres->Drug_Code,':admindate'=>date("Ymd",$curDate),':admintime'=>$hoarez->Admin_Time,':quantity'=>$bypatres->Sig_QuantityPerDose,':doctor'=>$bypatres->Doctor,':rxnumber'=>$bypatres->Rx_Number,':instructions'=>substr($bypatres->Line1." ".$bypatres->Line2." ".$bypatres->Line3." ".$bypatres->Line4." ".$bypatres->Line5." ".$bypatres->Line6." ".$bypatres->Line7." ".$bypatres->Line8,0,50),':bagtype'=>"M",':rph'=>$bypatres->RPH));
                                }
                            }else{
                               
                                //cutoff time does not matter
                                $insrtexport->execute(array(':pid'=>$patientID,':tracker'=>$tracker,':drugcode'=>$bypatres->Drug_Code,':admindate'=>date("Ymd",$curDate),':admintime'=>$hoarez->Admin_Time,':quantity'=>$bypatres->Sig_QuantityPerDose,':doctor'=>$bypatres->Doctor,':rxnumber'=>$bypatres->Rx_Number,':instructions'=>substr($bypatres->Line1." ".$bypatres->Line2." ".$bypatres->Line3." ".$bypatres->Line4." ".$bypatres->Line5." ".$bypatres->Line6." ".$bypatres->Line7." ".$bypatres->Line8,0,50),':bagtype'=>"M",':rph'=>$bypatres->RPH));
                            }
                        }
                    }
                $curDate=strtotime("+1 day",$curDate);
                }while($curDate<=strtotime($stop));
           }elseif($bypatres->HOA_ID=="RX"){
                //this is going to be horrible.
               $requireswork=1;
                $insrthelp->execute(array(':rxnumber2'=>$bypatres->Rx_Number,':drugname2'=>$bypatres->Drug_Code,':pname2'=>$patientID,':instructions2'=>substr($bypatres->Line1." ".$bypatres->Line2." ".$bypatres->Line3." ".$bypatres->Line4." ".$bypatres->Line5." ".$bypatres->Line6." ".$bypatres->Line7." ".$bypatres->Line8,0,75),':doctor2'=>$bypatres->Doctor,':rph2'=>$bypatres->RPH));
            //}else{
                
            }
        }
    }
   echo $requireswork;
    
?>
