<?php

    session_start();
    include_once('dbconn.php');
    $pid = $_POST['patientid'];
    $dcode=$_POST['drugcode'];
    $doc=$_POST['doctor'];
    $rxnum=$_POST['rxnumber'];
    $rph=$_POST['rph'];
    $instruct=$_POST['instructions'];
    
    $insrtexp=$dbh->prepare("INSERT INTO ".$_SESSION['prefix']."_Export (Patient_ID, Tracker, Drug_Code, Admin_Date, Admin_Time, Quantity, Doctor, Rx_Number, Instructions, Bag_Type, Pharmacist) VALUES (:pid, :tracker, :drugcode,:admindate,:admintime,:quantity,:doctor,:rxnumber,:instructions,:bagtype,:rph)");
    
    $params = array();
    parse_str($_POST['datastring'],$params);
    $i=0;
    foreach($params['admindate'] as $data){
        if($params['quantity'][$i]>0){
            $admtime = date("Hi",strtotime($params['admintime'][$i]));
            $admdate = date("Ymd",strtotime($data));
            $insrtexp->execute(array(':pid'=>$pid,':tracker'=>"0000",':drugcode'=>$dcode,':admindate'=>$admdate,':admintime'=>$admtime,':quantity'=>$params['quantity'][$i],':doctor'=>$doc,':rxnumber'=>$rxnum,':instructions'=>  substr($instruct,0,50),':bagtype'=>"M",':rph'=>$rph));
        }
        $i=$i+1;
    }
    
    $deletehelp=$db->query("DELETE FROM ".$_SESSION['prefix']."_HOA WHERE Rx_Number = '".$rxnum."'");
    
    $checkquantity = $db->query("SELECT * FROM ".$_SESSION['prefix']."_HOA");
    if($checkquantity->num_rows>0){
        echo 1;
    }else{
        echo 0;
    }
    
?>
