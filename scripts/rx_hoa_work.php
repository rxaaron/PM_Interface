<?php

   
    session_start();
    include_once('dbconn.php');
    
    //background work for HOA Codes.

    $slctsql="SELECT Rx_ID, Patient_Group, Patient_Name, Patient_Wing, HOA_Code, Drug_Code FROM ".$_SESSION["prefix"]."_Rx;";
    $hoaslct = $db->query($slctsql);
    
    if ($hoaslct){
        
        $test1=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = :hoagroup AND HOA_Wing = :hoawing ;");
        $test2=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = :hoagroup AND HOA_Wing = '';");
        $test3=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = '' AND HOA_Wing = '';");
        $insrtHOA=$dbh->prepare("UPDATE ".$_SESSION["prefix"]."_Rx SET HOA_ID = :hoaid WHERE Rx_ID = :rxid ;");
        $dnpslct=$dbh->prepare("SELECT DNP_ID FROM Drugs_Never_Packed WHERE Drug_Code = :dcode ;");
        $pnpslct=$dbh->prepare("SELECT B.PNP_ID FROM Patient AS A INNER JOIN Patient_Never_Packed AS B ON A.Patient_ID = B.Patient_ID WHERE A.Patient_Name = :pname AND A.Patient_Group=:pgroup");
        
        while($hoares=$hoaslct->fetch_object()){
            
           $dnpslct->execute(array(':dcode'=>$hoares->Drug_Code));
           $pnpslct->execute(array(':pname'=>$hoares->Patient_Name,':pgroup'=>$hoares->Patient_Group));
           if($dnp=$dnpslct->fetch(PDO::FETCH_OBJ)){
               $dlt = $db->query("DELETE FROM ".$_SESSION["prefix"]."_Rx WHERE Rx_ID = ".$hoares->Rx_ID.";");
           }elseif($pnp=$pnpslct->fetch(PDO::FETCH_OBJ)){
               $dlt = $db->query("DELETE FROM ".$_SESSION["prefix"]."_Rx WHERE Rx_ID = ".$hoares->Rx_ID.";");
           }else{    
            if($hoares->HOA_Code==="PRN"){
                $insrtHOA->execute(array(':hoaid'=>"PRN",':rxid'=>$hoares->Rx_ID));
                
                }elseif($hoares->HOA_Code==="RX"){
                    $insrtHOA->execute(array(':hoaid'=>"RX",':rxid'=>$hoares->Rx_ID));
                }else{
                    $test1->execute(array(':hoacode'=>$hoares->HOA_Code,':hoagroup'=>$hoares->Patient_Group,':hoawing'=>$hoares->Patient_Wing));
                    $test2->execute(array(':hoacode'=>$hoares->HOA_Code,':hoagroup'=>$hoares->Patient_Group));
                    $test3->execute(array(':hoacode'=>$hoares->HOA_Code));
                    if($data1=$test1->fetch(PDO::FETCH_OBJ)){
                        echo "data1 = ".$data1->HOA_ID."  ".$hoares->Rx_ID."<br>";
                        //$data1=$test1->fetch(PDO::FETCH_OBJ);
                        $insrtHOA->execute(array(':hoaid'=>$data1->HOA_ID,':rxid'=>$hoares->Rx_ID));
                    }elseif($data2=$test2->fetch(PDO::FETCH_OBJ)){
                        echo "data2 = ".$data2->HOA_ID."  ".$hoares->Patient_Group."<br>";
                        //$data2=$test2->fetch(PDO::FETCH_OBJ);
                        $insrtHOA->execute(array(':hoaid'=>$data2->HOA_ID,':rxid'=>$hoares->Rx_ID));
                    }elseif($data3=$test3->fetch(PDO::FETCH_OBJ)){
                        //$data3=$test3->fetch(PDO::FETCH_OBJ);
                        echo "data3 = ".$data3->HOA_ID."  ".$hoares->Rx_ID."<br>";
                        $insrtHOA->execute(array(':hoaid'=>$data3->HOA_ID,':rxid'=>$hoares->Rx_ID));
                    }else{
                        $insrtHOA->execute(array(':hoaid'=>"0",':rxid'=>$hoares->Rx_ID));
                    }
                }        
            }
        }
    }else{
        
    }

?>