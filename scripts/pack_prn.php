<?php
    
    session_start();
    include_once('dbconn.php');
    
    $rxid = $_POST['rxid'];
    $qty = $_POST['quantity'];
    $pid = $_POST['patient'];
    
    $insrtexport=$dbh->prepare("INSERT INTO ".$_SESSION['prefix']."_Export (Patient_ID, Tracker, Drug_Code, Admin_Date, Admin_Time, Quantity, Doctor, Rx_Number, Instructions, Bag_Type, Pharmacist) VALUES (:pid,:tracker, :drugcode,:admindate,:admintime,:quantity,:doctor,:rxnumber,:instructions,:bagtype,:rph)");
    
    $getdata=$db->query("SELECT A.Drug_Code, A.Doctor, A.Rx_Number, A.RPH, A.Sig_QuantityPerDose, B.Line1, B.Line2, B.Line3, B.Line4, B.Line5, B.Line6, B.Line7, B.Line8 FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS B ON A.Sig_Code = B.Sig_Code WHERE Rx_ID = ".$rxid);
    
    while($pres=$getdata->fetch_object()){
        $ins = $pres->Line1." ".$pres->Line2." ".$pres->Line3." ".$pres->Line4." ".$pres->Line5." ".$pres->Line6." ".$pres->Line7." ".$pres->Line8;
        
        $i = 0;
        do{
            echo $i;
            $insrtexport->execute(array(':pid'=>$pid,':tracker'=>"333",'drugcode'=>$pres->Drug_Code,':admindate'=>"20140619",':admintime'=>"0800",':quantity'=>$pres->Sig_QuantityPerDose,':doctor'=>$pres->Doctor,':rxnumber'=>$pres->Rx_Number,':instructions'=>$ins,':bagtype'=>"P",':rph'=>$pres->RPH));
            $i++;
        }while($i<$qty);
        
    }
    echo "Done.";
?>
