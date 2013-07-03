<?php
   
    session_start();
    include_once('dbconn.php');
    

    $slctsql="SELECT Rx_ID, Patient_Group, Patient_Wing, HOA_Code FROM ".$_SESSION["prefix"]."_Rx;";
    $hoaslct = $db->query($slctsql);
    
    if ($hoaslct){
        
        $test1=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = :hoagroup AND HOA_Wing = :hoawing ;");
        $test2=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode AND HOA_Group = :hoagroup ;");
        $test3=$dbh->prepare("SELECT HOA_ID FROM HOA WHERE HOA_Code = :hoacode ;");
        $insrtHOA=$dbh->prepare("UPDATE ".$_SESSION["prefix"]."_Rx SET HOA_ID = :hoaid WHERE Rx_ID = :rxid ;");
        
        while($hoares=$hoaslct->fetch_object()){
            if($hoares->HOA_Code==="PRN"){
                $insrtHOA->execute(array(':hoaid'=>0,':rxid'=>$hoares->Rx_ID));
                echo $hoares->HOA_Code."<br>";
            }else{
                $test1->execute(array(':hoacode'=>$hoares->HOA_Code,':hoagroup'=>$hoares->Patient_Group,':hoawing'=>$hoares->Patient_Wing));
                $test2->execute(array(':hoacode'=>$hoares->HOA_Code,':hoagroup'=>$hoares->Patient_Group));
                $test3->execute(array(':hoacode'=>$hoares->HOA_Code));
                if($data1=$test1->fetch(PDO::FETCH_OBJ)){
                    echo $data1->HOA_ID."  ".$hoares->Rx_ID." line1<br>";
                    //$data1=$test1->fetch(PDO::FETCH_OBJ);
                    $insrtHOA->execute(array(':hoaid'=>$data1->HOA_ID,':rxid'=>$hoares->Rx_ID));
                }elseif($data2=$test2->fetch(PDO::FETCH_OBJ)){
                    echo $data2->HOA_ID."  ".$hoares->Rx_ID." line2<br>";
                    //$data2=$test2->fetch(PDO::FETCH_OBJ);
                    $insrtHOA->execute(array(':hoaid'=>$data2->HOA_ID,':rxid'=>$hoares->Rx_ID));
                }elseif($data3=$test3->fetch(PDO::FETCH_OBJ)){
                    //$data3=$test3->fetch(PDO::FETCH_OBJ);
                    echo $data3->HOA_ID."  ".$hoares->Rx_ID." line3<br>";
                    $insrtHOA->execute(array(':hoaid'=>$data3->HOA_ID,':rxid'=>$hoares->Rx_ID));
                }else{
                    echo "We got one with no HOA!!!<br>";
                }
           }
        }
    }else{
        
    }
?>
