<?php
   
    session_start();
    include_once('dbconn.php');
  
    $deletesql = $db->query("DELETE A FROM Daily_History A, Daily_History B WHERE A.Rx_Number = B.Rx_Number AND A.Admin_Date = B.Admin_Date AND A.Admin_Time = B.Admin_Time AND A.History_ID < B.History_ID");
    
    $grabremainder = $db->query("INSERT INTO Batch_History (Batch_Name, Batch_Creator,Batch_Date,Patient_ID,Drug_Code,Admin_Date,Admin_Time,Quantity,Doctor,Rx_Number,Instructions,Bag_Type,Pharmacist) SELECT Batch_Name, Batch_Creator,Batch_Date,Patient_ID,Drug_Code,Admin_Date,Admin_Time,Quantity,Doctor,Rx_Number,Instructions,Bag_Type,Pharmacist FROM Daily_History WHERE Restock = False");
    
    $cleardaily = $db->query("TRUNCATE Daily_History");
    
?>