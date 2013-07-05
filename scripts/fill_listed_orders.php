<?php
   
    session_start();
    include_once('dbconn.php');
    
    //background work for HOA Codes.

    $slctsql="SELECT Rx_ID, Patient_Group, Patient_Wing, HOA_Code FROM ".$_SESSION["prefix"]."_Rx;";
    $hoaslct = $db->query($slctsql);
    
    if ($hoaslct){
        
        $test1=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = :hoagroup AND HOA_Wing = :hoawing ;");
        $test2=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = :hoagroup ;");
        $test3=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode ;");
        $insrtHOA=$dbh->prepare("UPDATE ".$_SESSION["prefix"]."_Rx SET HOA_ID = :hoaid WHERE Rx_ID = :rxid ;");
        
        while($hoares=$hoaslct->fetch_object()){
            if($hoares->HOA_Code==="PRN"){
                $insrtHOA->execute(array(':hoaid'=>"PRN",':rxid'=>$hoares->Rx_ID));
                
            }elseif($hoares->HOA_Code==="RX"){
                $insrtHOA->execute(array(':hoaid'=>"RX",':rxid'=>$hoares->Rx_ID));
            }else{
                $test1->execute(array(':hoacode'=>$hoares->HOA_Code,':hoagroup'=>$hoares->Patient_Group,':hoawing'=>$hoares->Patient_Wing));
                $test2->execute(array(':hoacode'=>$hoares->HOA_Code,':hoagroup'=>$hoares->Patient_Group));
                $test3->execute(array(':hoacode'=>$hoares->HOA_Code));
                if($data1=$test1->fetch(PDO::FETCH_OBJ)){
                    
                    //$data1=$test1->fetch(PDO::FETCH_OBJ);
                    $insrtHOA->execute(array(':hoaid'=>$data1->HOA_ID,':rxid'=>$hoares->Rx_ID));
                }elseif($data2=$test2->fetch(PDO::FETCH_OBJ)){
                    
                    //$data2=$test2->fetch(PDO::FETCH_OBJ);
                    $insrtHOA->execute(array(':hoaid'=>$data2->HOA_ID,':rxid'=>$hoares->Rx_ID));
                }elseif($data3=$test3->fetch(PDO::FETCH_OBJ)){
                    //$data3=$test3->fetch(PDO::FETCH_OBJ);
                    
                    $insrtHOA->execute(array(':hoaid'=>$data3->HOA_ID,':rxid'=>$hoares->Rx_ID));
                }else{
                    $insrtHOA->execute(array(':hoaid'=>"0",':rxid'=>$hoares->Rx_ID));
                }
           }
        }
    }else{
        
    }
    
    //Actual generation of tables.
    
        $select=$db->query("SELECT A.Patient_Name, A.Rx_Number, A.HOA_Code, A.Sig_QuantityPerDose, B.Drug_Name, C.Line1, C.Line2, C.Line3 FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS C ON A.Sig_Code=C.Sig_Code INNER JOIN Drug AS B ON A.Drug_Code = B.Drug_Code WHERE A.HOA_ID <> '0';");
    
    if($select){
        echo "<table class=\"table table-striped\">";
        echo "<thead><tr><th>File Name</th><th>Last Update Time</th></tr></thead>";
        echo "<tbody>";
        while($results=$select->fetch_object()){
            echo "<tr><td>".$results->Table_Name."</td><td>".$results->UpdateTime."</td></tr>";
        }
        echo "</tbody></table>";
    }
?>
