<?php
    
    $slct=$db->query("SELECT HOA_ID FROM HOA WHERE HOA_Code='".$data[0]."';");
    
    if($slct->num_rows!=0){
        
        while($res=$slct->fetch_object()){
            $updt=$db->query("UPDATE HOA SET HOA_Code='".$data[0]."',HOA_Group='".$data[1]."',HOA_Wing='".$data[2]."',SkipDays='".$data[3]."',Frequency='".$data[4]."',Time7='".$data[5]."',Time8='".$data[6]."',Time9='".$data[7]."',Time10='".$data[8]."',Time11='".$data[9]."',Time12='".$data[10]."' WHERE HOA_ID=".$res->HOA_ID.";");
        }
    }else{
       
        $insrt=$db->query("INSERT INTO HOA (HOA_Code,HOA_Group,HOA_Wing,SkipDays,Frequency,Time7,Time8,Time9,Time10,Time11,Time12) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."');");
    }
    $timechange=true;
    
?>