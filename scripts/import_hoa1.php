<?php
    
    $slct=$db->query("SELECT HOA_ID FROM HOA WHERE HOA_Code='".$data[0]."';");
    
    if($slct->num_rows!=0){
        
        while($res=$slct->fetch_object()){
            $updt=$db->query("UPDATE HOA SET HOA_Code='".$data[0]."',HOA_Group='".$data[1]."',HOA_Wing='".$data[2]."',SkipDays='".$data[3]."',Frequency='".$data[4]."',Time1='".$data[5]."',Time2='".$data[6]."',Time3='".$data[7]."',Time4='".$data[8]."',Time5='".$data[9]."',Time6='".$data[10]."' WHERE HOA_ID=".$res->HOA_ID.";");
        }
    }else{
       
        $insrt=$db->query("INSERT INTO HOA (HOA_Code,HOA_Group,HOA_Wing,SkipDays,Frequency,Time1,Time2,Time3,Time4,Time5,Time6) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."');");
    }
    $timechange=true;
?>
