<?php

    $insrt=$db->query("INSERT INTO ".$_SESSION["prefix"]."_Rx (Patient_Group,Patient_Wing,Patient_Name,Rx_Number,HOA_Code,Rx_Stop_Date,Rx_Start_Date,RPH,Doctor,Drug_Code,Sig_QuantityPerDose,Sig_Code) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."');");

?>
