<?php

    session_start();
    include('dbconn.php');
    
    $datalist = $db->query("SELECT B.Patient_Name, B.Patient_Group, B.Wing, B.Room, C.NDC, A.Admin_Date, A.Admin_Time, A.Quantity, A.Doctor, A.Rx_Number, A.Instructions, C.Generic_Description, C.Drug_Name, A.Bag_Type, A.Pharmacist FROM ".$_SESSION['prefix']."_Export AS A INNER JOIN Patient AS B ON A.Patient_ID=B.Patient_ID INNER JOIN Drug AS C ON A.Drug_Code=C.Drug_Code");
    
    $content="";
    $filename="/home/gmap/pacmedfiles/".$_POST['fn'].".txt";
    while($rz=$datalist->fetch_object()){
        $content=$content.str_pad("",5).str_pad($rz->Patient_Name,35).str_pad("",20).str_pad($rz->Patient_Group,4).str_pad($rz->Wing,5).str_pad("",5).str_pad($rz->Room,6).str_pad($rz->NDC,11).str_pad($rz->Admin_Date,8).str_pad($rz->Admin_Time,4).str_pad($rz->Quantity,9,"0",STR_PAD_LEFT).str_pad($rz->Doctor,25).str_pad($rz->Rx_Number,8).str_pad("",88).str_pad($rz->Instructions,90).str_pad("",177).str_pad($rz->Generic_Description,30).str_pad($rz->Drug_Name,27).str_pad($rz->Bag_Type,1).str_pad("",60).str_pad($rz->Pharmacist,3)."\r\n";
    }
    $handle=fopen($filename,"a");
    fwrite($handle,$content);
?>
