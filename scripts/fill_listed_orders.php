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
    
        $select=$db->query("SELECT A.Rx_ID, A.Patient_Name, A.Rx_Number, A.HOA_Code, A.Sig_QuantityPerDose, B.Drug_Name, C.Line1, C.Line2, C.Line3, A.Pack FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS C ON A.Sig_Code=C.Sig_Code INNER JOIN Drug AS B ON A.Drug_Code = B.Drug_Code WHERE A.HOA_ID <> '0' ORDER BY A.Patient_Name, B.Drug_Name;");
    
    if($select){
        $pname = "";
        $tablestart= "<table class=\"table table-striped\"><thead><tr><th>Pack?</th><th>Rx Number</th><th>Drug</th><th>Sig</th><th>HOA/QtyPerDose</th></tr></thead><tbody>";
        $tableend= "</tbody></table>";
        $first=true;
        while($results=$select->fetch_object()){
            if($pname===$results->Patient_Name){
                echo "<tr><td><input type=\"checkbox\" value=\"".$results->Rx_Number."\" id=\"".$results->Rx_ID."\" onclick=\"checkchange(this.id,this.value);\"";
                if($results->Pack == 1){
                    echo "checked=\"checked\">";
                }else{
                    echo ">";
                }
                echo "</td><td>".$results->Rx_Number."</td><td>".$results->Drug_Name."</td><td>".$results->Line1." ".$results->Line2." ".$results->Line3."</td><td>".$results->HOA_Code." / ".$results->Sig_QuantityPerDose."</td></tr>";
            }else{
                if(!$first){
                    echo $tableend;
                }
                $pname=$results->Patient_Name;
                echo "<h3>".$pname." <div class=\"pad4 btn-group\"><button class=\"btn btn-mini btn-success\" onclick=\"changeall('".$pname."',true);\">Add All</button><button class=\"btn btn-mini btn-danger\" onclick=\"changeall('".$pname."',false);\">Remove All</button></div></h3>";
                echo $tablestart;
                echo "<tr><td><input type=\"checkbox\" value=\"".$results->Rx_Number."\" id=\"".$results->Rx_ID."\" onclick=\"checkchange(this.id,this.value);\"";
                if($results->Pack == 1){
                    echo "checked=\"checked\">";
                }else{
                    echo ">";
                }
                echo "</td><td>".$results->Rx_Number."</td><td>".$results->Drug_Name."</td><td>".$results->Line1." ".$results->Line2." ".$results->Line3."</td><td>".$results->HOA_Code." / ".$results->Sig_QuantityPerDose."</td></tr>";
                $first=false;
            }
        }
        
    }
?>
