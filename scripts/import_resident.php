<?php
    
    $slct=$db->query("SELECT Patient_ID FROM Patient WHERE Patient_Name = '".$data[3]."' AND Patient_Group = '".$data[0]."';");
    
    if($slct->num_rows!=0){
        
        while($res=$slct->fetch_object()){
            $updt=$db->query("UPDATE Patient SET Patient_Group='".$data[0]."',Wing='".$data[1]."',Room='".$data[2]."',Patient_Name='".$data[3]."',Medical_Record_Number='".$data[4]."',Deletion_Code_PD='".$data[5]."',Deletion_Code_PT'".$data[6]."' WHERE Patient_ID=".$res->Patient_ID.";");
        }
    }else{
       
        $insrt=$db->query("INSERT INTO Patient (Patient_Group,Wing,Room,Patient_Name,Medical_Record_Number,Deletion_Code_PD,Deletion_Code_PT) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."');");
    }
    
?>
