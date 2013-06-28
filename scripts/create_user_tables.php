<?php

$createRx = "CREATE TABLE `pacmed_interface`.`".$newprefix."_Rx` ( `Rx_ID` int( 3 ) NOT NULL AUTO_INCREMENT ,`Patient_Group` varchar( 10 ) NOT NULL ,`Patient_Wing` varchar( 10 ) DEFAULT NULL ,`Patient_Name` varchar( 50 ) NOT NULL ,`Rx_Number` varchar( 10 ) NOT NULL ,`HOA_Code` varchar( 5 ) DEFAULT NULL ,`Rx_Stop_Date` varchar( 13 ) NOT NULL ,`Rx_Start_Date` varchar( 13 ) NOT NULL ,`RPH` varchar( 5 ) DEFAULT NULL ,`Doctor` varchar( 25 ) NOT NULL ,`Drug_Code` varchar( 15 ) NOT NULL ,`Sig_QuantityPerDose` varchar( 5 ) NOT NULL ,`Sig_Code` varchar( 15 ) NOT NULL ,`Pack` bit( 1 ) NOT NULL DEFAULT b'1',PRIMARY KEY ( `Rx_ID` ) );";

$createExport = "CREATE TABLE `pacmed_interface`.`".$newprefix."_Export` ( `Export_ID` int( 3 ) NOT NULL AUTO_INCREMENT ,`Patient_ID` int( 3 ) NOT NULL ,`Drug_ID` int( 3 ) NOT NULL ,`Admin_Date` varchar( 15 ) NOT NULL ,`Admin_Time` varchar( 10 ) NOT NULL ,`Quantity` varchar( 5 ) NOT NULL ,`Doctor` varchar( 25 ) NOT NULL ,`Rx_Number` varchar( 15 ) NOT NULL ,`Comment` varchar( 50 ) DEFAULT NULL ,`Instructions` varchar( 100 ) NOT NULL ,`Bag_Type` varchar( 5 ) NOT NULL ,`Pharmacist` varchar( 5 ) DEFAULT NULL ,PRIMARY KEY ( `Export_ID` ) );";

$rx = $db->query($createRx);
if($rx){
    $export=$db->query($createExport);
    if($export){
        //it works!!!
    }else{
        echo "different failure";
    }
}else{
    echo "failure";
}

?>