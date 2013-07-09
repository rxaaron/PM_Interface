<?php
   
    session_start();
    include_once('dbconn.php');
    
    //Actual generation of tables.
    
        $select=$db->query("SELECT A.Rx_ID, A.Patient_Name, A.Patient_Group, A.Rx_Number, A.HOA_Code, A.Sig_QuantityPerDose, B.Drug_ID, B.Drug_Name, C.Line1, C.Line2, C.Line3, A.Pack FROM ".$_SESSION['prefix']."_Rx AS A INNER JOIN Sig AS C ON A.Sig_Code=C.Sig_Code INNER JOIN Drug AS B ON A.Drug_Code = B.Drug_Code WHERE A.HOA_ID <> '0' ORDER BY A.Patient_Name, B.Drug_Name;");
    
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
                echo "</td><td>".$results->Rx_Number."</td><td><a href=\"#drugadmin\" data-toggle=\"modal\" onclick=\"drugadmin(".$results->Drug_ID.");\" >".$results->Drug_Name."</a></td><td>".$results->Line1." ".$results->Line2." ".$results->Line3."</td><td>".$results->HOA_Code." / ".$results->Sig_QuantityPerDose."</td></tr>";
            }else{
                if(!$first){
                    echo $tableend;
                }
                $pname=$results->Patient_Name;
                echo "<h3><code>".$results->Patient_Group."</code> ".$pname." <div class=\"pad4 btn-group\"><button class=\"btn btn-mini btn-success\" onclick=\"changeall('".$pname."',true);\">Add All</button><button class=\"btn btn-mini btn-danger\" onclick=\"changeall('".$pname."',false);\">Remove All</button></div></h3>";
                echo $tablestart;
                echo "<tr><td><input type=\"checkbox\" value=\"".$results->Rx_Number."\" id=\"".$results->Rx_ID."\" onclick=\"checkchange(this.id,this.value);\"";
                if($results->Pack == 1){
                    echo "checked=\"checked\">";
                }else{
                    echo ">";
                }
                echo "</td><td>".$results->Rx_Number."</td><td><a href=\"#drugadmin\" data-toggle=\"modal\" onclick=\"drugadmin(".$results->Drug_ID.");\" >".$results->Drug_Name."</a></td><td>".$results->Line1." ".$results->Line2." ".$results->Line3."</td><td>".$results->HOA_Code." / ".$results->Sig_QuantityPerDose."</td></tr>";
                $first=false;
            }
        }
        
    }
?>
